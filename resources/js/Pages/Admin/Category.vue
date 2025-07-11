<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

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
let selectCat = (cat) => {
	if (cat) {
		props.category = cat;
		props.category.is_enabled = !!props.category.is_enabled;
	}
	return true;
};
</script>

<template>
	<div class="justify-content-between ms-3">
		<template v-if="modal">
			<Link data-bs-toggle="modal" data-bs-target="#categoryFormModal" class="w-100 justify-content-between" @click.prevent.stop="selectCat(category)" :href="route('category', [category.id])">
			{{ category.name }}
			</Link>
		</template>
		<Link v-else @click.prevent.stop="selectCat(category)" :href="route('category.edit', [category.id])">
			{{ category.name }}
		</Link>
		<template v-if="category.subcategories.length">
			<div class="badge text-bg-primary float-end me-3">
				{{ category.subcategories.length }}
			</div>
			<div>
				<template v-for="subcategory in category.subcategories">
					<Category :category="subcategory" :modal="modal" />
				</template>
			</div>
		</template>
	</div>
</template>
