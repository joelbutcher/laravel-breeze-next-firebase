import { OAuthProvider, FacebookAuthProvider, GoogleAuthProvider } from 'firebase/auth';
import SocialIconMapper from '@/constants/SocialIconMapper'


const apple = {
    id: 'apple',
    name: 'Apple',
    icon: SocialIconMapper.apple,
    bgColor: 'bg-black',
    textColor: 'text-white',
    firebaseProvider: new OAuthProvider('apple.com'),
    scopes: [],
}

const facebook = {
    id: 'facebook',
    name: 'Facebook',
    icon: SocialIconMapper.facebook,
    bgColor: 'bg-facebook-500',
    textColor: 'text-white',
    bgHoverColor: 'bg-facebook-400',
    textHoverColor: 'text-white',
    firebaseProvider: new FacebookAuthProvider(),
    scopes: [],
}

const google = {
    id: 'google',
    name: 'Google',
    icon: SocialIconMapper.google,
    textColor: 'text-gray=900',
    bgHoverColor: 'bg-gray-50',
    textHoverColor: 'text-white',
    firebaseProvider: new GoogleAuthProvider(),
    scopes: ['openid', 'profile', 'email'],
}

const github = {
    id: 'github',
    name: 'Github',
    icon: SocialIconMapper.github,
    bgColor: 'bg-gray-900',
    textColor: 'text-white',
    bgHoverColor: 'bg-gray-700',
    textHoverColor: 'text-white',
    scopes: [],
}

export default {
    apple,
    facebook,
    google,
    // github,
};
