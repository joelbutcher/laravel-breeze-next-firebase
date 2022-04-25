// Core
import useSWR from 'swr'
import axios from '@/lib/axios'
import { useEffect } from 'react'
import { useRouter } from 'next/router'

// Firebase
import auth from '@/app/firebase';
import * as FirebaseAuth from 'firebase/auth'
import { OAuthProvider } from 'firebase/auth';

export const useFirebaseAuth = ({ middleware, redirectIfAuthenticated } = {}) => {
    const router = useRouter()

    const { data: user, error, mutate } = useSWR('/api/user', () =>
        axios
            .get('/api/user', {

            })
            .then(res => res.data)
            .catch(error => {
                if (error.response.status !== 409) throw error

                router.push('/verify-email')
            }),
    )

    const csrf = () => axios.get('/sanctum/csrf-cookie')

    const sendSignInLink = async ({ setErrors, setSessionStatus, email }) => {
        setErrors([])

        FirebaseAuth.sendSignInLinkToEmail(auth, email, {
            url: window.location.href,
            handleCodeInApp: true,
        })
            .then(() => {
                localStorage.setItem('emailForSignIn', email)
                setSessionStatus('We\'ve sent you a link. Please check your inbox.')
            })
    }

    const signInFromEmail = async ({ setErrors }) => {
        if (! FirebaseAuth.isSignInWithEmailLink(auth, window.location.href)) {
            setErrors([
                'An error occurred signing you in.',
            ])
        }

        let email = localStorage.getItem('emailForSignIn')

        if (! email) {
            email = window.prompt('Please provide your email for confirmation')
        }

        FirebaseAuth.signInWithEmailLink(auth, email, window.location.href)
            .then(async (result) => {
                const { user } = result
                const credentials = OAuthProvider.credentialFromResult(result)

                connect({
                    user,
                    credentials,
                    setErrors,
                    setSessionStatus,
                })
            })
    }

    const signInWithProvider = ({provider, setErrors, setSessionStatus}) => {
        const AuthProvider = provider.firebaseProvider

        if (provider.scopes?.length > 0) {
            provider.scopes.forEach((scope) => AuthProvider.addScope(scope))
        }

        FirebaseAuth.signInWithPopup(auth, AuthProvider)
            .then((result) => {
                const { user } = result
                const credentials = OAuthProvider.credentialFromResult(result)

                connect({
                    user,
                    credentials,
                    setErrors,
                    setSessionStatus,
                })
            })
    }

    const connect = async ({user, credentials, setErrors, setSessionStatus}) => {
        const token = await user.getIdToken()

        await csrf()

        axios.post('/user/connect', {}, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        })
        .then((res) => {
            mutate()
        })
        .catch(error => {
            if (error.response.status !== 422) throw error

            setErrors(Object.values(error.response.data.errors).flat())
        })
    }

    const signInWithProviderCallback = ({user, credential, additionalUserInfo}) => {
        console.log(user, credential, additionalUserInfo);
        // user.getIdToken().then((token) => {
        //     console.log({
        //         name: user.displayName,
        //         email: user.email,
        //         email_verified: user.email_verified,
        //         phone: user.phoneNumber,
        //         photo_url: user.photoURL,
        //         uid: user.uid,
        //         provider: user.providerData.shift()?.providerId,
        //         token,
        //     })
        // })

        return false
    }

    const signInWithProviderFailedCallback = error => {
        console.log(error)
    }

    const sendEmailVerification = ({ setStatus }) => {

    }

    const logout = async () => {
        if (! error) {
            await axios
                .post('/logout')
                .then(() => mutate())
        }

        window.location.pathname = '/login'
    }

    useEffect(() => {
        if (middleware === 'guest' && redirectIfAuthenticated && user) router.push(redirectIfAuthenticated)
        if (middleware === 'auth' && error) logout()
    }, [user, error])

    return {
        user,
        sendSignInLink,
        signInFromEmail,
        signInWithProvider,
        signInWithProviderCallback,
        signInWithProviderCallback,
        sendEmailVerification,
        logout,
    }
}
