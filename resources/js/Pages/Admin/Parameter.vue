<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	parameter: {
        type: Object,
	},
	modal: {
		type: Number,
	},
	show: {
		type: Boolean,
		default: false,
	},
});

let selectParameter = (parameter) => {
	if (parameter) {
		props.parameter = parameter;
		props.parameter.is_enabled = !!props.parameter.is_enabled;
	}
	return true;
};
</script>

<template>
	<div class="justify-content-between ms-3">
		<template v-if="modal">
			<Link data-bs-toggle="modal" data-bs-target="#parameterFormModal" class="w-100 justify-content-between" @click.prevent.stop="selectParameter(parameter)" :href="route('parameter', [parameter.id])">
			{{ parameter.name }}
			</Link>
		</template>
		<Link v-else @click.prevent.stop="selectParameter(parameter)" :href="route('parameter.edit', [parameter.id])">
			{{ parameter.name }}
		</Link>
	</div>
</template>
