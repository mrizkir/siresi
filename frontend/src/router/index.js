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
