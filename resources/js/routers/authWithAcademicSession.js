export default [
    {
        path: '/academic/course',
        component: () => import('@views/academic/course/index' /* webpackChunkName: "js/academic/course/index" */)
    },
    {
        path: '/academic/course/:id/edit',
        component: () => import('@views/academic/course/edit' /* webpackChunkName: "js/academic/course/edit" */)
    },
    {
        path: '/academic/batch',
        component: () => import('@views/academic/batch/index' /* webpackChunkName: "js/academic/batch/index" */)
    },
    {
        path: '/academic/batch/:id/edit',
        component: () => import('@views/academic/batch/edit' /* webpackChunkName: "js/academic/batch/edit" */)
    },
    {
        path: '/academic/subject',
        component: () => import('@views/academic/subject/index' /* webpackChunkName: "js/academic/subject/index" */)
    },
    {
        path: '/academic/subject/:id/edit',
        component: () => import('@views/academic/subject/edit' /* webpackChunkName: "js/academic/subject/edit" */)
    },
    {
        path: '/academic/class/teacher',
        component: () => import('@views/academic/class-teacher/index' /* webpackChunkName: "js/academic/class-teacher/index" */)
    },
    {
        path: '/academic/subject/teacher',
        component: () => import('@views/academic/subject-teacher/index' /* webpackChunkName: "js/academic/subject-teacher/index" */)
    },
    {
        path: '/academic/class/timing',
        component: () => import('@views/academic/class-timing/index' /* webpackChunkName: "js/academic/class-timing/index" */)
    },
    {
        path: '/academic/class/timing/create',
        component: () => import('@views/academic/class-timing/create' /* webpackChunkName: "js/academic/class-timing/create" */)
    },
    {
        path: '/academic/class/timing/:uuid/edit',
        component: () => import('@views/academic/class-timing/edit' /* webpackChunkName: "js/academic/class-timing/edit" */)
    },
    {
        path: '/academic/timetable',
        component: () => import('@views/academic/timetable/index' /* webpackChunkName: "js/academic/timetable/index" */)
    },
    {
        path: '/academic/timetable/create',
        component: () => import('@views/academic/timetable/create' /* webpackChunkName: "js/academic/timetable/create" */)
    },
    {
        path: '/academic/timetable/:uuid/edit',
        component: () => import('@views/academic/timetable/edit' /* webpackChunkName: "js/academic/timetable/edit" */)
    },
    {
        path: '/academic/timetable/:uuid/allocation',
        component: () => import('@views/academic/timetable/allocation' /* webpackChunkName: "js/academic/timetable/allocation" */)
    },
    {
        path: '/academic/certificate',
        component: () => import('@views/academic/certificate/index' /* webpackChunkName: "js/academic/certificate/index" */)
    },
    {
        path: '/academic/certificate/create',
        component: () => import('@views/academic/certificate/create' /* webpackChunkName: "js/academic/certificate/create" */)
    },
    {
        path: '/academic/certificate/:uuid/edit',
        component: () => import('@views/academic/certificate/edit' /* webpackChunkName: "js/academic/certificate/edit" */)
    },
    {
        path: '/academic/transfer-certificate',
        component: () => import('@views/academic/transfer-certificate/index' /* webpackChunkName: "js/academic/transfer-certificate/index" */)
    },
    {
        path: '/academic/transfer-certificate/create',
        component: () => import('@views/academic/transfer-certificate/create' /* webpackChunkName: "js/academic/transfer-certificate/create" */)
    },
    {
        path: '/academic/transfer-certificate/:uuid/edit',
        component: () => import('@views/academic/transfer-certificate/edit' /* webpackChunkName: "js/academic/transfer-certificate/edit" */)
    },
    {
        path: '/student',
        component: () => import('@views/student/index' /* webpackChunkName: "js/student/index" */)
    },
    {
        path: '/student/import',
        component: () => import('@views/student/import/index' /* webpackChunkName: "js/student/import/index" */)
    },
    {
        path: '/student/registration',
        component: () => import('@views/student/registration/index' /* webpackChunkName: "js/student/registration/index" */)
    },
    {
        path: '/student/registration/:id',
        component: () => import('@views/student/registration/show' /* webpackChunkName: "js/student/registration/show" */)
    },
    {
        path: '/student/admission',
        component: () => import('@views/student/admission/index' /* webpackChunkName: "js/student/admission/index" */)
    },
    {
        path: '/student/roll/number',
        component: () => import('@views/student/roll-number/index' /* webpackChunkName: "js/student/roll-number/index" */)
    },
    {
        path: '/student/image',
        component: () => import('@views/student/image/index' /* webpackChunkName: "js/student/image/index" */)
    },
    {
        path: '/student/attendance',
        component: () => import('@views/student/attendance/index' /* webpackChunkName: "js/student/attendance/index" */)
    },
    {
        path: '/student/attendance/absentee',
        component: () => import('@views/student/attendance/absentee' /* webpackChunkName: "js/student/attendance/absentee" */)
    },
    {
        path: '/student/promotion',
        component: () => import('@views/student/promotion/index' /* webpackChunkName: "js/student/promotion/index" */)
    },
    {
        path: '/student/termination',
        component: () => import('@views/student/termination/index' /* webpackChunkName: "js/student/termination/index" */)
    },
    {
        path: '/student/:uuid',
        component: () => import('@views/student/show' /* webpackChunkName: "js/student" */)
    },
    {
        path: '/student/:uuid/fee/:record_id',
        component: () => import('@views/student/fee/index' /* webpackChunkName: "js/student/fee/index" */)
    },
    {
        path: '/student/:uuid/fee/:record_id/set',
        component: () => import('@views/student/fee/set' /* webpackChunkName: "js/student/fee/set" */)
    },
    {
        path: '/student/:uuid/fee/:record_id/create',
        component: () => import('@views/student/fee/create' /* webpackChunkName: "js/student/fee/create" */)
    },
    {
        path: '/exam/schedule',
        component: () => import('@views/exam/schedule/index' /* webpackChunkName: "js/exam/schedule/index" */)
    },
    {
        path: '/exam/schedule/create',
        component: () => import('@views/exam/schedule/create' /* webpackChunkName: "js/exam/schedule/create" */)
    },
    {
        path: '/exam/schedule/:id/edit',
        component: () => import('@views/exam/schedule/edit' /* webpackChunkName: "js/exam/schedule/edit" */)
    },
    {
        path: '/exam/record',
        component: () => import('@views/exam/record/index' /* webpackChunkName: "js/exam/record/index" */)
    },
    {
        path: '/exam/record/observation',
        component: () => import('@views/exam/record/observation' /* webpackChunkName: "js/exam/record/observation" */)
    },
    {
        path: '/exam/report',
        component: () => import('@views/exam/report/index' /* webpackChunkName: "js/exam/report/index" */)
    },
    {
        path: '/exam/report/exam-wise',
        component: () => import('@views/exam/report/exam-wise' /* webpackChunkName: "js/exam/report/exam-wise" */)
    },
    {
        path: '/exam/report/term-wise',
        component: () => import('@views/exam/report/term-wise' /* webpackChunkName: "js/exam/report/term-wise" */)
    },
    {
        path: '/exam',
        component: () => import('@views/exam/index' /* webpackChunkName: "js/exam/index" */)
    },
    {
        path: '/exam/:id/edit',
        component: () => import('@views/exam/edit' /* webpackChunkName: "js/exam/edit" */)
    },
    {
        path: '/finance',
        component: () => import('@views/finance/index' /* webpackChunkName: "js/finance/index" */)
    },
    {
        path: '/finance/fee',
        component: () => import('@views/finance/fee/index' /* webpackChunkName: "js/finance/fee/index" */)
    },
    {
        path: '/finance/fee/group',
        component: () => import('@views/finance/fee/group/index' /* webpackChunkName: "js/finance/fee/group/index" */)
    },
    {
        path: '/finance/fee/group/:id/edit',
        component: () => import('@views/finance/fee/group/edit' /* webpackChunkName: "js/finance/fee/group/edit" */)
    },
    {
        path: '/finance/fee/concession',
        component: () => import('@views/finance/fee/concession/index' /* webpackChunkName: "js/finance/fee/concession/index" */)
    },
    {
        path: '/finance/fee/concession/:id/edit',
        component: () => import('@views/finance/fee/concession/edit' /* webpackChunkName: "js/finance/fee/concession/edit" */)
    },
    {
        path: '/finance/fee/head',
        component: () => import('@views/finance/fee/head/index' /* webpackChunkName: "js/finance/fee/head/index" */)
    },
    {
        path: '/finance/fee/head/:id/edit',
        component: () => import('@views/finance/fee/head/edit' /* webpackChunkName: "js/finance/fee/head/edit" */)
    },
    {
        path: '/finance/fee/allocation',
        component: () => import('@views/finance/fee/allocation/index' /* webpackChunkName: "js/finance/fee/allocation/index" */)
    },
    {
        path: '/finance/fee/allocation/create',
        component: () => import('@views/finance/fee/allocation/create' /* webpackChunkName: "js/finance/fee/allocation/create" */)
    },
    {
        path: '/finance/fee/allocation/create/:uuid',
        component: () => import('@views/finance/fee/allocation/create' /* webpackChunkName: "js/finance/fee/allocation/create" */)
    },
    {
        path: '/finance/fee/allocation/:uuid/edit',
        component: () => import('@views/finance/fee/allocation/edit' /* webpackChunkName: "js/finance/fee/allocation/edit" */)
    },
    {
        path: '/finance/fee/allocation/:uuid',
        component: () => import('@views/finance/fee/allocation/show' /* webpackChunkName: "js/finance/fee/allocation/show" */)
    },
    {
        path: '/finance/transaction/income',
        component: () => import('@views/finance/transaction/income/index' /* webpackChunkName: "js/finance/transaction/income/index" */)
    },
    {
        path: '/finance/transaction/income/:uuid/edit',
        component: () => import('@views/finance/transaction/income/edit' /* webpackChunkName: "js/finance/transaction/income/edit" */)
    },
    {
        path: '/finance/transaction/expense',
        component: () => import('@views/finance/transaction/expense/index' /* webpackChunkName: "js/finance/transaction/expense/index" */)
    },
    {
        path: '/finance/transaction/expense/:uuid/edit',
        component: () => import('@views/finance/transaction/expense/edit' /* webpackChunkName: "js/finance/transaction/expense/edit" */)
    },
    {
        path: '/finance/transaction/account/transfer',
        component: () => import('@views/finance/transaction/account-transfer/index' /* webpackChunkName: "js/finance/transaction/account-transfer/index" */)
    },
    {
        path: '/finance/transaction/account/transfer/:uuid/edit',
        component: () => import('@views/finance/transaction/account-transfer/edit' /* webpackChunkName: "js/finance/transaction/account-transfer/edit" */)
    },
    {
        path: '/transport',
        component: () => import('@views/transport/index' /* webpackChunkName: "js/transport/index" */)
    },
    {
        path: '/transport/circle',
        component: () => import('@views/transport/circle/index' /* webpackChunkName: "js/transport/circle/index" */)
    },
    {
        path: '/transport/circle/:id/edit',
        component: () => import('@views/transport/circle/edit' /* webpackChunkName: "js/transport/circle/edit" */)
    },
    {
        path: '/transport/stoppage',
        component: () => import('@views/transport/stoppage/index' /* webpackChunkName: "js/transport/stoppage/index" */)
    },
    {
        path: '/transport/stoppage/:id/edit',
        component: () => import('@views/transport/stoppage/edit' /* webpackChunkName: "js/transport/stoppage/edit" */)
    },
    {
        path: '/transport/route/assign',
        component: () => import('@views/transport/route/assign' /* webpackChunkName: "js/transport/route/assign" */)
    },
    {
        path: '/transport/route',
        component: () => import('@views/transport/route/index' /* webpackChunkName: "js/transport/route/index" */)
    },
    {
        path: '/transport/route/:id/edit',
        component: () => import('@views/transport/route/edit' /* webpackChunkName: "js/transport/route/edit" */)
    },
    {
        path: '/transport/report/route',
        component: () => import('@views/transport/report/route' /* webpackChunkName: "js/transport/report/route" */)
    },
    {
        path: '/transport/report/stoppage',
        component: () => import('@views/transport/report/stoppage' /* webpackChunkName: "js/transport/report/stoppage" */)
    },
    {
        path: '/transport/fee',
        component: () => import('@views/transport/fee/index' /* webpackChunkName: "js/transport/fee/index" */)
    },
    {
        path: '/transport/fee/:id/edit',
        component: () => import('@views/transport/fee/edit' /* webpackChunkName: "js/transport/fee/edit" */)
    },
    {
        path: '/library',
        component: () => import('@views/library/index' /* webpackChunkName: "js/library/index" */)
    },
    {
        path: '/library/book',
        component: () => import('@views/library/book/index' /* webpackChunkName: "js/library/book/index" */)
    },
    {
        path: '/library/book/:uuid/edit',
        component: () => import('@views/library/book/edit' /* webpackChunkName: "js/library/book/edit" */)
    },
    {
        path: '/library/book/:uuid',
        component: () => import('@views/library/book/show' /* webpackChunkName: "js/library/book/show" */)
    },
    {
        path: '/library/issue',
        component: () => import('@views/library/issue-return/issue' /* webpackChunkName: "js/library/issue-return/issue" */)
    },
    {
        path: '/library/issue/list',
        component: () => import('@views/library/issue-return/log' /* webpackChunkName: "js/library/issue-return/log" */)
    },
    {
        path: '/library/return',
        component: () => import('@views/library/issue-return/return' /* webpackChunkName: "js/library/issue-return/return" */)
    },
    {
        path: '/library/issue/:uuid',
        component: () => import('@views/library/issue-return/show' /* webpackChunkName: "js/library/issue-return/show" */)
    },
    {
        path: '/inventory',
        component: () => import('@views/inventory/index' /* webpackChunkName: "js/inventory/index" */)
    },
    {
        path: '/resource',
        component: () => import('@views/resource/index' /* webpackChunkName: "js/resource/index" */)
    },
    {
        path: '/resource/assignment',
        component: () => import('@views/resource/assignment/index' /* webpackChunkName: "js/resource/assignment/index" */)
    },
    {
        path: '/resource/assignment/:uuid/edit',
        component: () => import('@views/resource/assignment/edit' /* webpackChunkName: "js/resource/assignment/edit" */)
    },
    {
        path: '/resource/assignment/:uuid',
        component: () => import('@views/resource/assignment/show' /* webpackChunkName: "js/resource/assignment/show" */)
    },
    {
        path: '/resource/notes',
        component: () => import('@views/resource/notes/index' /* webpackChunkName: "js/resource/notes/index" */)
    },
    {
        path: '/resource/notes/:uuid/edit',
        component: () => import('@views/resource/notes/edit' /* webpackChunkName: "js/resource/notes/edit" */)
    },
    {
        path: '/resource/notes/:uuid',
        component: () => import('@views/resource/notes/show' /* webpackChunkName: "js/resource/notes/show" */)
    },
    {
        path: '/resource/lesson/plan',
        component: () => import('@views/resource/lesson-plan/index' /* webpackChunkName: "js/resource/lesson-plan/index" */)
    },
    {
        path: '/resource/lesson/plan/create',
        component: () => import('@views/resource/lesson-plan/create' /* webpackChunkName: "js/resource/lesson-plan/create" */)
    },
    {
        path: '/resource/lesson/plan/:uuid/edit',
        component: () => import('@views/resource/lesson-plan/edit' /* webpackChunkName: "js/resource/lesson-plan/edit" */)
    },
    {
        path: '/resource/lesson/plan/:uuid',
        component: () => import('@views/resource/lesson-plan/show' /* webpackChunkName: "js/resource/lesson-plan/show" */)
    },
    {
        path: '/resource/syllabus',
        component: () => import('@views/resource/syllabus/index' /* webpackChunkName: "js/resource/syllabus/index" */)
    },
    {
        path: '/resource/syllabus/create',
        component: () => import('@views/resource/syllabus/create' /* webpackChunkName: "js/resource/syllabus/create" */)
    },
    {
        path: '/resource/syllabus/:uuid/edit',
        component: () => import('@views/resource/syllabus/edit' /* webpackChunkName: "js/resource/syllabus/edit" */)
    },
    {
        path: '/resource/syllabus/:uuid',
        component: () => import('@views/resource/syllabus/show' /* webpackChunkName: "js/resource/syllabus/show" */)
    }
]