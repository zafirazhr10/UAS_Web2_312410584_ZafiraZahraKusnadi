<template>
  <div class="min-h-screen flex bg-gray-50 font-sans text-gray-900 relative overflow-hidden">
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 relative items-center justify-center overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[30rem] h-[30rem] bg-blue-500 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-indigo-500 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
      </div>
      <div class="relative z-10 text-center px-12 pointer-events-none">
        <h1 class="text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">E-Inventory System</h1>
        <p class="text-lg text-indigo-200 max-w-md mx-auto font-medium">Secure, enterprise-grade inventory management platform.</p>
      </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative z-10">
      <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 border border-gray-100 relative">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back</h2>
          <p class="text-gray-500 font-medium">Please sign in to access your dashboard</p>
        </div>

        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="transform -translate-y-4 opacity-0" enter-to-class="transform translate-y-0 opacity-100" leave-active-class="transition duration-200 ease-in" leave-from-class="transform translate-y-0 opacity-100" leave-to-class="transform -translate-y-4 opacity-0">
          <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <p class="text-sm text-red-700 font-semibold">{{ errorMessage }}</p>
          </div>
        </Transition>

        <form @submit.prevent="handleLogin" class="space-y-5" autocomplete="off">
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5">Email Address</label>
            <input type="email" v-model="email" required placeholder="Enter your email" autocomplete="new-password" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all shadow-sm" />
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
            <input type="password" v-model="password" required placeholder="Enter your password" autocomplete="new-password" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all shadow-sm" />
          </div>
          <div class="pt-2">
            <button type="submit" :disabled="isLoading" class="w-full flex justify-center items-center py-3.5 px-4 rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-70 transition-all hover:-translate-y-1">
              <svg v-if="isLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 2 3.373 2 6v12a8 8 0 01-8 8z"></path></svg>
              <span v-if="!isLoading">Sign In</span>
              <span v-else>Authenticating...</span>
            </button>
          </div>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500 font-medium">
          Don't have an account? <router-link to="/register" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Register here</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import apiClient from '../services/api';

const router = useRouter();
const email = ref('');
const password = ref('');
const isLoading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
  isLoading.value = true;
  errorMessage.value = '';
  try {
    const response = await apiClient.post('/login', { email: email.value, password: password.value });
    if (response.data && response.data.token) {
      localStorage.setItem('token', response.data.token);
      router.push('/dashboard');
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Authentication failed.';
  } finally {
    isLoading.value = false;
  }
};
</script>