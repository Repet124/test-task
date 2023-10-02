<script setup>

	import { ref } from 'vue';
	import { onMounted } from 'vue'

	const props = defineProps(['type', 'heading']);
	const emit = defineEmits(['close', 'confirm']);
	const modal = ref(null);

	onMounted(() => {
		new bootstrap.Modal(modal, {keyboard: false}).show();
	});

	function close(e) {
		if(e.target === modalWrapper) {
			emit('close');
		}
	}

	function confirm() {
		emit('close');
		emit('confirm');
	}

</script>

<template>

<Teleport to="body">
	<div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" ref="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ heading }}</h5>
					<button
						type="button"
						class="btn-close"
						data-bs-dismiss="modal"
						aria-label="Close"
						@click="$emit('close')"
					></button>
				</div>
				<div class="modal-body">
					<slot />
				</div>
				<div class="modal-footer">
					<ModalButton v-if="type==='confirm'" @click="confirm">
						Подтвердить
					</ModalButton>
					<ModalButton v-if="type==='confirm'" @click="$emit('close')" :danger="true">
						Закрыть
					</ModalButton>
					<ModalButton v-if="type==='ok'" @click="confirm">
						Ок
					</ModalButton>
				</div>
			</div>
		</div>
	</div>
</Teleport>

</template>
