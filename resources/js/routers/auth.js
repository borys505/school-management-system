import configRoutes from './config';
import utilityRoutes from './utility';

export default [
    {
        path: '/dashboard',
        component: () => import('@views/dashboard' /* webpackChunkName: "js/dashboard" */)
    },
    {
        path: '/product/about',
        component: () => import('@views/product/about' /* webpackChunkName: "js/product/about" */)
    },
    {
        path: '/product/update',
        component: () => import('@views/product/update' /* webpackChunkName: "js/product/update" */)
    },
    {
        path: '/product/support',
        component: () => import('@views/product/support' /* webpackChunkName: "js/product/support" */)
    },
    {
        path: '/change/password',
        component: () => import('@views/auth/change-password' /* webpackChunkName: "js/auth/change-password" */)
    },
    {
        path: '/setup',
        component: () => import('@views/setup/index' /* webpackChunkName: "js/setup" */)
    },
    {
        path: '/configuration',
        component: () => import('@views/configuration/layout/index' /* webpackChunkName: "js/configuration" */),
        children: [
        	...configRoutes
        ]
    },
    {
        path: '/utility',
        component: () => import('@views/utility/layout/index' /* webpackChunkName: "js/utility" */),
        children: [
        	...utilityRoutes
        ]
    },
    {
        path: '/academic',
        component: () => import('@views/academic/index' /* webpackChunkName: "js/academic/index" */)
    },
    {
        path: '/academic/session',
        component: () => import('@views/academic/session/index' /* webpackChunkName: "js/academic/session/index" */)
    },
    {
        path: '/academic/session/:id/edit',
        component: () => import('@views/academic/session/edit' /* webpackChunkName: "js/academic/session/edit" */)
    },
    {
        path: '/finance/account',
        component: () => import('@views/finance/account/index' /* webpackChunkName: "js/finance/account/index" */)
    },
    {
        path: '/finance/account/:id/edit',
        component: () => import('@views/finance/account/edit' /* webpackChunkName: "js/finance/account/edit" */)
    },
    {
        path: '/finance/report',
        component: () => import('@views/finance/report' /* webpackChunkName: "js/finance/report" */)
    },
    {
        path: '/finance/fee/report/summary',
        component: () => import('@views/finance/fee/report/summary' /* webpackChunkName: "js/finance/fee/report/summary" */)
    },
    {
        path: '/finance/fee/report/concession',
        component: () => import('@views/finance/fee/report/concession' /* webpackChunkName: "js/finance/fee/report/concession" */)
    },
    {
        path: '/finance/fee/report/due',
        component: () => import('@views/finance/fee/report/due' /* webpackChunkName: "js/finance/fee/report/due" */)
    },
    {
        path: '/finance/fee/report/payment',
        component: () => import('@views/finance/fee/report/payment' /* webpackChunkName: "js/finance/fee/report/payment" */)
    },
    {
        path: '/finance/transaction/report/summary',
        component: () => import('@views/finance/transaction/report/summary' /* webpackChunkName: "js/finance/transaction/report/summary" */)
    },
    {
        path: '/finance/transaction/report/day-book',
        component: () => import('@views/finance/transaction/report/day-book' /* webpackChunkName: "js/finance/transaction/report/day-book" */)
    },
    {
        path: '/employee',
        component: () => import('@views/employee/index' /* webpackChunkName: "js/employee/index" */)
    },
    {
        path: '/employee/leave',
        component: () => import('@views/employee/leave/index' /* webpackChunkName: "js/employee/leave/index" */)
    },
    {
        path: '/employee/leave/allocation',
        component: () => import('@views/employee/leave/allocation/index' /* webpackChunkName: "js/employee/leave/allocation/index" */)
    },
    {
        path: '/employee/leave/allocation/:uuid/edit',
        component: () => import('@views/employee/leave/allocation/edit' /* webpackChunkName: "js/employee/leave/allocation/edit" */)
    },
    {
        path: '/employee/leave/request',
        component: () => import('@views/employee/leave/request/index' /* webpackChunkName: "js/employee/leave/request/index" */)
    },
    {
        path: '/employee/leave/request/create',
        component: () => import('@views/employee/leave/request/create' /* webpackChunkName: "js/employee/leave/request/create" */)
    },
    {
        path: '/employee/leave/request/:uuid/edit',
        component: () => import('@views/employee/leave/request/edit' /* webpackChunkName: "js/employee/leave/request/edit" */)
    },
    {
        path: '/employee/leave/request/:uuid',
        component: () => import('@views/employee/leave/request/show' /* webpackChunkName: "js/employee/leave/request/show" */)
    },
    {
        path: '/employee/payroll',
        component: () => import('@views/employee/payroll/index' /* webpackChunkName: "js/employee/payroll/index" */)
    },
    {
        path: '/employee/payroll/template',
        component: () => import('@views/employee/payroll/template/index' /* webpackChunkName: "js/employee/payroll/template/index" */)
    },
    {
        path: '/employee/payroll/template/create',
        component: () => import('@views/employee/payroll/template/create' /* webpackChunkName: "js/employee/payroll/template/create" */)
    },
    {
        path: '/employee/payroll/template/:uuid/edit',
        component: () => import('@views/employee/payroll/template/edit' /* webpackChunkName: "js/employee/payroll/template/edit" */)
    },
    {
        path: '/employee/payroll/salary',
        component: () => import('@views/employee/payroll/salary/index' /* webpackChunkName: "js/employee/payroll/salary/index" */)
    },
    {
        path: '/employee/payroll/salary/create',
        component: () => import('@views/employee/payroll/salary/create' /* webpackChunkName: "js/employee/payroll/salary/create" */)
    },
    {
        path: '/employee/payroll/salary/:uuid/edit',
        component: () => import('@views/employee/payroll/salary/edit' /* webpackChunkName: "js/employee/payroll/salary/edit" */)
    },
    {
        path: '/employee/payroll/transaction',
        component: () => import('@views/employee/payroll/transaction/index' /* webpackChunkName: "js/employee/payroll/transaction/index" */)
    },
    {
        path: '/employee/payroll/transaction/:uuid/edit',
        component: () => import('@views/employee/payroll/transaction/edit' /* webpackChunkName: "js/employee/payroll/transaction/edit" */)
    },
    {
        path: '/employee/payroll/list',
        component: () => import('@views/employee/payroll/list' /* webpackChunkName: "js/employee/payroll/list" */)
    },
    {
        path: '/employee/payroll/generate',
        component: () => import('@views/employee/payroll/generate' /* webpackChunkName: "js/employee/payroll/generate" */)
    },
    {
        path: '/employee/payroll/:uuid/edit',
        component: () => import('@views/employee/payroll/edit' /* webpackChunkName: "js/employee/payroll/edit" */)
    },
    {
        path: '/employee/payroll/:uuid',
        component: () => import('@views/employee/payroll/show' /* webpackChunkName: "js/employee/payroll/show" */)
    },
    {
        path: '/employee/attendance',
        component: () => import('@views/employee/attendance/index' /* webpackChunkName: "js/employee/attendance/index" */)
    },
    {
        path: '/employee/attendance/regular',
        component: () => import('@views/employee/attendance/regular' /* webpackChunkName: "js/employee/attendance/regular" */)
    },
    {
        path: '/employee/attendance/production',
        component: () => import('@views/employee/attendance/production' /* webpackChunkName: "js/employee/attendance/production" */)
    },
    {
        path: '/employee/list',
        component: () => import('@views/employee/list' /* webpackChunkName: "js/employee/list" */)
    },
    {
        path: '/employee/:uuid',
        component: () => import('@views/employee/show' /* webpackChunkName: "js/employee" */)
    },
    {
        path: '/transport/vehicle',
        component: () => import('@views/transport/vehicle/index' /* webpackChunkName: "js/transport/vehicle/index" */)
    },
    {
        path: '/transport/vehicle/:id/edit',
        component: () => import('@views/transport/vehicle/edit' /* webpackChunkName: "js/transport/vehicle/edit" */)
    },
    {
        path: '/transport/vehicle/log',
        component: () => import('@views/transport/vehicle/log/index' /* webpackChunkName: "js/transport/vehicle/log/index" */)
    },
    {
        path: '/transport/vehicle/log/:id/edit',
        component: () => import('@views/transport/vehicle/log/edit' /* webpackChunkName: "js/transport/vehicle/log/edit" */)
    },
    {
        path: '/transport/vehicle/service/record',
        component: () => import('@views/transport/vehicle/service-record/index' /* webpackChunkName: "js/transport/vehicle/service-record/index" */)
    },
    {
        path: '/transport/vehicle/service/record/:id/edit',
        component: () => import('@views/transport/vehicle/service-record/edit' /* webpackChunkName: "js/transport/vehicle/service-record/edit" */)
    },
    {
        path: '/transport/vehicle/fuel',
        component: () => import('@views/transport/vehicle/fuel/index' /* webpackChunkName: "js/transport/vehicle/fuel/index" */)
    },
    {
        path: '/transport/vehicle/fuel/:id/edit',
        component: () => import('@views/transport/vehicle/fuel/edit' /* webpackChunkName: "js/transport/vehicle/fuel/edit" */)
    },
    {
        path: '/transport/vehicle/document',
        component: () => import('@views/transport/vehicle/document/index' /* webpackChunkName: "js/transport/vehicle/document/index" */)
    },
    {
        path: '/transport/vehicle/document/:id/edit',
        component: () => import('@views/transport/vehicle/document/edit' /* webpackChunkName: "js/transport/vehicle/document/edit" */)
    },
    {
        path: '/transport/vehicle/performance/criteria',
        component: () => import('@views/transport/vehicle/performance-criteria/index' /* webpackChunkName: "js/transport/vehicle/performance-criteria/index" */)
    },
    {
        path: '/transport/vehicle/performance/criteria/:id/edit',
        component: () => import('@views/transport/vehicle/performance-criteria/edit' /* webpackChunkName: "js/transport/vehicle/performance-criteria/edit" */)
    },
    {
        path: '/transport/report',
        component: () => import('@views/transport/report' /* webpackChunkName: "js/transport/report" */)
    },
    {
        path: '/transport/vehicle/report/summary',
        component: () => import('@views/transport/vehicle/report/summary' /* webpackChunkName: "js/transport/vehicle/report/summary" */)
    },
    {
        path: '/calendar',
        component: () => import('@views/calendar/index' /* webpackChunkName: "js/calendar/index" */)
    },
    {
        path: '/calendar/holiday',
        component: () => import('@views/calendar/holiday/index' /* webpackChunkName: "js/calendar/holiday/index" */)
    },
    {
        path: '/calendar/holiday/:id/edit',
        component: () => import('@views/calendar/holiday/edit' /* webpackChunkName: "js/calendar/holiday/edit" */)
    },
    {
        path: '/calendar/event',
        component: () => import('@views/calendar/event/index' /* webpackChunkName: "js/calendar/event/index" */)
    },
    {
        path: '/calendar/event/:uuid/edit',
        component: () => import('@views/calendar/event/edit' /* webpackChunkName: "js/calendar/event/edit" */)
    },
    {
        path: '/calendar/celebration/birthday',
        component: () => import('@views/calendar/celebration/birthday' /* webpackChunkName: "js/calendar/celebration/birthday" */)
    },
    {
        path: '/calendar/celebration/anniversary',
        component: () => import('@views/calendar/celebration/anniversary' /* webpackChunkName: "js/calendar/celebration/anniversary" */)
    },
    {
        path: '/calendar/celebration/work/anniversary',
        component: () => import('@views/calendar/celebration/work-anniversary' /* webpackChunkName: "js/calendar/celebration/work-anniversary" */)
    },
    {
        path: '/frontend',
        component: () => import('@views/frontend/index' /* webpackChunkName: "js/frontend/index" */)
    },
    {
        path: '/frontend/page',
        component: () => import('@views/frontend/page/index' /* webpackChunkName: "js/frontend/page/index" */)
    },
    {
        path: '/frontend/page/:uuid/edit',
        component: () => import('@views/frontend/page/edit' /* webpackChunkName: "js/frontend/page/edit" */)
    },
    {
        path: '/frontend/page/:uuid',
        component: () => import('@views/frontend/page/edit' /* webpackChunkName: "js/frontend/page/edit" */)
    },
    {
        path: '/frontend/block',
        component: () => import('@views/frontend/block/index' /* webpackChunkName: "js/frontend/block/index" */)
    },
    {
        path: '/frontend/block/:uuid/edit',
        component: () => import('@views/frontend/block/edit' /* webpackChunkName: "js/frontend/block/edit" */)
    },
    {
        path: '/frontend/block/:uuid',
        component: () => import('@views/frontend/block/edit' /* webpackChunkName: "js/frontend/block/edit" */)
    },
    {
        path: '/frontend/menu',
        component: () => import('@views/frontend/menu/index' /* webpackChunkName: "js/frontend/menu/index" */)
    },
    {
        path: '/frontend/menu/:id/edit',
        component: () => import('@views/frontend/menu/edit' /* webpackChunkName: "js/frontend/menu/edit" */)
    },
    {
        path: '/post',
        component: () => import('@views/post/index' /* webpackChunkName: "js/post/index" */)
    },
    {
        path: '/post/article/:uuid/edit',
        component: () => import('@views/post/article/edit' /* webpackChunkName: "js/post/article/edit" */)
    },
    {
        path: '/post/article',
        component: () => import('@views/post/article/index' /* webpackChunkName: "js/post/article/index" */)
    },
    {
        path: '/post/article/:uuid/edit',
        component: () => import('@views/post/article/edit' /* webpackChunkName: "js/post/article/edit" */)
    },
    {
        path: '/post/feed',
        component: () => import('@views/post/feed/index' /* webpackChunkName: "js/post/feed/index" */)
    },
    {
        path: '/reception',
        component: () => import('@views/reception/index' /* webpackChunkName: "js/reception/index" */)
    },
    {
        path: '/reception/enquiry',
        component: () => import('@views/reception/enquiry/index' /* webpackChunkName: "js/reception/enquiry/index" */)
    },
    {
        path: '/reception/enquiry/:uuid/edit',
        component: () => import('@views/reception/enquiry/edit' /* webpackChunkName: "js/reception/enquiry/edit" */)
    },
    {
        path: '/reception/enquiry/:uuid',
        component: () => import('@views/reception/enquiry/show' /* webpackChunkName: "js/reception/enquiry/show" */)
    },
    {
        path: '/reception/visitor/log',
        component: () => import('@views/reception/visitor-log/index' /* webpackChunkName: "js/reception/visitor-log/index" */)
    },
    {
        path: '/reception/visitor/log/:uuid/edit',
        component: () => import('@views/reception/visitor-log/edit' /* webpackChunkName: "js/reception/visitor-log/edit" */)
    },
    {
        path: '/reception/visitor/message',
        component: () => import('@views/reception/visitor-message/index' /* webpackChunkName: "js/reception/visitor-message/index" */)
    },
    {
        path: '/communication',
        component: () => import('@views/communication/index' /* webpackChunkName: "js/communication/index" */)
    },
    {
        path: '/communication/sms',
        component: () => import('@views/communication/sms/index' /* webpackChunkName: "js/communication/sms/index" */)
    }
]