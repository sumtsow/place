<script setup>
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
	emptyParameter: {
		type: String,
	},
	emptyPost: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
	emptyParamGroup: {
		type: Object,
	},
});
</script>

<template>
	<Page :title="$page.props.lang.admin.item">
		<Breadcrumbs :links="links" />
		<Item :item="item" :emptyParameter="emptyParameter" :emptyPost="emptyPost" :emptyComment="emptyComment" :emptyParamGroup="emptyParamGroup"/>
	</Page>
</template>
