import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/:company_name/admin/',
        component: () => import('src/layouts/DashBoard/DashBoardLayout.vue'),
        children: [
            {
                path: '',
                component: () => import('src/modules/index/IndexPage.vue')
            },
            {
                path: 'customers',
                children: [
                    {
                        path: '',
                        component: () => import('src/modules/customer/pages/AllCustomers.vue')
                    },
                    {
                        path: '/:company_name/register/customer',
                        component: () => import('src/modules/customer/pages/Register/RegisterCustomer.vue')
                    },
                ]
            },
            {
                path: 'ticket',
                component: () => import('src/modules/owner/pages/RegisterOwner.vue')
            }
        ]        
    },
    {
        path: '/owners',
        component: () => import('src/modules/owner/pages/OwnerIndex.vue')
    },
    {
        path: '/register',
        component: () => import('src/pages/auth/Register.vue')
    },
    {
       path: '/register/owner',
       component: () => import('src/modules/owner/pages/RegisterOwner.vue')
    },
    {
        path: '/login',
        component: () => import('src/pages/auth/Login.vue')
    },
    {
        path: '/',
        component: () => import('src/pages/home/HomePage.vue')
    },

    {
        path: '/:catchAll(.*)*',
        component: () => import('src/pages/ErrorNotFound.vue')
    },
];

export default routes;
