import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import App from './App.vue'
import NewProduct from './components/NewProduct'
import ListProducts from './components/ListProducts'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './custom.scss'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Router)
Vue.use(Meta)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'listProducts',
      component: ListProducts
    },
    {
      path: '/product/new',
      name: 'newProduct',
      component: NewProduct,
      props: true,
    }
  ],
  linkActiveClass: 'nav-item active',
})

new Vue({
  el: '#app',
  render: h => h(App),
  router
})
