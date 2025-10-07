<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Layouts/NavBarLayout.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
	title: {
		type: String,
	},
});
</script>

<template>
    <Head :title="title" />
    <div class="container-fluid bg-body">
		<NavBar />
		<main>
			<slot />
		</main>
		<Footer />
    </div>
</template>
