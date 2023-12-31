import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';

import Event from './components/Event.vue';
import Main from './components/Main.vue';
import User from './components/User.vue';

const routes = [
	{path: '/dashboard', component: Main},
	{path: '/dashboard/event/:id', component: Event, props: true},
	{path: '/dashboard/users/:id', component: User, props: true}
];

const router = createRouter({
	history: createWebHistory(),
	routes: routes
});

const pinia = createPinia();

const app = createApp(App, {});

app.provide('user', JSON.parse(document.getElementById('app').dataset.user))
app.use(router);
app.use(pinia);
app.mount('#app');
