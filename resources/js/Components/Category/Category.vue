<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="row m-0 py-3 bg-light border border-primary-subtle rounded-4">
		<div class="col">
			<h2 class="h4" >
				<Link :href="route('category', [category.id])">
				{{ category.name }}
				</Link>
			</h2>
		</div>
	</div>
	<template v-if="category.subcategories.length">
		<div class="row">
			<div class="col">
				<p v-for="subcategory in category.subcategories" class="ms-3 mt-3">
					<Link :href="route('category', [subcategory.id])">
					{{ subcategory.name }}
					</Link>
				</p>
			</div>
		</div>
	</template>
	<template v-else>
		<div class="row row-cols-1 row-cols-md-3 g-3 my-3">
			<div v-for="item in category.items" class="col">
				<div class="card h-100">
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
</template>
