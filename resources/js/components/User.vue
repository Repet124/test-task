<script setup>
	import { inject} from 'vue'

	import Title from './Title.vue';

	import { useUsersStore } from '@/stores/users.js';

	const props = defineProps(['id']);
	const store = useUsersStore();

	if (!store.users) {
		store.refresh();
	}

</script>

<template>
	<div v-if="!store.userById(props.id)" class="content-wrapper">
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
		<Title>{{ store.userById(props.id).last_name }} {{ store.userById(props.id).first_name }}</Title>
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
									Дата регистрации: {{ store.userById(props.id).created_at.split('T')[0] }}
								</p>
								<p class="card-text">
									Дата регистрации: {{ store.userById(props.id).birthday ? store.userById(props.id).birthday : 'Не указано' }}
								</p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
