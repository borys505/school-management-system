export default [
    {
        path: '',
        component: () => import('@views/configuration/basic/index' /* webpackChunkName: "js/configuration/basic/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'basic',
        component: () => import('@views/configuration/basic/index' /* webpackChunkName: "js/configuration/basic/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'social',
        component: () => import('@views/configuration/social/index' /* webpackChunkName: "js/configuration/social/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'system',
        component: () => import('@views/configuration/system/index' /* webpackChunkName: "js/configuration/system/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'mail',
        component: () => import('@views/configuration/mail/index' /* webpackChunkName: "js/configuration/mail/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'role',
        component: () => import('@views/configuration/role/index' /* webpackChunkName: "js/configuration/role/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: 'permission',
        component: () => import('@views/configuration/permission/index' /* webpackChunkName: "js/configuration/permission/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/permission/:module',
        component: () => import('@views/configuration/permission/module' /* webpackChunkName: "js/configuration/permission/module" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/authentication',
        component: () => import('@views/configuration/authentication/index' /* webpackChunkName: "js/configuration/authentication/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/sms',
        component: () => import('@views/configuration/sms/index' /* webpackChunkName: "js/configuration/sms/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/payment/gateway',
        component: () => import('@views/configuration/payment-gateway/index' /* webpackChunkName: "js/configuration/payment-gateway/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/locale',
        component: () => import('@views/configuration/locale/index' /* webpackChunkName: "js/configuration/locale/index" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/locale/:id/edit',
        component: () => import('@views/configuration/locale/edit' /* webpackChunkName: "js/configuration/locale/edit" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/locale/:locale',
        component: () => import('@views/configuration/locale/show' /* webpackChunkName: "js/configuration/locale/show" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/locale/:locale/:module',
        component: () => import('@views/configuration/locale/show' /* webpackChunkName: "js/configuration/locale/show" */),
        meta: { menu: 'configuration'}
    },
    {
        path: '/configuration/module',
        component: () => import('@views/configuration/module/index' /* webpackChunkName: "js/configuration/module/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/course/group',
        component: () => import('@views/configuration/academic/course-group/index' /* webpackChunkName: "js/configuration/academic/course-group/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/course/group/:id/edit',
        component: () => import('@views/configuration/academic/course-group/edit' /* webpackChunkName: "js/configuration/academic/course-group/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/institute',
        component: () => import('@views/configuration/academic/institute/index' /* webpackChunkName: "js/configuration/academic/institute/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/institute/:id/edit',
        component: () => import('@views/configuration/academic/institute/edit' /* webpackChunkName: "js/configuration/academic/institute/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/certificate/template',
        component: () => import('@views/configuration/academic/certificate-template/index' /* webpackChunkName: "js/configuration/academic/certificate-template/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/academic/certificate/template/:id/edit',
        component: () => import('@views/configuration/academic/certificate-template/edit' /* webpackChunkName: "js/configuration/academic/certificate-template/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/caste',
        component: () => import('@views/configuration/misc/caste/index' /* webpackChunkName: "js/configuration/misc/caste/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/caste/:id/edit',
        component: () => import('@views/configuration/misc/caste/edit' /* webpackChunkName: "js/configuration/misc/caste/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/religion',
        component: () => import('@views/configuration/misc/religion/index' /* webpackChunkName: "js/configuration/misc/religion/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/religion/:id/edit',
        component: () => import('@views/configuration/misc/religion/edit' /* webpackChunkName: "js/configuration/misc/religion/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/category',
        component: () => import('@views/configuration/misc/category/index' /* webpackChunkName: "js/configuration/misc/category/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/category/:id/edit',
        component: () => import('@views/configuration/misc/category/edit' /* webpackChunkName: "js/configuration/misc/category/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/blood/group',
        component: () => import('@views/configuration/misc/blood-group/index' /* webpackChunkName: "js/configuration/misc/blood-group/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/misc/blood/group/:id/edit',
        component: () => import('@views/configuration/misc/blood-group/edit' /* webpackChunkName: "js/configuration/misc/blood-group/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/finance/transaction/category',
        component: () => import('@views/configuration/finance/transaction/category/index' /* webpackChunkName: "js/configuration/finance/transaction/category/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/finance/transaction/category/:id/edit',
        component: () => import('@views/configuration/finance/transaction/category/edit' /* webpackChunkName: "js/configuration/finance/transaction/category/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/finance/payment/method',
        component: () => import('@views/configuration/finance/transaction/payment-method/index' /* webpackChunkName: "js/configuration/finance/transaction/payment-method/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/finance/payment/method/:id/edit',
        component: () => import('@views/configuration/finance/transaction/payment-method/edit' /* webpackChunkName: "js/configuration/finance/transaction/payment-method/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/frontend/index',
        component: () => import('@views/configuration/frontend/index' /* webpackChunkName: "js/configuration/frontend/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/student',
        component: () => import('@views/configuration/student/index' /* webpackChunkName: "js/configuration/student/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/student/document/type',
        component: () => import('@views/configuration/student/document-type/index' /* webpackChunkName: "js/configuration/student/document-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/student/document/type/:id/edit',
        component: () => import('@views/configuration/student/document-type/edit' /* webpackChunkName: "js/configuration/student/document-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/student/group',
        component: () => import('@views/configuration/student/student-group/index' /* webpackChunkName: "js/configuration/student/student-group/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/student/group/:id/edit',
        component: () => import('@views/configuration/student/student-group/edit' /* webpackChunkName: "js/configuration/student/student-group/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/term',
        component: () => import('@views/configuration/exam/term/index' /* webpackChunkName: "js/configuration/exam/term/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/term/:id/edit',
        component: () => import('@views/configuration/exam/term/edit' /* webpackChunkName: "js/configuration/exam/term/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/assessment',
        component: () => import('@views/configuration/exam/assessment/index' /* webpackChunkName: "js/configuration/exam/assessment/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/assessment/create',
        component: () => import('@views/configuration/exam/assessment/create' /* webpackChunkName: "js/configuration/exam/assessment/create" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/assessment/:id/edit',
        component: () => import('@views/configuration/exam/assessment/edit' /* webpackChunkName: "js/configuration/exam/assessment/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/observation',
        component: () => import('@views/configuration/exam/observation/index' /* webpackChunkName: "js/configuration/exam/observation/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/observation/create',
        component: () => import('@views/configuration/exam/observation/create' /* webpackChunkName: "js/configuration/exam/observation/create" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/observation/:id/edit',
        component: () => import('@views/configuration/exam/observation/edit' /* webpackChunkName: "js/configuration/exam/observation/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/grade',
        component: () => import('@views/configuration/exam/grade/index' /* webpackChunkName: "js/configuration/exam/grade/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/grade/create',
        component: () => import('@views/configuration/exam/grade/create' /* webpackChunkName: "js/configuration/exam/grade/create" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/exam/grade/:id/edit',
        component: () => import('@views/configuration/exam/grade/edit' /* webpackChunkName: "js/configuration/exam/grade/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/group',
        component: () => import('@views/configuration/employee/employee-group/index' /* webpackChunkName: "js/configuration/employee/employee-group/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/group/:id/edit',
        component: () => import('@views/configuration/employee/employee-group/edit' /* webpackChunkName: "js/configuration/employee/employee-group/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee',
        component: () => import('@views/configuration/employee/index' /* webpackChunkName: "js/configuration/employee/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/document/type',
        component: () => import('@views/configuration/employee/document-type/index' /* webpackChunkName: "js/configuration/employee/document-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/document/type/:id/edit',
        component: () => import('@views/configuration/employee/document-type/edit' /* webpackChunkName: "js/configuration/employee/document-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/leave/type',
        component: () => import('@views/configuration/employee/leave-type/index' /* webpackChunkName: "js/configuration/employee/leave-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/leave/type/:id/edit',
        component: () => import('@views/configuration/employee/leave-type/edit' /* webpackChunkName: "js/configuration/employee/leave-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/attendance/type',
        component: () => import('@views/configuration/employee/attendance-type/index' /* webpackChunkName: "js/configuration/employee/attendance-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/attendance/type/:id/edit',
        component: () => import('@views/configuration/employee/attendance-type/edit' /* webpackChunkName: "js/configuration/employee/attendance-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/pay/head',
        component: () => import('@views/configuration/employee/pay-head/index' /* webpackChunkName: "js/configuration/employee/pay-head/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/pay/head/:id/edit',
        component: () => import('@views/configuration/employee/pay-head/edit' /* webpackChunkName: "js/configuration/employee/pay-head/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/category',
        component: () => import('@views/configuration/employee/category/index' /* webpackChunkName: "js/configuration/employee/category/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/category/:id/edit',
        component: () => import('@views/configuration/employee/category/edit' /* webpackChunkName: "js/configuration/employee/category/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/department',
        component: () => import('@views/configuration/employee/department/index' /* webpackChunkName: "js/configuration/employee/department/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/department/:id/edit',
        component: () => import('@views/configuration/employee/department/edit' /* webpackChunkName: "js/configuration/employee/department/edit" */),
        meta: { menu: 'module-configuration'}       
    },
    {
        path: '/configuration/employee/designation',
        component: () => import('@views/configuration/employee/designation/index' /* webpackChunkName: "js/configuration/employee/designation/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/employee/designation/:id/edit',
        component: () => import('@views/configuration/employee/designation/edit' /* webpackChunkName: "js/configuration/employee/designation/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/transport/vehicle/document/type',
        component: () => import('@views/configuration/transport/vehicle/document-type/index' /* webpackChunkName: "js/configuration/transport/vehicle/document-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/transport/vehicle/document/type/:id/edit',
        component: () => import('@views/configuration/transport/vehicle/document-type/edit' /* webpackChunkName: "js/configuration/transport/vehicle/document-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/transport/vehicle/fuel/type',
        component: () => import('@views/configuration/transport/vehicle/fuel-type/index' /* webpackChunkName: "js/configuration/transport/vehicle/fuel-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/transport/vehicle/fuel/type/:id/edit',
        component: () => import('@views/configuration/transport/vehicle/fuel-type/edit' /* webpackChunkName: "js/configuration/transport/vehicle/fuel-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library',
        component: () => import('@views/configuration/library/index' /* webpackChunkName: "js/configuration/library/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/author',
        component: () => import('@views/configuration/library/book-author/index' /* webpackChunkName: "js/configuration/library/book-author/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/author/:id/edit',
        component: () => import('@views/configuration/library/book-author/edit' /* webpackChunkName: "js/configuration/library/book-author/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/language',
        component: () => import('@views/configuration/library/book-language/index' /* webpackChunkName: "js/configuration/library/book-language/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/language/:id/edit',
        component: () => import('@views/configuration/library/book-language/edit' /* webpackChunkName: "js/configuration/library/book-language/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/topic',
        component: () => import('@views/configuration/library/book-topic/index' /* webpackChunkName: "js/configuration/library/book-topic/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/topic/:id/edit',
        component: () => import('@views/configuration/library/book-topic/edit' /* webpackChunkName: "js/configuration/library/book-topic/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/publisher',
        component: () => import('@views/configuration/library/book-publisher/index' /* webpackChunkName: "js/configuration/library/book-publisher/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/publisher/:id/edit',
        component: () => import('@views/configuration/library/book-publisher/edit' /* webpackChunkName: "js/configuration/library/book-publisher/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/condition',
        component: () => import('@views/configuration/library/book-condition/index' /* webpackChunkName: "js/configuration/library/book-condition/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/library/book/condition/:id/edit',
        component: () => import('@views/configuration/library/book-condition/edit' /* webpackChunkName: "js/configuration/library/book-condition/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/calendar/event/type',
        component: () => import('@views/configuration/calendar/event-type/index' /* webpackChunkName: "js/configuration/calendar/event-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/calendar/event/type/:id/edit',
        component: () => import('@views/configuration/calendar/event-type/edit' /* webpackChunkName: "js/configuration/calendar/event-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/post/article/type',
        component: () => import('@views/configuration/post/article-type/index' /* webpackChunkName: "js/configuration/post/article-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/post/article/type/:id/edit',
        component: () => import('@views/configuration/post/article-type/edit' /* webpackChunkName: "js/configuration/post/article-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/enquiry/type',
        component: () => import('@views/configuration/reception/enquiry-type/index' /* webpackChunkName: "js/configuration/reception/enquiry-type/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/enquiry/type/:id/edit',
        component: () => import('@views/configuration/reception/enquiry-type/edit' /* webpackChunkName: "js/configuration/reception/enquiry-type/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/enquiry/source',
        component: () => import('@views/configuration/reception/enquiry-source/index' /* webpackChunkName: "js/configuration/reception/enquiry-source/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/enquiry/source/:id/edit',
        component: () => import('@views/configuration/reception/enquiry-source/edit' /* webpackChunkName: "js/configuration/reception/enquiry-source/edit" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/visitor/purpose',
        component: () => import('@views/configuration/reception/visitor-purpose/index' /* webpackChunkName: "js/configuration/reception/visitor-purpose/index" */),
        meta: { menu: 'module-configuration'}
    },
    {
        path: '/configuration/reception/visitor/purpose/:id/edit',
        component: () => import('@views/configuration/reception/visitor-purpose/edit' /* webpackChunkName: "js/configuration/reception/visitor-purpose/edit" */),
        meta: { menu: 'module-configuration'}
    }
]