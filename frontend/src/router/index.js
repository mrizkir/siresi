import Vue from 'vue'
import VueRouter from 'vue-router'
import NotFoundComponent from '../components/NotFoundComponent'
import store from '../store/index'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'FrontDashboard',
    meta: {
      title: 'LOGIN',
    },
    component: () => import('../views/pages/front/Login.vue'),
  },
  {
    path: '/dashboard/:token',
    name: 'DashboardAdmin',
    meta: {
      title: 'DASHBOARD',
    },
    component: () => import('../views/pages/admin/DashboardAdmin.vue'),
  },

  // transaksi  - admin scan resi
  {
    path: '/transaksi/admin/scanresi',
    name: 'TransaksiAdminScanResi',
    meta: {
      title: 'TRANSAKSI - SCAN RESI',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiAdminScanResi.vue'),
  },

  // transaksi  - checker scan resi
  {
    path: '/transaksi/checker/scanresi',
    name: 'TransaksiCheckerScanResi',
    meta: {
      title: 'TRANSAKSI - SCAN RESI',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiCheckerScanResi.vue'),
  },

  // transaksi  - handoffer scan resi
  {
    path: '/transaksi/handoffer/scanresi',
    name: 'TransaksiHandofferScanResi',
    meta: {
      title: 'TRANSAKSI - SCAN RESI',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiHandofferScanResi.vue'),
  },

  // transaksi  - posisi resi yang ada di tangan picker
  {
    path: '/transaksi/resipicker',
    name: 'TransaksiResiPicker',
    meta: {
      title: 'TRANSAKSI - RESI PICKER',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiResiPicker.vue'),
  },
  // transaksi  - posisi resi yang ada di tangan checker
  {
    path: '/transaksi/resichecker',
    name: 'TransaksiResiChecker',
    meta: {
      title: 'TRANSAKSI - RESI CHECKER',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiResiChecker.vue'),
  },
  // transaksi  - posisi resi yang ada di tangan handoffer
  {
    path: '/transaksi/resihandoffer',
    name: 'TransaksiResiHandoffer',
    meta: {
      title: 'TRANSAKSI - RESI HANDOFFER',
      requiresAuth: true,
    },
    component: () =>
      import('../views/pages/admin/transaksi/TransaksiResiHandoffer.vue'),
  },
  // setting  - pengguna
  {
    path: '/setting/pengguna/permissions',
    name: 'UserPermissions',
    meta: {
      title: 'PENGGUNA - PERMISSIONS',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/Permissions.vue'),
  },
  {
    path: '/setting/pengguna/roles',
    name: 'UsesRoles',
    meta: {
      title: 'PENGGUNA - ROLES',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/Roles.vue'),
  },
  {
    path: '/setting/pengguna/admin',
    name: 'UserAdmin',
    meta: {
      title: 'PENGGUNA - ADMIN',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/UserAdmin.vue'),
  },
  {
    path: '/setting/pengguna/picker',
    name: 'UserPicker',
    meta: {
      title: 'PENGGUNA - PICKER',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/UserPicker.vue'),
  },
  {
    path: '/setting/pengguna/checker',
    name: 'UserChecker',
    meta: {
      title: 'PENGGUNA - CHECKER',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/UserChecker.vue'),
  },
  {
    path: '/setting/pengguna/handoffer',
    name: 'UserHandoffer',
    meta: {
      title: 'PENGGUNA - HANDOFFER',
      requiresAuth: true,
    },
    component: () => import('../views/pages/admin/setting/UserHandoffer.vue'),
  },
  {
    path: '/404',
    name: 'NotFoundComponent',
    meta: {
      title: 'PAGE NOT FOUND',
    },
    component: NotFoundComponent,
  },
  {
    path: '*',
    redirect: '/404',
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters['auth/Authenticated']) {
      next()
      return
    }
    next('/')
  } else {
    next()
  }
})

export default router
