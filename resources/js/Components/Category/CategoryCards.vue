<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	categories: {
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
			<div v-for="category in categories" class="col-auto">
				<Link class="card h-100 m-1 pt-3 text-decoration-none" style="min-width: 180px; max-width: 267px;" :href="route('category', [category.id])">
					<div v-if="category.logo" v-html="category.logo" class="card-img-top mx-auto" style="width: 90px;"></div>
					<div class="card-body">
						<h5 class="card-title">{{ category.name }}</h5>
					</div>
					<div class="card-footer text-end" :class="{ 'text-info': category.subcategories && category.subcategories.length, 'text-primary': category.items && category.items.length }">
						{{ category.subcategories && category.subcategories.length ? $page.props.lang.admin.categories + ': ' + category.subcategories.length : category.items && category.items.length ? $page.props.lang.admin.items + ': ' + category.items.length : '&nbsp;' }}
					</div>
				</Link>
			</div>
		</div>
	</div>
</template>
