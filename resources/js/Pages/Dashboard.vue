<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
		default: 'Dashboard',
    },
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: title, route: false } ]" />
		<h2>Possible opreations</h2>
		<div class="list-group">
			<Link class="list-group-item" :href="route('category.admin')">Manage Categories</Link>
			<Link class="list-group-item" :href="route('distributor.admin')">Manage Distributors</Link>
			<Link class="list-group-item" :href="route('item.admin')">Manage Items</Link>
			<Link class="list-group-item" :href="route('parameter.admin')">Manage Parameters</Link>
			<Link class="list-group-item" :href="route('unit.admin')">Manage Measuring Units</Link>
		</div>
	</Page>
</template>
