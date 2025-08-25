<script setup>
import Carousel from '@/Components/Carousel.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
	item: {
        type: Object,
	},
});
</script>

<template>
	<div class="row">
		<div class="col">
			<div class="card h-100 justify-content-center">
				<template v-if="JSON.parse(item.images)">
					<carousel v-if="JSON.parse(item.images).length > 1" :images="JSON.parse(item.images)"></carousel>
					<img v-else :src="'/storage/img/' + JSON.parse(item.images)[0]" class="card-img-top" :alt="'image-' + item.id" style="height: 256px; width: auto; margin: 30px auto;">
				</template>
				<img v-else src="/storage/img/no-image.png" class="card-img-top" :alt="'image-' + item.id" style="height: 256px; width: auto; margin: 30px auto;">
				<div class="card-body">
					<h5 class="card-title">{{ item.name }}</h5>
					<p class="card-text">
						{{ item.description }}
					</p>
				</div>
			</div>
		</div>
	</div>
</template>
