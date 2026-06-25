<template>
  <div class="flex h-screen bg-slate-50">
    <Sidebar />
    
    <main class="flex-1 p-8 overflow-y-auto">
      <h2 class="text-4xl font-extrabold text-gray-900 mb-8">Dashboard Overview</h2>

      <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 flex items-center justify-between hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
          <div>
            <p class="text-xl font-semibold text-gray-500">Total Barang</p>
            <p class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600 mt-2">{{ totalBarangCount }}</p>
          </div>
          <svg class="w-16 h-16 text-indigo-400 opacity-70" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9H7V7h10v2zm0 4H7v-2h10v2zm0 4H7v-2h10v2zm-6 4H7v-2h4v2zm-2-12v6a2 2 0 002 2h4a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2z"></path></svg>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-6 flex items-center justify-between hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
          <div>
            <p class="text-xl font-semibold text-gray-500">Total Stok</p>
            <p class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600 mt-2">{{ totalStokCount }}</p>
          </div>
          <svg class="w-16 h-16 text-purple-400 opacity-70" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import Sidebar from '../components/Sidebar.vue';
import apiClient from '../services/api';

const barangList = ref([]);

const totalBarangCount = computed(() => barangList.value.length);
const totalStokCount = computed(() => barangList.value.reduce((sum, barang) => sum + (barang.stok || 0), 0));

const fetchData = async () => {
  try {
    const response = await apiClient.get('/barang');
    barangList.value = response.data.data || [];
  } catch (error) {
    console.error('Error fetching barang data:', error);
  }
};

onMounted(() => {
  fetchData();
});
</script>