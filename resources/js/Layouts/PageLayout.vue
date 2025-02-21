<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Layouts/NavBarLayout.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
	title: {
		type: String,
	},
	auth: {
		type: Object,
	},
});
</script>

<template>
    <Head :title="title" />
    <div class="container bg-body m-3">
		<NavBar :auth="auth" />
		<main>
			<slot />
		</main>
		<Footer />
    </div>
</template>