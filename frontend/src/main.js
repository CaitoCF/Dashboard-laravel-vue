import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import LoginComponent from './pages/Login/LoginComponent'
import HomeComponent from './pages/Home/HomeComponent'
import ProductsComponent from './pages/Products/ProductsComponent'
import ServicesComponent from './pages/Services/ServicesComponent'
import SalesComponent from './pages/Sales/SalesComponent'
import 'bootstrap/dist/css/bootstrap.min.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

const routes = [
    { path: '/', name: 'Login', component: LoginComponent },
    { path: '/home', name: 'Home', component: HomeComponent },
    { path: '/products', name: 'Products', component: ProductsComponent },
    { path: '/services', name: 'Services', component: ServicesComponent },
    { path: '/sales', name: 'Sales', component: SalesComponent },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

/* eslint-disable no-new */

createApp(App).use(router).mount('#app')