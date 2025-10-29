<script setup>
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
	<Page :title="$page.props.lang.admin.category">
		<Breadcrumbs :links="links" />
		<Category :category="category"/>
	</Page>
</template>
