<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Category from '@/Components/Category/Category.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    category: {
        type: Object,
    },
	links: {
		type: Array,
	},
});
</script>

<template>
	<Page :auth="{ canLogin: canLogin, canRegister: canRegister }" title="Category">
		<Breadcrumbs :links="links" />
		<div class="grid gap-6 lg:gap-8">
			<div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]" >
				<Category :category="category"/>
			</div>
		</div>
	</Page>
</template>
