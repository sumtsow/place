<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	links: {
        type: Object,
	},
});
</script>

<template>
	<nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">
		<ol class="breadcrumb my-3">
			<li class="breadcrumb-item">
				<Link :href="route('home')">Home</Link>
			</li>
			<li v-for="link in links" class="breadcrumb-item">
				<Link v-if="link.route" :href="route(link.route, link.param)">{{ link.title }}</Link>
				<span v-else>{{ link.title }}</span>
			</li>
		</ol>
	</nav>
</template>
