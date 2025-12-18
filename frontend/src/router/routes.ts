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
                name: 'customers.index',
                component: () => import('src/modules/customer/pages/AllCustomers.vue')
            },
            {
                path: 'ticket',
                name: 'ticket.index',
                component: () => import('src/modules/tickets/pages/AllTickets.vue')
            },
            {
                path: 'pay_ment_forms',
                name: 'pay_ment_forms.index',
                component: () => import('src/modules/payMentForms/pages/AllPayMentForms.vue')
            },
            {
                path: 'history',
                name: 'history.index',
                component: () => import('src/modules/history/pages/History.vue')
            },
            {
                path: 'technicals',
                name: 'technicals.index',
                component: () => import('src/modules/technicals/pages/AllTechnicals.vue')
            },
            {
                path: 'register',
                name: 'register',
                children: [
                    {
                        path: 'customer',
                        name: 'register.customer',
                        component: () => import('src/modules/customer/pages/Register/RegisterCustomer.vue')
                    },
                    {
                        path: 'ticket',
                        name: 'register.ticket',
                        component: () => import('src/modules/tickets/pages/Register/RegisterTickets.vue')
                    },
                    {
                        path: 'technicel',
                        name: 'register.technicel',
                        component: () => import('src/modules/technicals/pages/Register/RegisterTechnicel.vue')
                    },
                    {
                        path: 'pay_ment_forms',
                        name: 'register.pay_ment_forms',
                        component: () => import('src/modules/payMentForms/pages/Register/RegisterPayMentForms.vue')
                    }
                ]
            },
            {
                path: 'edit',
                name: 'edit',
                children: [
                    {
                        path: 'customer/:customer_id',
                        name: 'edit.customer.id',
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
