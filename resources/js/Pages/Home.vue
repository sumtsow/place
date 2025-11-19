<script setup>
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
        type: Array,
        required: true,
    },
	items: {
		type: Object,
		required: true,
	},
	imageSize: {
		type: Number,
	},
});
</script>

<template>
	<Page :title="$page.props.lang.navbar.home">
		<CategoriesList :categories="categories" :items="items" :imageSize="imageSize"/>
	</Page>
</template>
