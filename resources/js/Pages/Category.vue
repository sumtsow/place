<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Category from '@/Components/Category/Category.vue';

defineProps({
    category: {
        type: Object,
    },
	links: {
		type: Array,
	},
});
</script>

<template>
	<Page title="Category">
		<Breadcrumbs :links="links" />
		<Category :category="category"/>
	</Page>
</template>
