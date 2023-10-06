<script setup>

	import { defineProps, ref } from 'vue'
	import { useEventsStore } from '@/stores/events.js';
	import { useUsersStore } from '@/stores/users.js';

	import Modal from './Modal.vue'

	const eventsStore = useEventsStore();
	const usersStore = useUsersStore();

	const show = ref(false);
	const heading = ref(null);
	const errors = ref(null);

	function handler(axiosError) {
		heading.value = axiosError.message;
		errors.value = axiosError.response.data.errors;
		show.value = true;
	}

	eventsStore.$onAction(({onError}) => {
		onError(handler);
	});

	usersStore.$onAction(({onError}) => {
		onError(handler);
	});

</script>

<template>
	<Modal v-if="show" type="ok" :heading="heading" @close="show = false">
		<ul v-if="errors">
			<li v-for="error in errors">
				{{error}}
			</li>
		</ul>
	</Modal>
</template>
