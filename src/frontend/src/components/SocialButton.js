import classnames from 'classnames';
import { useFirebaseAuth } from "@/hooks/firebaseAuth";

export default ({provider, setSessionStatus, setErrors}) => {
    const { signInWithProvider } = useFirebaseAuth({
        middleware: 'guest',
        redirectIfAuthenticated: '/dashboard',
    });

    const Icon = provider.icon

    const buttonClicked = () => signInWithProvider({provider, setSessionStatus, setErrors});

    return (
        <button type="button" onClick={buttonClicked} className={classnames(
            'flex w-full max-w-xs mx-auto justify-start items-center py-3 px-3 rounded-lg shadow-lg transition ease-in-out duration-200',
            provider.bgColor && provider.bgColor,
            provider.bgHoverColor && `hover:${provider.bgHoverColor}`,
            provider.textColor && provider.textColor,
            provider.textHoverColor && `hover:${provider.textHoverColor}`,
        )}>
            <Icon className="h-6 w-6 mx-2" />
            <span>{ `Sign in with ${provider.name}` }</span>
        </button>
    );
}
