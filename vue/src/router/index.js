import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/views/Login.vue')
  },
  {
    path: '/bus',
    component: () => import('@/views/Bus.vue')
  },
  {
    path: '/driver',
    component: () => import('@/views/Driver.vue')
  },
  {
    path: '/order',
    component: () => import('@/views/Order.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
