<script setup>
	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';

	import axios from 'axios';
	import { provide } from 'vue';

	const props = defineProps(['user']);

	function requestToAPI() {

	}

	function toAPI(url) {

	}
	provide('user', props.user);
</script>

<template>
	<!-- Navbar -->
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
