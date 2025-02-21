<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="row my-3 py-3 bg-light border border-primary-subtle rounded-4">
		<div class="col">
			<h2 class="h4" >
				<Link :href="route('category', [category.id])">
				{{ category.name }}
				</Link>
			</h2>
			<template v-if="category.subcategories.length">
				<p v-for="subcategory in category.subcategories" class="ms-3 mt-3">
					<Link :href="route('category', [subcategory.id])">
					{{ subcategory.name }}
					</Link>
				</p>
			</template>
			<template v-else>
				<p v-for="item in category.items" class="ms-3 mt-3">
					<Link :href="route('item', [item.id])">
					{{ item.name }}
					</Link>
				</p>
			</template>
		</div>
	</div>
</template>
