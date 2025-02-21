<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	item: {
        type: Object,
	},
});
</script>

<template>
	<div class="row my-3 py-3 bg-light border border-primary-subtle rounded-4">
		<div class="col">
			<h2 class="h4" >
				<Link :href="route('item', [item.id])">
				{{ item.name }}
				</Link>
			</h2>
		</div>
	</div>
</template>
