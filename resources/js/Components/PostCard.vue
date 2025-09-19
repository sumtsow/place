<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import CommentCard from '@/Components/CommentCard.vue';
import CheckInput from '@/Components/CheckInput.vue';
import { watch, useAttrs } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const auth = useAttrs().auth;
const props = usePage().props;
const modal = props.modal;

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
		default: false,
	},
});

let selectPost = (post) => {
	if (post) props.post = post;
	props.isComment = false;
};

let selectComment = (com) => {
	if (com) props.editedComment = com;
	props.isComment = true;
};
</script>

<template>
	<div class="card h-100 justify-content-centermt-3 p-0 my-3" :class="{'text-body-tertiary': post && !post.is_enabled}">
		<div v-if="post && post.id" class="card-header">
			<template v-if="auth.isAdmin">
				<template v-if="modal">
					<Link data-bs-toggle="modal" data-bs-target="#postFormModal" class="w-100 justify-content-between" :class="{'link-secondary': !post.is_enabled}" @click.stop.prevent="$emit('selectPost')" :href="route('post.update', [post.id])">
					{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
					</Link>
				</template>
				<Link v-else class="d-inline-block" :class="{'link-secondary': !post.is_enabled}" @click.prevent.stop="selectPost(post)" :href="route('post.show', [post.id])">
					{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
				</Link>
				<div class="d-inline-block float-end form-check form-switch">
					<CheckInput :name="'is_enabled'" v-model="post.is_enabled" :label="'Enabled'" :post="post" isComment="false"></CheckInput>
				</div>
			</template>
			<template v-else>
				{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
			</template>
		</div>
		<div class="card-body fs-6">
			<div class="p-3">
				<h5 class="card-title">
					<template v-if="!post || !post.id">There are not posts yet!</template>
				</h5>
				<p class="card-text">
					<template v-if="!post || !post.id">Your post can be first</template>
					<template v-else>{{ post.text }}</template>
				</p>
			</div>
			<template v-if="post && post.id">
			<CommentCard v-for="comm in post.comments" :comment="comm" :post="post" @selectComment="selectComment(comm)"/>
			</template>
		</div>
		<div v-if="post && post.id" class="card-footer text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!auth || !auth.user" @click="$emit('addComment')">Add Comment</PrimaryButton>
		</div>
	</div>
</template>
