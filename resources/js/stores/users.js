import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { toAPI } from './_lib.js'

export const useUsersStore = defineStore('users', () => {

	const users = ref(null);

	const userById = computed(() => {
		return id => {
			if (!users.value) {
				return null;
			}
			return users.value.find(user => user.id === Number(id));
		}
	});

	function refresh() {
		return toAPI('get', '/api/users', response => {
			users.value = null;
			users.value = response.data.result;
		})
	}

	return {
		// states
		users,
		// getters
		userById,
		// actions
		refresh,
	}

});
