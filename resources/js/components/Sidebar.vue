<script setup>
	import { ref, computed, inject } from 'vue'

	const events = ref([]);

	const user = inject('user');
	const API = inject('API');

	const myEvents = computed(() => {
		return events.value.filter(event => {
			return event.members.find(member => member.id === user.id);
		});
	});


	function getEvents() {
		API().get('/api/events')
			.then(response => {
				events.value = null;
				events.value = response.data.result
			})
	}
	getEvents();
	setInterval(() => {
		getEvents();
	}, 30*1000);
</script>
<template>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<router-link to="/dashboard" class="brand-link">
			<span class="brand-text font-weight-light">AdminLTE 3</span>
		</router-link>

		<!-- Sidebar -->
		<div class="sidebar">
			<!-- Sidebar user panel (optional) -->
			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="info">
					<a href="#" class="d-block">{{ user.last_name }} {{ user.first_name }}</a>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class
							 with font-awesome or any other icon font library -->
					<li class="nav-header">ВСЕ СОБЫТИЯ</li>
					<li v-if="events.length" v-for="event in events" class="nav-item">
						<router-link :to="`/dashboard/event/${event.id}`" class="nav-link">
							<i class="fas fa-circle nav-icon"></i>
							<p>{{ event.title }}</p>
						</router-link>
					</li>

					<li class="nav-header">MOИ СОБЫТИЯ</li>
					<li v-if="events.length" v-for="event in myEvents" class="nav-item">
						<router-link :to="`/dashboard/event/${event.id}`" class="nav-link">
							<i class="fas fa-circle nav-icon"></i>
							<p>{{ event.title }}</p>
						</router-link>
					</li>
				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>
</template>
