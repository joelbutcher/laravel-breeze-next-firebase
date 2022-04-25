import Link from 'next/link'
import { useState } from 'react'
import ApplicationLogo from '@/components/ApplicationLogo'
import AuthCard from '@/components/AuthCard'
import GuestLayout from '@/components/Layouts/GuestLayout'
import AuthValidationErrors from '@/components/AuthValidationErrors'
import AuthSessionStatus from '@/components/AuthSessionStatus'
import SignInWithEmail from '@/components/SignInWithEmail'
import SocialAuth from '@/components/SocialAuth'

const Auth = () => {
    const [signInWithEmailSelected, setSignInWithEmailSelected] = useState(false);
    const [errors, setErrors] = useState([])
    const [sessionStatus, setSessionStatus] = useState(null)

    return (
        <GuestLayout>
            <AuthCard
                logo={
                    <Link href="/">
                        <a>
                            <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </Link>
                }>

                {/* Session Status */}
                <AuthSessionStatus className="mb-4" status={sessionStatus} />

                {/* Validation Errors */}
                <AuthValidationErrors className="mb-4" errors={errors} />

                {signInWithEmailSelected ? (
                    <>
                        <SignInWithEmail setErrors={setErrors} setSessionStatus={setSessionStatus} />

                        <div className="flex flex-row items-center justify-between py-4 text-gray-500">
                            <hr className="w-full mr-2" />
                                Or
                            <hr className="w-full ml-2" />
                        </div>

                        <div className="flex justify-center">
                            <button
                                onClick={() => setSignInWithEmailSelected(false)}
                                className="hover:underline"
                            >
                                Use SSO
                            </button>
                        </div>
                    </>
                ) : (
                    <>
                        <SocialAuth
                            setErrors={setErrors}
                            setSessionStatus={setSessionStatus}
                        />

                        <div className="flex flex-row items-center justify-between py-4 text-gray-500">
                            <hr className="w-full mr-2" />
                                Or
                            <hr className="w-full ml-2" />
                        </div>

                        <div className="flex justify-center">
                            <button
                                onClick={() => setSignInWithEmailSelected(true)}
                                className="hover:underline"
                            >
                                Sign in with Email
                            </button>
                        </div>
                    </>
                )}
            </AuthCard>
        </GuestLayout>
    )
}

export default Auth;
