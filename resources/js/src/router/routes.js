
import Profile from "@/pages/Profile.vue";
import Contacts from "@/pages/Contacts.vue";
import Login from "@/pages/Login.vue";

const routes = [
	{
		path: '/',
		component: Login,
	},
	{
		path: '/profile',
		component: Profile,
        meta: {
            requiresAuth: true
        }
	},
    {
        path: '/contacts',
        component: Contacts,
        meta: {
            requiresAuth: true
        }
    },
];

export default routes;
