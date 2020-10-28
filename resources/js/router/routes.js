function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/userRole', component: page('auth/permission/UserRole.vue'),
    children: [
      {path:'', name:  'permission.UserRole', redirect: {name:  'permission.UserRoleList'}},
      {path:  'list', name: 'permission.UserRoleList', component: page('auth/permission/UserRoleList.vue')},
      {path:'permission',  name: 'permission.UserRoleAdd', component: page('auth/permission/UserRoleAdd.vue')}
    ]
  },
  { path: '/apartment', component: page('apartment/index.vue'),
    children:[
      {path:'',name:'apartment.index', redirect:{name:'apartment.list'}},
      {path:'list',name:'apartment.list', component:page('apartment/list.vue')},
      {path:'register', name:  'apartment.register', component: page('apartment/register.vue')},
      {path:'edit', name:  'apartment.details', component: page('apartment/details.vue'),props:true},
      {path:'superManager', name:  'apartment.superManager', component: page('apartment/superManager.vue'),props:true},
      {path:'building', name:  'apartment.building', component: page('apartment/building.vue'),props:true},
    ]
  },
  
  { path:'/user', component: page('user/index.vue'),
    children:[
      {path:'', name:'user.index', redirect:{name:'user.list'}},
      {path:'list', name:'user.list', component: page('user/list')},
      {path:'register', name:'user.register', component: page('user/register')},
      {path:'edit', name:'user.details', component: page('user/details.vue')}
    ]
  },

  { path: '/superManager', name:'superManager', component: page('superManager/index.vue'),
    children:[
      {path:'register', name:  'superManager.register', component: page('superManager/register.vue')},
    ]
  },
  { path: '/notification',  name:  'notification',  component:  page('notification/index.vue'),
    children:[
      {path:'', name:  'notification', redirect: {name:  'notification.list'}},
      {path:'index', name:  'notification.list', component: page('notification/list.vue')},
      {path:'register', name:  'notification.register', component: page('notification/register.vue')},
    ]
  },
  { path: '/community',  name:  'community',  component:  page('community/index.vue'),
    children:[
      {path:'', name:  'community', redirect: {name:  'community.list'}},
      {path:'index', name:  'community.list', component: page('community/list.vue')},
      {path:'new', name:  'community.create', component: page('community/create.vue')},
    ] 
  },
  { path: '/suggestion',  name:  'suggestion',  component:  page('suggestion/index.vue'),
    children:[
      {path:'', name:  'suggestion', redirect: {name:  'suggestion.list'}},
      {path:'index', name:  'suggestion.list', component: page('suggestion/list.vue')},
      {path:'create', name:  'suggestion.create', component: page('suggestion/create.vue')},
      {path:':id', name:'suggestion.view', component: page('suggestion/view.vue')},
    ] 
  },
  { path: '/repair',  name:  'repair',  component:  page('repair/index.vue'),
    children:[
      {path:'', name:  'repair', redirect: {name:  'repair.list'}},
      {path:'index', name:  'repair.list', component: page('repair/list.vue')},
      {path:'create', name:  'repair.create', component: page('repair/create.vue')},
      {path:':id', name:'repair.view', component: page('repair/view.vue')},
    ] 
  },
  { path: '/repair',  name:  'repair',  component:  page('repair/repair.vue') },

  { path: '/facility',  name:  'facility',  component:  page('facility/index.vue'),
    children:[
      {path:'', name:  'facility', redirect: {name:  'facility.list'}},
      {path:'index', name:  'facility.list', component: page('facility/list.vue')},
      {path:'create', name:  'facility.create', component: page('facility/create.vue')},
      // {path:':id', name:'facility.view', component: page('facility/view.vue')},
    ]  
  },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
