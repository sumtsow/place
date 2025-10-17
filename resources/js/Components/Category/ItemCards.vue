<script setup>
import { Link } from '@inertiajs/vue3';
import LikeIcon from '@/Components/LikeIcon.vue';

defineProps({
	items: {
        type: Array,
	},
	wrapCols: {
		type: Boolean,
		default: false,
	},
});

const gtMedia = screen.width > 768;
</script>

<template>
	<div class="pb-1" :class="{'overflow-x-scroll': !wrapCols && gtMedia }">
		<div class="row g-4 py-2" :class="{'flex-nowrap': !wrapCols && gtMedia }">
			<div v-for="item in items" class="col-auto">
				<Link class="card h-100 m-1 pt-3 text-decoration-none" style="min-width: 180px; max-width: 267px;" :href="route('item', [item.id])">
					<img :src="item.images ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="card-img-top mx-auto" style="width: 165px;" :alt="item.name">
					<div class="card-body">
						<h6 class="card-title">{{ item.name }}</h6>
						<p class="card-text text-truncate text-wrap" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">{{ item.description }}</p>
						<p v-if="item.like" class="card-text">
							<LikeIcon class="d-inline-block mx-1"/>
							<small class="d-inline-block text-secondary fs-6">{{ item.like }}</small>
						</p>
					</div>
					<div class="card-footer text-secondary">
						<small>Updated {{ new Date( item.updated_at ).toLocaleString() }}</small>
					</div>
				</Link>
			</div>
		</div>
	</div>
</template>
