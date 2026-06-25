<template>
  <div class="min-h-screen flex bg-gray-50 font-sans text-gray-900 relative overflow-hidden">
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-900 via-indigo-900 to-blue-900 relative items-center justify-center overflow-hidden">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[30rem] h-[30rem] bg-indigo-500 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
      </div>
      <div class="relative z-10 text-center px-12 pointer-events-none">
        <h1 class="text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">Join E-Inventory</h1>
        <p class="text-lg text-indigo-200 max-w-md mx-auto font-medium">Create a secure account to start managing your assets.</p>
      </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative z-10">
      <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 sm:p-10 border border-gray-100 relative">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Create Account</h2>
        </div>

        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="transform -translate-y-4 opacity-0" enter-to-class="transform translate-y-0 opacity-100">
          <div v-if="errorMessage" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-3">
            <p class="text-sm text-red-700 font-semibold">{{ errorMessage }}</p>
          </div>
        </Transition>
        <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="transform -translate-y-4 opacity-0" enter-to-class="transform translate-y-0 opacity-100">
          <div v-if="successMessage" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg flex items-start gap-3">
            <p class="text-sm text-green-700 font-semibold">{{ successMessage }}</p>
          </div>
        </Transition>

        <form @submit.prevent="handleRegister" class="space-y-5" autocomplete="off">
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5">Full Name</label>
            <input type="text" v-model="name" required placeholder="Enter full name" autocomplete="new-password" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all shadow-sm" />
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5">Email</label>
            <input type="email" v-model="email" required placeholder="name@domain.com" autocomplete="new-password" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all shadow-sm" />
          </div>
          <div>
            <label class="block text-sm font-bold text-gray-700 mb-1.5">Password</label>
            <input type="password" v-model="password" required placeholder="Create password" autocomplete="new-password" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all shadow-sm" />
          </div>
          <button type="submit" :disabled="isLoading" class="w-full py-3.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all">
            <span v-if="!isLoading">Register Account</span>
            <span v-else>Processing...</span>
          </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
          Already have an account? <router-link to="/login" class="font-bold text-blue-600 hover:text-blue-700">Sign in here</router-link>
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
const name = ref('');
const email = ref('');
const password = ref('');
const isLoading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const handleRegister = async () => {
  isLoading.value = true;
  errorMessage.value = '';
  try {
    await apiClient.post('/register', { name: name.value, email: email.value, password: password.value });
    successMessage.value = 'Registration successful! Redirecting...';
    setTimeout(() => router.push('/login'), 2000);
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Registration failed.';
  } finally {
    isLoading.value = false;
  }
};
</script>