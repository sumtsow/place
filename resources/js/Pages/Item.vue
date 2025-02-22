<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Item from '@/Components/Item.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    category: {
        type: Object,
    },
	item: {
        type: Object,
	},
	links: {
		type: Array,
	},
});
</script>

<template>
	<Page :auth="{ canLogin: canLogin, canRegister: canRegister }" title="Item">
		<Breadcrumbs :links="links" />
		<Item :item="item"/>
	</Page>
</template>
