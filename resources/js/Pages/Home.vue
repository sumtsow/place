<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Page from '@/Layouts/PageLayout.vue';
import CategoriesList from '@/Components/Category/CategoriesList.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    categories: {
        type: Object,
        required: true,
    },
});
</script>

<template>
	<Page :auth="{ canLogin: canLogin, canRegister: canRegister }" title="Home">
		<CategoriesList :categories="categories"/>
	</Page>
</template>
