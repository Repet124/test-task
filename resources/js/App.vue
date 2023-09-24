<script setup>
	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';

	const props = defineProps(['user']);
</script>

<template>
	<!-- Navbar -->
	<Header />
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<Sidebar :user="user"/>

	<!-- Content Wrapper. Contains page content -->
	<router-view></router-view>
	<!-- /.content-wrapper -->
</template>
