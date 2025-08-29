<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	unit: {
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

let selectUnit = (unit) => {
	if (unit) {
		props.unit = unit;
		props.unit.is_enabled = !!props.unit.is_enabled;
	}
	return true;
};
</script>

<template>
	<div class="justify-content-between ms-3">
		<template v-if="modal">
			<Link data-bs-toggle="modal" data-bs-target="#unitFormModal" class="w-100 justify-content-between" @click.prevent.stop="selectUnit(unit)" :href="route('unit', [unit.id])">
			{{ unit.name }}
			</Link>
		</template>
		<Link v-else @click.prevent.stop="selectUnit(unit)" :href="route('unit.edit', [unit.id])">
			{{ unit.name }}
		</Link>
	</div>
</template>
