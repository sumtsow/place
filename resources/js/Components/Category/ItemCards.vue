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
	imageSize: {
        type: Number,
	},
});

const gtMedia = screen.width > 768;
</script>

<template>
	<div class="pb-1" :class="{'overflow-x-scroll': !wrapCols && gtMedia }">
		<div class="row g-4 py-2" :class="{'flex-nowrap': !wrapCols && gtMedia }">
			<div v-for="item in items" class="col-auto">
				<Link class="card h-100 m-1 pt-3 text-decoration-none" style="min-width: 180px; max-width: 267px;" :href="route('item', [item.id])">
					<div class="px-2">
						<img :src="item.images ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="d-block card-img-top mx-auto" :style="'width: ' + imageSize + 'px; height: ' + imageSize + 'px;'" :alt="item.name">
					</div>
					<div class="card-body">
						<h6 class="card-title d-flex align-items-center justify-content-center text-truncate text-wrap" style="min-height: 4em; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">
                            <span>{{ item.name }}</span>
                        </h6>
						<p class="card-text text-truncate text-wrap" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">{{ item.description }}</p>
						<div class="row">
							<div class="col-auto">
								<h6 class="card-title">{{ $page.props.lang.customer.price }}</h6>
							</div>
							<div class="col">
								<p class="card-text text-end mb-0">{{ $page.props.lang.customer.from }} {{ item.min }} {{ $page.props.lang.customer.currency }}</p>
								<p class="card-text text-end mb-0">{{ $page.props.lang.customer.to }} {{ item.max }} {{ $page.props.lang.customer.currency }}</p>
							</div>
						</div>
					</div>
					<div class="card-footer text-secondary">
						<small>{{ $page.props.lang.admin.updated + ' ' +  new Date( item.updated_at ).toLocaleString() }}</small>
						<div v-if="item.like" class="d-inline float-end">
							<LikeIcon class="d-inline-block mx-1"/>
							<small class="d-inline-block text-secondary">{{ item.like }}</small>
						</div>
					</div>
				</Link>
			</div>
		</div>
	</div>
</template>
