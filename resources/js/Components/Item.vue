<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	item: {
        type: Object,
	},
});
</script>

<template>
	<div class="row">
		<div class="col">
			<h5>{{ item.name }}</h5>
			<p>
				<Link :href="route('item', [item.id])">
					{{ item.description }}
				</Link>
			</p>
		</div>
	</div>
</template>
