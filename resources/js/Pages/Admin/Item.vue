<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	item: {
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
let selectItem = (item) => {
	if (item) {
		props.item = item;
		props.item.is_enabled = !!props.item.is_enabled;
	}
	return true;
};
</script>

<template>
	<div class="justify-content-between ms-3">
		<template v-if="modal">
			<Link data-bs-toggle="modal" data-bs-target="#itemFormModal" class="w-100 justify-content-between" @click.prevent.stop="selectItem(item)" :href="route('item', [item.id])">
			{{ item.name }}
			</Link>
		</template>
		<Link v-else @click.prevent.stop="selectItem(item)" :href="route('item.edit', [item.id])">
			{{ item.name }}
		</Link>
	</div>
</template>
