import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes.js';
import store from "@/store/store.js";

const router = createRouter({
	history: createWebHistory(),
	linkActiveClass: 'active',
	routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.authenticated) {
            next('/');
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
