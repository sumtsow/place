<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Layouts/NavBarLayout.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
	title: {
		type: String,
	},
});

const scrollToTop = () => {
	window.scroll(0, 0);
};

</script>

<template>
    <Head :title="title" />
    <div class="container-fluid bg-body">
		<NavBar />
		<main class="mb-5 pb-3">
			<slot />
		</main>
		<Footer @scrollToTop="scrollToTop" />
    </div>
</template>
