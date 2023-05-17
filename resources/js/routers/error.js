export default [
    {
        path: '/maintenance',
        component: () => import('@views/errors/maintenance' /* webpackChunkName: "js/errors/maintenance" */)
    },
    {
        path: '*',
        component: () => import('@views/errors/page-not-found' /* webpackChunkName: "js/errors/page-not-found" */)
    }
]