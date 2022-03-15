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
      title: 'LOGIN'
    },
    component: () => import('../views/pages/front/Login.vue')
  },
  {
		path: "/dashboard/:token",
		name: "DashboardAdmin",
		meta: {
			title: "DASHBOARD",
		},
		component: () => import("../views/pages/admin/DashboardAdmin.vue"),
	},

  // setting  - pengguna
	{
		path: "/setting/pengguna/permissions",
		name: "UserPermissions",
		meta: {
			title: "PENGGUNA - PERMISSIONS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/Permissions.vue"),
	},
	{
		path: "/setting/pengguna/roles",
		name: "UsesRoles",
		meta: {
			title: "PENGGUNA - ROLES",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/Roles.vue"),
	},
  {
		path: "/setting/pengguna/admin",
		name: "UserSuperadmin",
		meta: {
			title: "PENGGUNA - ADMIN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/UserAdmin.vue"),
	},
	{
		path: "/setting/pengguna/picker",
		name: "UserBapelitbang",
		meta: {
			title: "PENGGUNA - PICKER",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/UserPicker.vue"),
	},
	{
		path: "/setting/pengguna/checker",
		name: "UserOPD",
		meta: {
			title: "PENGGUNA - CHECKER",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/UserPicker.vue"),
	},
	{
		path: "/setting/pengguna/handoffer",
		name: "UserUnitKerja",
		meta: {
			title: "PENGGUNA - HANDOFFER",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/setting/UserHandoffer.vue"),
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
  routes
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters['auth/Authenticated']) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

export default router
