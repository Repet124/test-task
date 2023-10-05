<script setup>
	import Title from './Title.vue';

	import { computed, inject } from 'vue'
	import { useEventsStore } from '@/stores/events.js'

	const props = defineProps(['id']);
	const user = inject('user');
	const store = useEventsStore();

	const isMyEvent = computed(() => {
			if (!store.eventById(props.id)) {
				return false;
			}
			return store.eventById(props.id).members.some(member => {
				return member.id === Number(user.id);
			})
		}
	)

</script>

<template>
	<div v-if="!store.eventById(props.id)" class="content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<p class="h2">Загрузка события...</p>
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
		<Title>{{ store.eventById(props.id).title }}</Title>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<div class="card-title">Описание события</div>
							</div>
							<div class="card-body">
								<p class="card-text">
									{{ store.eventById(props.id).description }}
								</p>
								<p class="card-text">
									Автор события: {{ store.eventById(props.id).creator.first_name }} {{ store.eventById(props.id).creator.last_name }}
								</p>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title">Участники</div>
							</div>
							<div class="card-body">
								<ul v-if="store.eventById(props.id).members.length" class="list-group list-group-flush">
									<li v-for="member in store.eventById(props.id).members" class="list-group-item">
										<router-link :to="`/dashboard/users/${member.id}`">
											{{ member.last_name }} {{ member.first_name }}
										</router-link>
									</li>
								</ul>
							</div>
						</div>

						<button
							v-if="isMyEvent"
							@click="store.leaveFromEvent(props.id)"
							class="btn btn-danger mr-2"
						>
							Отказаться от участия
						</button>

						<button
							v-else
							@click="store.involveToEvent(props.id)"
							class="btn btn-primary mr-2"
						>
							Принять участие
						</button>

						<button
							v-if="store.eventById(props.id).creator.id === user.id"
							@click="store.deleteEvent(props.id)"
							class="btn btn-danger mr-2"
						>
							Удалить событие
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
