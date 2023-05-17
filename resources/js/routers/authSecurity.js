export default [
    {
        path: '/auth/security',
        component: () => import('@views/auth/security' /* webpackChunkName: "js/auth/security" */),
    },
    {
        path: '/auth/lock',
        component: () => import('@views/auth/lock' /* webpackChunkName: "js/auth/lock" */),
    }
]