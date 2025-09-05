<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Item from '@/Components/Item.vue';

defineProps({
	item: {
        type: Object,
	},
	links: {
		type: Array,
	},
	auth: {
		type: Object,
	},
});
</script>

<template>
	<Page title="Item">
		<Breadcrumbs :links="links" />
		<Item :item="item" :auth="auth"/>
	</Page>
</template>
