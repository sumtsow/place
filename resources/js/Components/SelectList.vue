<script setup>
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const model = defineModel({
    type: String,
    required: false,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineProps({
	options: {
        type: Object,
	},
	children: {
        type: String,
		default: '',
	},
	defaultOption: {
        type: String,
		default: '',
	},
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="form-control"
        v-model="model"
        ref="input"
    >
	<option v-if="defaultOption" value="0">{{ defaultOption }}</option>
	<template v-for="option in options">
		<option :value="option.id">{{ '&nbsp;&nbsp;'.repeat(option.level) + option.name }} {{ children && option[children] ? '(' + option[children] + ')' : '' }}</option>
	</template>
	</select>
</template>
