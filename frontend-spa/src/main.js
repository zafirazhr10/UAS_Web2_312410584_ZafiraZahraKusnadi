import { createApp } from 'vue';
import './style.css'; // Requires Tailwind v4
import App from './App.vue';
import router from './router';

const app = createApp(App);
app.use(router);
app.mount('#app');