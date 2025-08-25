<script setup>
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
				<img :src="JSON.parse(item.images) ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="card-img-top" :alt="'image-' + item.id" style="height: 256px; width: auto; margin: 30px auto;">
				<div class="card-body">
					<h5 class="card-title">{{ item.name }}</h5>
					<p class="card-text">
						<Link :href="route('item', [item.id])" class="stretched-link">
							{{ item.description }}
						</Link>
					</p>
				</div>
			</div>
		</div>
	</div>
</template>
