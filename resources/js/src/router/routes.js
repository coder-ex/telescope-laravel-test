// import HomeComponent from '@/components/board/home-component.vue';
import NotFound from '@/components/not-found.vue';
import MainComponent from '@/components/main-component.vue';
import AddProfile from '@/components/add-profile.vue';

import MainOffice from '../components/main-component.vue';

const routes = [
    // { path: '/email-verifi', component: EmailVerifi },

    { path: '/', name: 'profiles', component: MainComponent, },
    { path: '/add', name: 'add-profile', component: AddProfile, },
    // { path: '/office/profile', component: Profile },

    //--- errors
    { path: '/*', name: 'not-found', component: NotFound },
];

export default routes;