<script setup>
	import axios from 'axios';
	import { provide, ref } from 'vue';

	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';
	import Modal from './components/Modal.vue';

	import { useEventsStore } from '@/stores/events.js';

	const store = useEventsStore();

	const showModal = ref(false);
	const modalHeading = ref('');
	const modalType = ref('ok');
	const modalMessage = ref('');

	function modalShowing(heading, type, message) {
		modalHeading.value = heading;
		modalType.value = type;
		modalMessage.value = message;
		showModal.value = true;
	}

	function modalHidding() {
		showModal.value = false;
		modalHeading.value = '';
		modalType.value = 'ok';
		modalMessage.value = '';
	}

	store.$onAction(({name, store, args, after, onError}) => {
		onError((error) => {
			console.log('err')
			modalShowing(error.message, 'ok');
		})
	});

	setInterval(() => {
		store.refresh();
	}, 30*1000);

</script>

<template>
	<!-- Navbar -->
	<Modal v-if="showModal" :type="modalType" @close="modalHidding">
		{{ modalMessage }}
	</Modal>
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
