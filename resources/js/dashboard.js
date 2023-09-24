import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';

import Event from './components/Event.vue';

const routes = [
	{path: '/dashboard', component: Event},
	{path: '/dashboard/event/:id', component: Event}
];

const router = createRouter({
	history: createWebHistory(),
	routes: routes
});

const app = createApp(App, {
	user: JSON.parse(document.getElementById('app').dataset.user)
});
app.use(router);
app.mount('#app');
