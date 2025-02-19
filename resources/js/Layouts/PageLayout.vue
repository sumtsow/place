<script setup>
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Layouts/NavBarLayout.vue';

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
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="/storage/background.svg" />
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
				<NavBar :auth="auth" />
				<main class="mt-6">
					<slot />
				</main>
                <footer class="py-16 text-center text-sm text-black dark:text-white/70" >
                    &copy; {{ new Date().getFullYear() }} All rights reserved
                </footer>
            </div>
        </div>
    </div>
</template>