<script setup>
	import Header from './components/Header.vue';
	import Sidebar from './components/Sidebar.vue';
</script>

<template>
	<!-- Navbar -->
	<Header />
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<Sidebar />

	<!-- Content Wrapper. Contains page content -->
	<router-view></router-view>
	<!-- /.content-wrapper -->
</template>
