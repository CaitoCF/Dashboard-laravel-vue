<template>
	<transition name="modal-animation">
		<div class="modal">
			<transition name="modal-animation-inner">
				<div class="modal-inner">
					<button @click="$emit('close')" type="button"><i class="fa fa-xmark"></i></button>
					<!-- Modal Content -->
					<slot />
				</div>
			</transition>
		</div>
	</transition>
</template>
  
<script>
export default {
	props: ["modalActive"],
	methods: {
		
    },
};
</script>

<style lang="scss" src="./style.scss" scoped />