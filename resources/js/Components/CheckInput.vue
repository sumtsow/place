<script setup>

import InputLabel from '@/Components/InputLabel.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const model = defineModel({
    type: Number, Boolean,
    required: true,
});

const props = usePage().props;
const input = ref(null);

defineProps({
	name: {
        type: String,
	},
	label: {
        type: String,
	},
	post: {
        type: Object,
	},
	isComment: {
        type: Boolean,
	},
});
</script>

<template>
	<input type="checkbox" class="form-check-input" v-model="model" :name="name" :id="name" @change="$emit('toggleState')"/>
	<InputLabel class="form-check-label" :value="label" :for="name"/>
</template>
