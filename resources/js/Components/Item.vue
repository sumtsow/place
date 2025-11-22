<script setup>
import Carousel from '@/Components/Carousel.vue';
import ItemPostList from '@/Components/ItemPostList.vue';
import LikeIcon from '@/Components/LikeIcon.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	item: {
        type: Object,
	},
	distributors: {
		type: Array,
	},
	emptyParamGroup: {
		type: String,
	},
	emptyParameter: {
		type: String,
	},
	emptyPost: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
});

let groupId = 0;
let isNew = false;
const formatDescription = (text) => {
	return '<p>' + text.replace(/\n/g, '</p><p>') + '</p>';
}
</script>

<template>
	<div class="row">
		<div class="col">
			<div class="align-items-start">
				<div class="d-inline-block h2 align-top">
					{{ item.name }}
				</div>
				<div v-if="item.like" class="d-inline-block ms-3 me-1 pt-1" style="width: 24px; height: 24px;">
					<LikeIcon />
				</div>
				<div class="d-inline-block fs-5 align-middle">
					{{ item.like }}
				</div>
			</div>
		</div>
	</div>
	<div class="row align-items-center">
		<div class="col">
			<div class="justify-content-center">
				<template v-if="JSON.parse(item.images)">
					<carousel v-if="JSON.parse(item.images).length > 1" :images="JSON.parse(item.images)"></carousel>
					<img v-else :src="'/storage/img/' + JSON.parse(item.images)[0]" class="" :alt="'image-' + item.id" style="height: 256px; width: auto; margin: 30px auto;">
				</template>
				<img v-else src="/storage/img/no-image.png" class="" :alt="'image-' + item.id" style="height: 256px; width: auto;">
			</div>
		</div>
		<div class="col">
			<h4 v-if="item.distributorItems.length">{{ $page.props.lang.customer.price }}</h4>
			
			<div v-for="distributor in item.distributorItems" class="row fs-5" :class="{ 'text-body-tertiary': !distributor.is_enabled || !distributor.is_enabled }">
				<template v-if="props.auth.isAdmin || distributor.is_enabled">
				<div class="col">
					<span class="fs-4 fw-bold">{{ distributor.discountPrice.toFixed(2) }}</span> {{ $page.props.lang.customer.currency }}
					<small v-if="distributor.discount" class="badge rounded-pill text-bg-danger">&ndash; {{ distributor.discount }}%</small>
				</div>
				<div class="col mt-1">
					<a v-if="distributor.url" target="_blank" :href="distributor.url" class="">
					{{ distributor.distributor.name }}
					</a>
					<template v-else>
					{{ distributor.distributor.name }}
					</template>
				</div>
				</template>
			</div>
		</div>
	</div>
	<div class="row my-3">
		<div class="col">
			<ul class="nav nav-tabs mb-3" id="itemTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" aria-controls="desc-tab-pane" aria-selected="true">{{ $page.props.lang.admin.description }}</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="params-tab" data-bs-toggle="tab" data-bs-target="#params-tab-pane" type="button" role="tab" aria-controls="params-tab-pane" aria-selected="false">{{ $page.props.lang.admin.parameters }}</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts-tab-pane" type="button" role="tab" aria-controls="posts-tab-pane" aria-selected="false">
					{{ $page.props.lang.customer.posts }}
					<span v-if="item.posts_count" class="badge rounded-pill text-bg-primary ms-1">{{ item.posts_count }}</span>
					</button>
				</li>
			</ul>
			<div class="tab-content" id="itemTabContent">
				<div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel" aria-labelledby="desc-tab" tabindex="0" v-html="formatDescription( item.description )">
				</div>
				<div class="tab-pane fade" id="params-tab-pane" role="tabpanel" aria-labelledby="params-tab" tabindex="0">
					<template v-if="item.parameters && item.parameters.length > 0">
						<table class="table table-striped">
							<tbody>
							<template v-for="parameter in item.parameters">
								<template v-if="parameter.group">
									<span class="d-none">{{ isNew = groupId != parameter.group.id }} {{ groupId = isNew ? parameter.group.id : groupId }}</span>
									<tr v-if="isNew">
										<th class="table-primary" colspan="2">
											{{ parameter.group.name }}
										</th>
									</tr>
								</template>
								<template v-else>
									<span class="d-none">{{ isNew = groupId != 0 }} {{ groupId = 0 }}</span>
									<tr v-if="isNew">
										<th class="table-primary" colspan="2">
											{{ props.emptyParamGroup }}
										</th>
									</tr>
									<span class="d-none">{{ isNew = false }}</span>
								</template>
								<template v-if="parameter.pivot">
								<tr>
									<td>{{ parameter.name }}</td>
									<td class="text-end">
									{{ parameter.pivot.value !== null ? parameter.pivot.value : emptyParameter }} 
									{{ parameter.pivot.value !== null && parameter.unit ? parameter.unit.name : '' }}
									</td>
								</tr>
								</template>
							</template>
							</tbody>
						</table>
					</template>
				</div>
				<div class="tab-pane fade" id="posts-tab-pane" role="tabpanel" aria-labelledby="posts-tab" tabindex="0">
					<ItemPostList :item="item" :post="emptyPost" :comment="emptyComment"/>
				</div>
			</div>
		</div>
	</div>
</template>
