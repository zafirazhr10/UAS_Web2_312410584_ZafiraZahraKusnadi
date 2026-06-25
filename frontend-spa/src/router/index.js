import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../pages/Dashboard.vue';
import Barang from '../pages/Barang.vue';
import Kategori from '../pages/Kategori.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', redirect: '/dashboard' },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard },
    { path: '/barang', component: Barang },
    { path: '/kategori', component: Kategori }
  ]
});
