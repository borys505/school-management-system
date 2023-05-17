export default [
    {
        path: '/',
        component: () => import('@views/auth/login' /* webpackChunkName: "js/auth/login" */)
    },
    {
        path: '/login',
        component: () => import('@views/auth/login' /* webpackChunkName: "js/auth/login" */)
    },
    {
        path: '/password',
        component: () => import('@views/auth/password' /* webpackChunkName: "js/auth/password" */)
    },
    {
        path: '/password/reset/:token',
        component: () => import('@views/auth/reset' /* webpackChunkName: "js/auth/reset" */)
    },
    {
        path: '/install',
        component: () => import('@views/install/index' /* webpackChunkName: "js/form-wizard" */)
    }
]