<script setup>
	import axios from 'axios';
	import { provide, ref } from 'vue';

	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';
	import ErrorModal from './components/ErrorModal.vue';

	import { useEventsStore } from '@/stores/events.js';

	const eventsStore = useEventsStore();

	setInterval(() => {
		eventsStore.refresh();
	}, 30*1000);

</script>

<template>
	<!-- Navbar -->
	<ErrorModal />
	<Header />
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<Sidebar/>

	<!-- Content Wrapper. Contains page content -->
	<router-view></router-view>
	<footer class="main-footer">
		<strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
		All rights reserved.
		<div class="float-right d-none d-sm-inline-block">
			<b>Version</b> 3.2.0
		</div>
	</footer>
	<!-- /.content-wrapper -->
</template>
