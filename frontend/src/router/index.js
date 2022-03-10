import Vue from 'vue'
import VueRouter from 'vue-router'
import NotFoundComponent from "../components/NotFoundComponent";

Vue.use(VueRouter)

const routes = [
  {
		path: "/",
		name: "FrontDashboard",
		meta: {
			title: "DASHBOARD"
		},
		component: () => import("../views/pages/front/Home.vue")
	},
  {
		path: "/404",
		name: "NotFoundComponent",
		meta: {
			title: "PAGE NOT FOUND",
		},
		component: NotFoundComponent,
	},
	{
		path: "*",
		redirect: "/404",
	},
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
