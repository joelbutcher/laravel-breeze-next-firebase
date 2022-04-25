import providers from '@/constants/providers';
import SocialButton from './SocialButton';

export default ({setSessionStatus, setErrors}) => {
    return (
        <div className="flex flex-col gap-5 items-end">
            {Object.values(providers).map(provider => (
                <SocialButton
                    key={provider.id}
                    provider={provider}
                    setSessionStatus={setSessionStatus}
                    setErrors={setErrors}
                />
            ))}
        </div>
    )
}
