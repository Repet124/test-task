import { ref, computed, inject } from 'vue'
import { defineStore } from 'pinia'
import { useRouter } from 'vue-router'
import { toAPI } from './_lib.js'

export const useEventsStore = defineStore('events', ()=>{

	const user = inject('user');
	const events = ref([]);
	const router = useRouter();

	const myEvents = computed(() => {
		return events.value.filter(event =>
			event.members.find(member => member.id === user.id)
		);
	});

	const eventById = computed(() => {
		return id => {
			id = Number(id);
			if (!events.value) {
				return null;
			}
			return events.value.find(event => event.id === id);
		}
	});

	function refresh() {
		return toAPI('get', '/api/events', response => {
			events.value = null;
			events.value = response.data.result;
		});
	}

	function deleteEvent(id) {
		return toAPI('delete', '/api/events/'+id, () => {
			router.push('/dashboard');
			refresh();
		});
	}

	function involveToEvent(eventId) {
		return toAPI('get', '/api/events/'+eventId+'/involve', refresh)
	}

	function leaveFromEvent(eventId) {
		return toAPI('get', '/api/events/'+eventId+'/leave', refresh)

	}

	refresh();

	return {
		// states
		events,
		// getters
		myEvents,
		eventById,
		//actions
		refresh,
		deleteEvent,
		involveToEvent,
		leaveFromEvent
	}
});
