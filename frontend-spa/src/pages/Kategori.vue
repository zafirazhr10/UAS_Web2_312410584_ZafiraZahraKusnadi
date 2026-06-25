<template>
  <div class="flex h-screen bg-slate-50">
    <Sidebar />
    
    <main class="flex-1 p-8 overflow-y-auto">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-extrabold text-gray-900">Manajemen Kategori</h2>
        <button @click="openAddModal" class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all px-4 py-2 font-medium">
          Tambah Kategori
        </button>
      </div>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-100">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Kategori</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Dibuat</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <tr v-for="kategori in kategoriBuat" :key="kategori.id" class="hover:bg-indigo-50/50 transition-colors duration-200 border-b border-slate-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ kategori.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ kategori.nama_kategori }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatDateTime(kategori.created_at) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                  <button @click="openEditModal(kategori)" class="bg-amber-100 text-amber-700 hover:bg-amber-200 rounded-lg px-3 py-1 font-medium transition-colors mr-2">Edit</button>
                  <button @click="deleteData(kategori.id)" class="bg-rose-100 text-rose-700 hover:bg-rose-200 rounded-lg px-3 py-1 font-medium transition-colors">Hapus</button>
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
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
            <form @submit.prevent="saveData" class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" v-model="form.nama_kategori" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
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
import { ref, onMounted } from 'vue';
import Sidebar from '../components/Sidebar.vue';
import Toast from '../components/Toast.vue';
import apiClient from '../services/api';

const kategoriBuat = ref([]);
const showModal = ref(false);
const isEdit = ref(false);
const toastRef = ref(null);
const form = ref({
  id: null,
  nama_kategori: '',
});

const formatDateTime = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const fetchData = async () => {
  try {
    const response = await apiClient.get('/kategori');
    kategoriBuat.value = response.data.data || response.data || [];
  } catch (error) {
    console.error('Error fetching kategori:', error);
  }
};

const saveData = async () => {
  if (!form.value.nama_kategori) {
    toastRef.value?.addToast('Nama kategori wajib diisi!', 'warning');
    return;
  }
  try {
    const payload = { nama_kategori: form.value.nama_kategori };
    if (isEdit.value) {
      await apiClient.put(`/kategori/${form.value.id}`, payload);
      toastRef.value?.addToast('Kategori berhasil diperbarui!', 'success');
    } else {
      await apiClient.post('/kategori', payload);
      toastRef.value?.addToast('Kategori berhasil ditambahkan!', 'success');
    }
    showModal.value = false;
    form.value = { id: null, nama_kategori: '' };
    await fetchData();
  } catch (error) {
    console.error('API Error:', error);
    toastRef.value?.addToast('Gagal menyimpan kategori!', 'error');
  }
};

const deleteData = async (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
    try {
      await apiClient.delete(`/kategori/${id}`);
      toastRef.value?.addToast('Kategori berhasil dihapus!', 'success');
      fetchData();
    } catch (error) {
      console.error('Error deleting kategori:', error);
      toastRef.value?.addToast('Gagal menghapus kategori!', 'error');
    }
  }
};

const openAddModal = () => {
  isEdit.value = false;
  form.value = {
    id: null,
    nama_kategori: '',
  };
  showModal.value = true;
};

const openEditModal = (kategori) => {
  isEdit.value = true;
  form.value = { ...kategori };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

onMounted(() => {
  fetchData();
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