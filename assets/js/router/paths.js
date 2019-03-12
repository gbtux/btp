export default [

    {
        path: '*',
        meta: {
            public: true,
        },
        redirect: {
            path: '/404'
        }
    },
    {
        path: '/404',
        meta: {
            public: true,
        },
        name: 'NotFound',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/NotFound.vue`
            )
    },
    {
        path: '/403',
        meta: {
            public: true,
        },
        name: 'AccessDenied',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/Deny.vue`
            )
    },
    {
        path: '/500',
        meta: {
            public: true,
        },
        name: 'ServerError',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/Error.vue`
            )
    },
    {
        path: '/',
        meta: { },
        name: 'Root',
        redirect: {
            name: 'Dashboard'
        }
    },
    {
        path: '/dashboard',
        meta: { breadcrumb: true, chooseTheme: true },
        name: 'Dashboard',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/Dashboard.vue`
            )
    },
    {
        path: '/estimations',
        name: 'Estimations',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/estimations/Liste.vue`
            )
    },
    {
        path: '/estimations/:id/planning',
        name: 'Planning',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/estimations/planning/Planning.vue`
        )
    },
    {
        path: '/estimations/:id',
        name: 'Estimation',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/estimations/Estimation.vue`
        )
    },
    {
        path: '/personnels',
        name: 'Personnels',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/personnels/Liste.vue`
            )
    },
    {
        path: '/fournisseurs',
        name: 'Fournisseurs',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/fournisseurs/Liste.vue`
            )
    },
    {
        path: '/contacts',
        name: 'Contacts',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/contacts/Liste.vue`
            )
    },
    {
        path: '/livraisons',
        name: 'Livraisons',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/livraisons/Liste.vue`
            )
    },
    {
        path: '/chantiers',
        name: 'Chantiers',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/chantiers/Liste.vue`
            )
    },
    {
        path: '/tests/:id',
        name: 'Test',
        component: () => import(
            /* webpackChunkName: "routes" */
            `../views/Tests.vue`
            )
    }
]
