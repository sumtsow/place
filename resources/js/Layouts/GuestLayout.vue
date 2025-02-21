<script setup>
import { Link } from '@inertiajs/vue3';
import NavBar from '@/Layouts/NavBarLayout.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <div class="container bg-body m-3">
		<NavBar :auth="{ canLogin: false, canRegister: true }"/>
        <slot />
		<Footer />
    </div>
</template>
