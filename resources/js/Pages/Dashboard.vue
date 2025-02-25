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
		<div class="list-group">
			<Link class="list-group-item" :href="route('categoryAdmin')">Manage Categories</Link>
		</div>
	</Page>
</template>
