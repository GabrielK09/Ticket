const routes = [
    {
        path: '/',
        component: () => import('src/modules/index/IndexPage.vue')
    },
    {
        path: '/login',
        component: () => import('src/pages/auth/Login.vue')
    },
    {
        path: '/register',
        component: () => import('src/pages/auth/Register.vue')
    },
    // Always leave this as last one,
    // but you can also remove it
    {
        path: '/:catchAll(.*)*',
        component: () => import('src/pages/ErrorNotFound.vue'),
    },
];

export default routes;
