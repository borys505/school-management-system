export default [
    {
        path: '/',
        component: () => import('@views/pages/themes/default/home' /* webpackChunkName: "js/pages/themes/home" */)
    },
    {
        path: '/home',
        component: () => import('@views/pages/themes/default/home' /* webpackChunkName: "js/pages/themes/home" */)
    },
    {
        path: '/contact',
        component: () => import('@views/pages/themes/default/contact' /* webpackChunkName: "js/pages/themes/contact" */)
    },
    {
        path: '/events',
        component: () => import('@views/pages/themes/default/events' /* webpackChunkName: "js/pages/themes/events" */)
    },
    {
        path: '/calendar',
        component: () => import('@views/pages/themes/default/calendar' /* webpackChunkName: "js/pages/themes/calendar" */)
    },
    {
        path: '/gallery',
        component: () => import('@views/pages/themes/default/gallery' /* webpackChunkName: "js/pages/themes/gallery" */)
    },
    {
        path: '/teachers',
        component: () => import('@views/pages/themes/default/teachers' /* webpackChunkName: "js/pages/themes/teachers" */)
    },
    {
        path: '/articles',
        component: () => import('@views/pages/themes/default/articles/index' /* webpackChunkName: "js/pages/themes/articles/index" */)
    },
    {
        path: '/articles/:uuid',
        component: () => import('@views/pages/themes/default/articles/show' /* webpackChunkName: "js/pages/themes/articles/show" */)
    },
    {
        path: '/page/:page',
        component: () => import('@views/pages/themes/default/page' /* webpackChunkName: "js/pages/themes/page" */)
    }
]