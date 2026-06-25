<template>
  <Teleport to="body">
    <TransitionGroup name="toast-slide" tag="div" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        :class="[
          'flex items-center gap-3 px-5 py-4 rounded-2xl shadow-2xl backdrop-blur-md border min-w-[320px] max-w-[420px]',
          toast.type === 'success' ? 'bg-emerald-500/90 border-emerald-400/50 text-white' : '',
          toast.type === 'error' ? 'bg-rose-500/90 border-rose-400/50 text-white' : '',
          toast.type === 'warning' ? 'bg-amber-500/90 border-amber-400/50 text-white' : '',
          toast.type === 'info' ? 'bg-indigo-500/90 border-indigo-400/50 text-white' : '',
        ]"
      >
        <div class="flex-shrink-0">
          <svg v-if="toast.type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <svg v-else-if="toast.type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <svg v-else-if="toast.type === 'warning'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
          <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-sm font-medium flex-1">{{ toast.message }}</p>
        <button @click="removeToast(toast.id)" class="flex-shrink-0 opacity-70 hover:opacity-100 transition-opacity">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
    </TransitionGroup>
  </Teleport>
</template>

<script setup>
import { ref } from 'vue';

const toasts = ref([]);
let counter = 0;

const addToast = (message, type = 'success', duration = 3500) => {
  const id = ++counter;
  toasts.value.push({ id, message, type });
  setTimeout(() => removeToast(id), duration);
};

const removeToast = (id) => {
  toasts.value = toasts.value.filter(t => t.id !== id);
};

defineExpose({ addToast });
</script>

<style scoped>
.toast-slide-enter-active {
  transition: all 0.4s cubic-bezier(0.21, 1.02, 0.73, 1);
}
.toast-slide-leave-active {
  transition: all 0.3s cubic-bezier(0.06, 0.71, 0.55, 1);
}
.toast-slide-enter-from {
  opacity: 0;
  transform: translateX(100px) scale(0.9);
}
.toast-slide-leave-to {
  opacity: 0;
  transform: translateX(100px) scale(0.9);
}
</style>