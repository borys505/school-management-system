export default [
    {
        path: '',
        component: () => import('@views/utility/index' /* webpackChunkName: "js/utility/index" */)
    },
    {
        path: 'todo',
        component: () => import('@views/utility/todo/index' /* webpackChunkName: "js/utility/todo/index" */)
    },
    {
        path: 'todo/:id/edit',
        component: () => import('@views/utility/todo/edit' /* webpackChunkName: "js/utility/todo/edit" */)
    },
    {
        path: 'backup',
        component: () => import('@views/utility/backup/index' /* webpackChunkName: "js/utility/backup/index" */)
    },
    {
        path: 'ip-filter',
        component: () => import('@views/utility/ip-filter/index' /* webpackChunkName: "js/utility/ip-filter/index" */),
    },
    {
        path: 'ip-filter/:id/edit',
        component: () => import('@views/utility/ip-filter/edit' /* webpackChunkName: "js/utility/ip-filter/edit" */),
    },
    {
        path: 'email-template',
        component: () => import('@views/utility/email-template/index' /* webpackChunkName: "js/utility/email-template/index" */)
    },
    {
        path: 'email-template/:id/edit',
        component: () => import('@views/utility/email-template/edit' /* webpackChunkName: "js/utility/email-template/edit" */)
    },
    {
        path: 'email-log',
        component: () => import('@views/utility/email-log/index' /* webpackChunkName: "js/utility/email-log/index" */)
    },
    {
        path: 'scheduled-job',
        component: () => import('@views/utility/scheduled-job/index' /* webpackChunkName: "js/utility/scheduled-job/index" */),
    }
]