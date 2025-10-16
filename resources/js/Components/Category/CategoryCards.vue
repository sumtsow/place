<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	items: {
        type: Array,
	},
});
</script>

<template>
	<div class="overflow-hidden pb-1">
		<div class="row row-cols-1 row-cols-md-5 flex-nowrap g-4">
			<div v-for="item in items" class="col">
				<div class="card h-100 m-1 pt-3" style="min-width: 180px;">
					<img :src="JSON.parse(item.images) ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="card-img-top mx-auto" style="width: 165px;" :alt="item.name">
					<div class="card-body">
						<h6 class="card-title">{{ item.name }}</h6>
						<p class="card-text text-truncate text-wrap" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">{{ item.description }}</p>
					</div>
					<div class="card-footer text-body-secondary">
						Updated {{ new Date( item.updated_at ).toLocaleString() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
