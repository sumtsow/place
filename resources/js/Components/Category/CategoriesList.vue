<script setup>
import Category from '@/Components/Category/Category.vue';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    categories: {
        type: Object,
        required: true,
    },
});
</script>

<template>
	<template v-for="category in categories">
		<Category :category="category"/>
	</template>
</template>
