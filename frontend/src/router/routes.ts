import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/:company_name/admin',
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
                ]
            },
            {
                path: 'ticket',
                component: () => import('src/modules/tickets/pages/AllTickets.vue')
            },
            {
                path: 'pay_ment_forms',
                component: () => import('src/modules/payMentForms/pages/AllPayMentForms.vue')
            },
            {
                path: 'history',
                component: () => import('src/modules/history/pages/History.vue')
            },
            {
                path: 'technicals',
                component: () => import('src/modules/technicals/pages/AllTechnicals.vue')
            },
            {
                path: 'register',
                children: [
                    {
                        path: 'customer',
                        component: () => import('src/modules/customer/pages/Register/RegisterCustomer.vue')
                    },
                    {
                        path: 'ticket',
                        component: () => import('src/modules/tickets/pages/Register/RegisterTickets.vue')
                    },
                    {
                        path: 'technicel',
                        component: () => import('src/modules/technicals/pages/Register/RegisterTechnicel.vue')
                    },
                    {
                        path: 'pay_ment_forms',
                        component: () => import('src/modules/payMentForms/pages/Register/RegisterPayMentForms.vue')
                    }
                ]
            },
            {
                path: 'edit',
                children: [
                    {
                        path: 'customer/:customer_id',
                        component: () => import('src/modules/customer/pages/Update/UpdateRegisterCustomer.vue')
                    }
                ]
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
