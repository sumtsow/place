<script setup>
defineProps({
	label: {
        type: Array,
	},
});
</script>

<template>
	<ul class="nav nav-tabs mt-3">
		<li class="nav-item">
		<span class="nav-link active fs-5 fw-bold" aria-current="page">{{ label }}</span>
		</li>
	</ul>
</template>
