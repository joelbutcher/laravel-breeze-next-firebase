import { useEffect } from 'react'
import { useRouter } from 'next/router'
import { useFirebaseAuth } from '@/hooks/firebaseAuth'

export const useEmailSignIn = setErrors => {
    const router = useRouter()

    const {
        sendSignInLink,
        signInFromEmail,
     } = useFirebaseAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    });

    useEffect(() => {
        if (isFromSignInWithEmail()) {
            signInFromEmail({ setErrors })
        }
    }, [router])

    const isFromSignInWithEmail = () =>
        router.query.hasOwnProperty('apiKey') &&
        router.query.hasOwnProperty('oobCode') &&
        router.query.hasOwnProperty('mode') &&
        router.query.mode === 'signIn'

    return {
        sendSignInLink,
    }
}
