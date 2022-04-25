<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Auth\CreatesConnectedAccounts;
use App\Contracts\Auth\CreatesNewUsers;
use App\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Symfony\Component\HttpFoundation\Response;

class ConnectedUserController extends Controller
{
    /**
     * @param  FirebaseAuth  $firebaseAuth
     * @param  UserRepositoryContract  $userRepository
     * @param  CreatesNewUsers  $createsNewUsers
     */
    public function __construct(
        protected FirebaseAuth             $firebaseAuth,
        protected UserRepositoryContract   $userRepository,
        protected CreatesNewUsers          $createsNewUsers,
        protected CreatesConnectedAccounts $createsConnectedAccounts
    ) { }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws AuthException
     * @throws FirebaseException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $token = $this->firebaseAuth->verifyIdToken(idToken: $request->bearerToken(), checkIfRevoked: true);

        $firebaseUser = $this->firebaseAuth->getUser(
            uid: $token->claims()->get('sub'),
        );

        if ($user = $this->findUser(firebaseUser: $firebaseUser)) {
            if (!$this->linkedToProvider(user: $user, firebaseUser: $firebaseUser)) {
                $this->linkProvider(user: $user, firebaseUser: $firebaseUser);
            }

            Auth::guard('web')->login($user);

            return response()->json([
                'api_token' => $user->createToken('apiToken')->plainTextToken,
                'two_factor' => false,
            ]);
        }

        return $this->newUser(firebaseUser: $firebaseUser);
    }

    /**
     * @param  UserRecord  $firebaseUser
     * @return JsonResponse
     */
    protected function newUser(UserRecord $firebaseUser)
    {
        $user = $this->createUser($firebaseUser);

        Auth::guard('web')->login($user);

        return response()->json([
            'api_token' => $user->createToken('apiToken')->plainTextToken,
            'two_factor' => false,
        ], Response::HTTP_CREATED);
    }

    /**
     * @param  UserRecord  $firebaseUser
     * @return Authenticatable|null
     */
    protected function findUser(UserRecord $firebaseUser): ?Authenticatable
    {

        $email = Arr::first($firebaseUser->providerData)?->email;

        if (is_null($email)) {
            // @todo throw exception
        }

        return $this->userRepository->findOneForEmail($email);
    }

    /**
     * @param  UserRecord  $firebaseUser
     * @return Authenticatable
     */
    protected function createUser(UserRecord $firebaseUser): Authenticatable | User
    {
        return $this->createsNewUsers->create($firebaseUser);
    }

    /**
     * @param  Authenticatable|User  $user
     * @param  UserRecord  $firebaseUser
     * @return bool
     */
    protected function linkedToProvider(Authenticatable|User $user, UserRecord $firebaseUser): bool
    {
        return !is_null($user->getConnectedAccountForUidAndProvider(
            $firebaseUser->uid,
            Arr::first($firebaseUser->providerData)?->providerId,
            Arr::first($firebaseUser->providerData)?->uid
        ));
    }

    protected function linkProvider(Authenticatable $user, UserRecord $firebaseUser): void
    {
        $this->createsConnectedAccounts->create(user: $user, firebaseUser: $firebaseUser);
    }
}
