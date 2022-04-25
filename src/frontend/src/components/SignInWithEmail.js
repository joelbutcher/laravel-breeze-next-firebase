import { useState } from 'react'
import Button from '@/components/Button'
import Input from '@/components/Input'
import Label from '@/components/Label'
import { useEmailSignIn } from '@/hooks/useEmailSignIn'

const SignInWithEmail = ({ setErrors, setSessionStatus }) => {
    const [email, setEmail] = useState('')
    const { sendSignInLink } = useEmailSignIn(setErrors);

    const submitForm = async event => {
        event.preventDefault()
        sendSignInLink({ email, setErrors, setSessionStatus })
    }

    return (
        <form onSubmit={submitForm}>
            {/* Email Address */}
            <div>
                <Label htmlFor="email">Email</Label>

                <Input
                    id="email"
                    type="email"
                    value={email}
                    className="block mt-1 w-full"
                    onChange={event => setEmail(event.target.value)}
                    required
                    autoFocus
                />
            </div>

            <div className="flex items-center justify-end mt-4">
                <Button className="ml-3">Sign In with Email</Button>
            </div>
        </form>
    )
}

export default SignInWithEmail
