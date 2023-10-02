<script setup>
	import Title from './Title.vue';

	import axios from 'axios';
	import { ref, watch, computed, inject, onUnmounted} from 'vue'
	import { useRouter } from 'vue-router'

	const props = defineProps(['id']);
	const event = ref(null);
	const user = inject('user');
	const router = useRouter();
	const isMyEvent = computed(() => {
		return !!event.value.members.find(member => {
			return member.id === user.id;
		})
	})

	watch(
		() => props.id,
		() => {
			getEvent()
		}
	)

	function involve() {
		axios.get('/api/events/'+props.id+'/involve')
			.then(response => {
				getEvent();
			})
	}

	function leave() {
		axios.get('/api/events/'+props.id+'/leave')
			.then(response => {
				getEvent();
			})
	}

	function getEvent() {
		event.value = null;
		axios.get('/api/events/'+props.id)
			.then(response => {
				event.value = response.data.result
			})
	}

	function deleteEvent() {
		event.value = null;
		axios.delete('/api/events/'+props.id)
			.then(response => {
				router.push('/dashboard');
			});
	}
	getEvent();
	let interval = setInterval(() => {
		getEvent();
	}, 30*1000);

	onUnmounted(() => {
		clearInterval(interval)
	});

</script>

<template>
	<div v-if="!event" class="content-wrapper">
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
		<Title>{{ event.title }}</Title>
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
									{{ event.description }}
								</p>
								<p class="card-text">
									Автор события: {{ event.creator.first_name }} {{ event.creator.last_name }}
								</p>
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title">Участники</div>
							</div>
							<div class="card-body">
								<ul v-if="event.members.length" class="list-group list-group-flush">
									<li v-for="member in event.members" class="list-group-item">
										<router-link :to="`/dashboard/users/${member.id}`">
											{{ member.last_name }} {{ member.first_name }}
										</router-link>
									</li>
								</ul>
							</div>
						</div>

						<button @click="leave" v-if="isMyEvent" class="btn btn-danger mr-2">Отказаться от участия</button>
						<button @click="involve" v-else class="btn btn-primary mr-2">Принять участие</button>
						<button @click="deleteEvent" v-if="event.creator.id === user.id" class="btn btn-danger mr-2">Удалить событие</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
