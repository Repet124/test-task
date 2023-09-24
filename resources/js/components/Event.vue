<script setup>
	import Title from './Title.vue';

	import axios from 'axios';
	import { ref, watch, computed, inject} from 'vue'

	const props = defineProps(['id']);
	const event = ref(null);
	const user = inject('user');
	const isMyEvent = computed(() => {
		return !!event.value.members.find(member => {
			return member.id === user.id;
		})
	})

	watch(
		() => props.id,
		(id) => {
			getEvent(id)
		}
	)

	function getEvent(id) {
		event.value = null;
		axios.get('/api/events/'+id)
			.then(response => {
				event.value = response.data.result
			})
	}
	getEvent(props.id);
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

							</div>
						</div>
						<div class="card">
							<div class="card-header">
								<div class="card-title">Участники</div>
							</div>
							<div class="card-body">
								<ul v-if="event.members.length" class="list-group list-group-flush">
									<li v-for="member in event.members" class="list-group-item">
										{{ member.last_name }} {{ member.first_name }}
									</li>
								</ul>
							</div>
						</div>

						<button v-if="isMyEvent" class="btn btn-danger">Отказаться от участия</button>
						<button v-else class="btn btn-primary">Принять участие</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
