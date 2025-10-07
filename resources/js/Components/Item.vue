<script setup>
import Carousel from '@/Components/Carousel.vue';
import ItemPostList from '@/Components/ItemPostList.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;


defineProps({
	item: {
        type: Object,
	},
	auth: {
		type: Object,
	},
});
</script>

<template>
	<div class="row">
		<div class="col">
			<h2>{{ item.name }}</h2>
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
			<h4>Prices:</h4>
			<div v-for="distributor in item.distributors" class="row fs-5" :class="{ 'text-body-tertiary': !distributor.is_enabled || !distributor.pivot.is_enabled }">
				<div class="col">
					{{( (1 - 0.01 * distributor.pivot.discount) * distributor.pivot.price ).toFixed(2) }} {{ props.currency }}
					<small v-if="distributor.pivot.discount" class="badge rounded-pill text-bg-danger">&ndash; {{ distributor.pivot.discount }}%</small>
				</div>
				<div class="col">{{ distributor.name }}</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<ul class="nav nav-tabs mb-3" id="itemTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" aria-controls="desc-tab-pane" aria-selected="true">Description</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="params-tab" data-bs-toggle="tab" data-bs-target="#params-tab-pane" type="button" role="tab" aria-controls="params-tab-pane" aria-selected="false">Parameters</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts-tab-pane" type="button" role="tab" aria-controls="posts-tab-pane" aria-selected="false">Posts</button>
				</li>
			</ul>
			<div class="tab-content" id="itemTabContent">
				<div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel" aria-labelledby="desc-tab" tabindex="0">
					<h4>Description</h4>
					<p>{{ item.description }}</p>
				</div>
				<div class="tab-pane fade" id="params-tab-pane" role="tabpanel" aria-labelledby="params-tab" tabindex="0">
					<h4>Parameters</h4>
					<p>
						<table v-if="item.parameters && item.parameters.length > 0" class="table table-striped">
							<thead class="table-dark">
								<tr>
									<th>Parameter</th>
									<th class="text-end">Value</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="parameter in item.parameters">
									<template v-if="parameter.pivot && parameter.pivot.value">
									<td>{{ parameter.name }}</td>
									<td class="text-end">{{ parameter.pivot.value }} {{ parameter.unit ? parameter.unit.name : ''}}</td>
									</template>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
				<div class="tab-pane fade" id="posts-tab-pane" role="tabpanel" aria-labelledby="posts-tab" tabindex="0">
					<ItemPostList :item="item" :auth="auth" />
				</div>
			</div>
		</div>
	</div>
</template>
