<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import CommentIcon from '@/Components/CommentIcon.vue';
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
	id: {
        type: String,
	},
});

const gtMedia = screen.width > 768;

let scrollX = 300;
let container;
const leftBtnDisabled = ref(true);
const rightBtnDisabled = ref(false);

const scrollLeft = (e) => {
	container = e.target.parentNode.nextElementSibling;
	let left = container.scrollLeft;
	if( !left ) leftBtnDisabled.value = true;
	rightBtnDisabled.value = false;
	if(container) container.scroll( left - scrollX, 0 );
};

const scrollRight = (e) => {
	container = e.target.parentNode.previousElementSibling;
	let left = container.scrollLeft;
	
	let width = container.scrollWidth - ( container.offsetWidth + scrollX );
	if( left > width ) rightBtnDisabled.value = true;
	leftBtnDisabled.value = false;
	if(container) container.scroll( left + scrollX, 0 );
};

</script>

<template>
	<div class="position-relative px-4">
		<div v-if="!wrapCols && gtMedia" class="position-absolute top-50 start-0 translate-middle-x z-3">
			<button class="h1 btn btn-secondary rounded-pill" :disabled="leftBtnDisabled" @click="scrollLeft"><</button>
		</div>
		<div class="pb-1 z-2" :class="{'overflow-x-hidden': !wrapCols && gtMedia }" style="scroll-behavior: smooth;">
			<div class="row g-4 py-2" :class="{'flex-nowrap': !wrapCols && gtMedia }">
				<div v-for="item in items" class="col-auto">
					<Link class="card h-100 m-1 pt-3 text-decoration-none" style="min-width: 180px; max-width: 267px;" :href="route('item', [item.id])">
						<div class="card-img text-center w-100" :style="'width: ' + imageSize + 'px; height: ' + imageSize + 'px;'">
							<img :src="item.images ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="d-inline-block h-100" :alt="item.name">
						</div>
						<div class="card-body pb-1">
							<h6 class="card-title d-flex align-items-center justify-content-center text-truncate text-wrap" style="min-height: 4em; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">
								<span>{{ item.name }}</span>
							</h6>
							<p class="card-text text-truncate text-wrap" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">{{ item.description }}</p>
							<div class="row" style="min-height: 2rem;">
								<div class="col">
									<template v-if="item.posts_count">
									<div class="d-inline-block" style="width: 26px; height: 26px;">
										<CommentIcon />
									</div>
									<div class="d-inline-block ms-1 align-bottom">{{ item.posts_count }}</div>
									</template>
								</div>
								<div v-if="item.like" class="col text-end">
									<div class="d-inline-block" style="width: 24px; height: 24px;">
										<LikeIcon />
									</div>
									<div class="d-inline-block ms-1 align-bottom">{{ item.like }}</div>
								</div>
							</div>
							<div class="row mt-2" v-if="item.min && item.max">
								<div class="col-auto">
									<h6 class="card-title mt-2">{{ $page.props.lang.customer.price }}</h6>
								</div>
								<div v-if="item.min === item.max" class="col">
								<p class="card-text text-end mb-0"><span class="fs-5 fw-bold">{{ item.min.toFixed(2) }}</span> {{ $page.props.lang.customer.currency }}</p>
								</div>
								<div v-else class="col">
									<p class="card-text text-end mb-0">{{ $page.props.lang.customer.from }} <span class="fs-5 fw-bold">{{ item.min.toFixed(2) }}</span> {{ $page.props.lang.customer.currency }}</p>
									<p class="card-text text-end mb-0">{{ $page.props.lang.customer.to }} <span class="fs-5 fw-bold">{{ item.max.toFixed(2) }}</span> {{ $page.props.lang.customer.currency }}</p>
								</div>
							</div>
						</div>
						<div class="card-footer text-secondary">
							<small>{{ $page.props.lang.admin.updated + ' ' +  new Date( item.updated_at ).toLocaleString() }}</small>
						</div>
					</Link>
				</div>
			</div>
		</div>
		<div v-if="!wrapCols && gtMedia" class="position-absolute top-50 start-100 translate-middle-x z-3">
			<button class="h1 btn btn-secondary rounded-pill" :disabled="rightBtnDisabled" @click="scrollRight">></button>
		</div>
	</div>
</template>
