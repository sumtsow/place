<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	value: {
        type: Object,
	},
	modal: {
		type: Number,
	},
});
</script>

<template v-if="!modal">
	item: {{ $item }}<br/>
	parameter_id: {{ $parameter_id}}
	<ParameterValueForm :value="value"/>
</template>
