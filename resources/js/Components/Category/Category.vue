<script setup>
import CategoryCards from '@/Components/Category/CategoryCards.vue';
import ItemCards from '@/Components/Category/ItemCards.vue';
import TabLabel from '@/Components/TabLabel.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="container-fluid">
		<TabLabel :label="category.name" />
		<CategoryCards v-if="category.subcategories.length" :categories="category.subcategories" wrapCols="true"/>
		<ItemCards v-else :items="category.items" wrapCols="true"/>
	</div>
</template>
