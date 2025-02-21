<script setup>
defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="row my-3 py-3 bg-light border border-primary-subtle rounded-4">
		<div class="col">
			<h2 class="h4" >
				<a :href="route('category', [category.id])">
				{{ category.name }}
				</a>
			</h2>
			<p v-for="subcategory in category.subcategories" class="ms-3 mt-3">
				<a :href="route('category', [subcategory.id])">
				{{ subcategory.name }}
				</a>
			</p>
		</div>
	</div>
</template>
