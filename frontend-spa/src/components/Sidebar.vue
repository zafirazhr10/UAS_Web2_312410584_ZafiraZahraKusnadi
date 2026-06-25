<template>
  <aside class="w-64 bg-gradient-to-b from-slate-900 to-indigo-900 text-white shadow-lg flex flex-col">
    <div class="px-6 py-6 border-b border-white/10">
      <h1 class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-indigo-200">E-Inventory</h1>
    </div>
    <nav class="flex-grow mt-6">
      <router-link to="/dashboard" active-class="bg-white/10 backdrop-blur-md border-l-4 border-indigo-400 rounded-r-lg" class="flex items-center px-6 py-3.5 text-lg font-medium text-white transition-all duration-300 hover:bg-white/5 mx-3 mb-2 rounded-lg">
        <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
      </router-link>
      <router-link to="/barang" active-class="bg-white/10 backdrop-blur-md border-l-4 border-indigo-400 rounded-r-lg" class="flex items-center px-6 py-3.5 text-lg font-medium text-white transition-all duration-300 hover:bg-white/5 mx-3 mb-2 rounded-lg">
        <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        Barang
      </router-link>
      <router-link to="/kategori" active-class="bg-white/10 backdrop-blur-md border-l-4 border-indigo-400 rounded-r-lg" class="flex items-center px-6 py-3.5 text-lg font-medium text-white transition-all duration-300 hover:bg-white/5 mx-3 mb-2 rounded-lg">
        <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
        Kategori
      </router-link>
    </nav>
    <div class="px-6 py-5 border-t border-white/10">
      <button @click="logout" class="flex items-center w-full px-6 py-3.5 text-lg font-medium text-white transition-all duration-300 hover:bg-white/5 rounded-lg mb-2">
        <svg class="w-6 h-6 mr-3 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        Logout
      </button>
    </div>
  </aside>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const logout = () => {
  localStorage.removeItem('token');
  router.push('/login');
};
</script>