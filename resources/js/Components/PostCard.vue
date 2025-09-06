<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import CommentBlock from '@/Components/CommentBlock.vue';
import { watch, useAttrs } from 'vue';
import { usePage } from '@inertiajs/vue3';

const post = useAttrs().post;
const auth = useAttrs().auth;
const props = usePage().props;

watch(
	() => post,
	() => {
		post.comments = post.comments;
});

</script>

<template>
	<div class="card h-100 justify-content-centermt-3 p-0 my-3" :class="{'text-secondary': !post.is_enabled}">
		<div v-if="post.id" class="card-header">
			{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
		</div>
		<div class="card-body fs-6">
			<div class="p-3">
				<h5 class="card-title">
					<template v-if="!post.id">There are not posts yet!</template>
				</h5>
				<p class="card-text">
					<template v-if="post.id">{{ post.text }}</template>
					<template v-else>Your post can be first</template>
				</p>
			</div>
			<CommentBlock v-for="comment in post.comments" :comment="comment" :post="post.id"/>
		</div>
		<div v-if="post.id" class="card-footer text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!auth || !auth.user" @click="$emit('addComment')">Add Comment</PrimaryButton>
		</div>
	</div>
</template>
