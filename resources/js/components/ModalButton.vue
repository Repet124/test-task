<script setup>
	const props = defineProps({
		danger: {
			type: Boolean,
			default: false
		}
	});
</script>

<template>
	<button

		type="button"
		:class="[danger ? 'btn-danger' : 'btn-primary']"
		class="btn btn-secondary mr-2"
		data-bs-dismiss="modal"
	>
		<slot/>
	</button>
</template>
