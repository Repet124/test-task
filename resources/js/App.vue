<script setup>
	import axios from 'axios';
	import { provide, ref } from 'vue';

	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';
	import Modal from './components/Modal.vue';

	import API from './API.js';

	const props = defineProps(['user']);
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

	function toAPI() {
		return new API()
			.catch(error => {
				console.log('err')
				modalShowing(error.message, 'ok');
			});
	}

	provide('user', props.user);
	provide('API', toAPI);
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
