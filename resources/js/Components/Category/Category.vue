<script setup>
defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="pt-3 sm:pt-5">
		<h2 class="text-xl font-semibold text-black dark:text-white" >
			<a :href="route('category', [category.id])">
			{{ category.name }}
			</a>
		</h2>
		<p v-for="subcategory in category.subcategories" class="mt-4 text-sm/relaxed">
			<a :href="route('category', [subcategory.id])">
			{{ subcategory.name }}
			</a>
		</p>
	</div>
</template>
