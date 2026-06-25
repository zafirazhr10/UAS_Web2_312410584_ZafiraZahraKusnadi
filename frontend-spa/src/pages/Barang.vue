<template>
  <div class="flex h-screen bg-slate-50">
    <Sidebar />
    
    <main class="flex-1 p-8 overflow-y-auto">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-extrabold text-gray-900">Manajemen Barang</h2>
        <div class="flex items-center space-x-4">
          <input type="text" v-model="searchQuery" placeholder="Cari barang..." class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm" />
          <button @click="openAddModal" class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all px-4 py-2 font-medium">
            Tambah Barang
          </button>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-100">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Barang</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Deskripsi</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Stok</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Harga</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Kategori</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="barang in filteredBarang" :key="barang.id" class="hover:bg-indigo-50/50 transition-colors duration-200 border-b border-slate-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ barang.nama_barang }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ barang.deskripsi }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ barang.stok }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ formatNumber(barang.harga) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ getCategoryName(barang.kategori_id) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                  <button @click="openEditModal(barang)" class="bg-amber-100 text-amber-700 hover:bg-amber-200 rounded-lg px-3 py-1 font-medium transition-colors mr-2">Edit</button>
                  <button @click="deleteData(barang.id)" class="bg-rose-100 text-rose-700 hover:bg-rose-200 rounded-lg px-3 py-1 font-medium transition-colors">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Add/Edit Modal -->
      <Transition name="modal-fade">
        <div v-if="showModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50">
          <div class="bg-white rounded-2xl shadow-2xl p-6 transform transition-all scale-100 w-full max-w-md">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ isEdit ? 'Edit Barang' : 'Tambah Barang' }}</h3>
            <form @submit.prevent="saveData" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text" v-model="form.nama_barang" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea v-model="form.deskripsi" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" v-model="form.stok" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" v-model="form.harga" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <select v-model="form.kategori_id" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="" disabled>Pilih Kategori</option>
                  <option v-for="kat in kategoriList" :key="kat.id" :value="kat.id">{{ kat.nama_kategori }}</option>
                </select>
              </div>
              <div class="flex justify-end space-x-4 pt-4">
                <button type="button" @click="closeModal" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">Cancel</button>
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md transition-all">
                  {{ isEdit ? 'Update' : 'Add' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </Transition>

      <Toast ref="toastRef" />
    </main>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import Sidebar from '../components/Sidebar.vue';
import Toast from '../components/Toast.vue';
import apiClient from '../services/api';

const barangList = ref([]);
const kategoriList = ref([]);
const showModal = ref(false);
const isEdit = ref(false);
const searchQuery = ref('');
const toastRef = ref(null);
const form = ref({
  id: null,
  nama_barang: '',
  deskripsi: '',
  stok: 0,
  harga: 0,
  kategori_id: '',
});

const filteredBarang = computed(() => {
  if (!searchQuery.value) {
    return barangList.value;
  }
  const query = searchQuery.value.toLowerCase();
  return barangList.value.filter(
    (barang) =>
      barang.nama_barang.toLowerCase().includes(query) ||
      barang.deskripsi.toLowerCase().includes(query)
  );
});

const formatNumber = (num) => {
  return new Intl.NumberFormat('id-ID').format(num);
};

const getCategoryName = (id) => {
  const category = kategoriList.value.find((kat) => String(kat.id) === String(id));
  return category ? category.nama_kategori : '-';
};

const fetchKategori = async () => {
  try {
    const response = await apiClient.get('/kategori');
    kategoriList.value = response.data.data || response.data || [];
  } catch (error) {
    console.error('Fetch Kategori Error:', error);
  }
};

const fetchData = async () => {
  try {
    const response = await apiClient.get('/barang');
    barangList.value = response.data.data || response.data || [];
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

const saveData = async () => {
  try {
    if (isEdit.value) {
      await apiClient.put(`/barang/${form.value.id}`, form.value);
      toastRef.value?.addToast('Barang berhasil diperbarui!', 'success');
    } else {
      await apiClient.post('/barang', form.value);
      toastRef.value?.addToast('Barang berhasil ditambahkan!', 'success');
    }
    closeModal();
    await fetchData();
  } catch (error) {
    console.error('Error saving data:', error);
    toastRef.value?.addToast('Gagal menyimpan barang!', 'error');
  }
};

const deleteData = async (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
    try {
      await apiClient.delete(`/barang/${id}`);
      toastRef.value?.addToast('Barang berhasil dihapus!', 'success');
      fetchData();
    } catch (error) {
      console.error('Error deleting data:', error);
      toastRef.value?.addToast('Gagal menghapus barang!', 'error');
    }
  }
};

const openAddModal = () => {
  isEdit.value = false;
  form.value = {
    id: null,
    nama_barang: '',
    deskripsi: '',
    stok: 0,
    harga: 0,
    kategori_id: '',
  };
  showModal.value = true;
};

const openEditModal = (barang) => {
  isEdit.value = true;
  form.value = { ...barang };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

onMounted(() => {
  fetchData();
  fetchKategori();
});
</script>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: all 0.3s ease-out;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.9);
}
.modal-fade-enter-to, .modal-fade-leave-from {
  opacity: 1;
  transform: scale(1);
}
</style>