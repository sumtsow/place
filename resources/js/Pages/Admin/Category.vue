<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	category: {
        type: Object,
	},
	modal: {
		type: Number,
	},
	show: {
		type: Boolean,
		default: false,
	},
});
let editCategory = (id) => {
	return parent.show != parent.show;
};
</script>

<template>
	<div class="justify-content-between ms-3">
		<Link v-if="modal" @click="editCategory" :data-id="category.id" href="#">
			{{ category.name }}
		</Link>
		<Link v-else :href="route('category.edit', [category.id])">
			{{ category.name }}
		</Link>
		<template v-if="category.subcategories.length">
			<div class="badge text-bg-primary float-end me-3">
				{{ category.subcategories.length }}
			</div>
			<div>
				<template v-for="subcategory in category.subcategories">
					<Category :category="subcategory" />
				</template>
			</div>
		</template>
	</div>
</template>
