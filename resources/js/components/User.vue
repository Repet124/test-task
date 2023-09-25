<script setup>
	import Title from './Title.vue';

	import axios from 'axios';
	import { ref, inject} from 'vue'

	const props = defineProps(['id']);
	const user = inject('user');

	const userData = ref(null);

	function getUser() {
		axios.get('/api/users/'+props.id)
			.then(response => {
				userData.value = response.data.result
			})
	}
	getUser();
</script>

<template>
	<div v-if="!userData" class="content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<p class="h2">Загрузка данных о пользователе...</p>
						<div class="overlay">
							<i class="fas fa-2x fa-sync-alt fa-spin"></i>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-else class="content-wrapper">
		<!-- Content Header (Page header) -->
		<Title>{{ userData.last_name }} {{ userData.first_name }}</Title>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<div class="card-title">Данные о пользователе</div>
							</div>
							<div class="card-body">
								<p class="card-text">
									Дата регистрации: {{ userData.created_at.split('T')[0] }}
								</p>
								<p class="card-text">
									Дата регистрации: {{ userData.birthday ? userData.birthday : 'Не указано' }}
								</p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
