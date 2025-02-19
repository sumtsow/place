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
			{{ category.name }}
		</h2>
		<p v-for="subcategory in category.subcategories" class="mt-4 text-sm/relaxed">
			{{ subcategory.name }}
		</p>
	</div>
</template>
