<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
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
		You're logged in!
	</Page>
</template>
