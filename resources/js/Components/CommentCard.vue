<script setup>

import CheckInput from '@/Components/CheckInput.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	comment: {
		type: Object,
	},
	post: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
	isComment: {
		type: Boolean,
		default: true,
	},
});

const toggleState = (comment) => {
	if (!comment) return;
	useForm({
		id: comment.id,
		is_enabled: !!comment.is_enabled,
	}).put( route('comment.update', [comment.id]) );
};
</script>

<template>
	<div class="card m-3 p-0" :class="{'ms-0': pid == comment.user_id, 'me-0 bg-light': pid != comment.user_id, 'text-secondary': !comment.is_enabled}">
		<div class="card-header">
			<template v-if="props.auth.isAdmin">
				<template v-if="props.modal">
					<Link data-bs-toggle="modal" data-bs-target="#postFormModal" class="w-100 justify-content-between" :class="{'link-secondary': !comment.is_enabled}" @click.prevent.stop="$emit('selectComment', comment)" :href="route('comment.update', [comment.id])">
					{{ comment.user.firstname }} {{ comment.user.lastname }} | {{ new Date(comment.created_at).toLocaleString() }}
					</Link>
				</template>
				<Link v-else @click.prevent.stop="$emit('selectComment', comment)" :href="route('comment.show', [comment.id])" :class="{'link-secondary': !comment.is_enabled}">
					{{ comment.user.firstname }} {{ comment.user.lastname }} | {{ new Date(comment.created_at).toLocaleString() }}
				</Link>
				<div class="d-inline-block float-end form-check form-switch">
					<CheckInput :name="'is_enabled'" v-model="comment.is_enabled" :label="'Enabled'" :post="comment" :isComment="true" @toggleState="toggleState(comment)"></CheckInput>
				</div>	
			</template>
			<template v-else>
				{{ comment.user.firstname }} {{ comment.user.lastname }} | {{ new Date(comment.created_at).toLocaleString() }}
			</template>
		</div>
		<div class="card-body fs-6">
			<p class="card-text m-3">{{ comment.text }}</p>
		</div>
	</div>
</template>
