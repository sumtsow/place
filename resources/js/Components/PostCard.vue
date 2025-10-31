<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import CommentCard from '@/Components/CommentCard.vue';
import CheckInput from '@/Components/CheckInput.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';

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
});

const toggleState = (post) => {
	if (!post) return;
	useForm({
		id: post.id,
		is_enabled: !!post.is_enabled,
	}).put( route('post.update', [post.id]) );
};
</script>

<template>
	<div class="card h-100 justify-content-centermt-3 p-0 my-3" :class="{'text-body-tertiary': post && !post.is_enabled}">
		<div v-if="post && post.id" class="card-header">
			<template v-if="props.auth.isAdmin">
				<template v-if="modal">
					<Link data-bs-toggle="modal" data-bs-target="#postFormModal" class="w-100 justify-content-between" :class="{'link-secondary': !post.is_enabled}" @click.stop.prevent="$emit('selectPost', post)" :href="route('post.update', [post.id])">
					{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
					</Link>
				</template>
				<Link v-else class="d-inline-block" :class="{'link-secondary': !post.is_enabled}" @click.prevent.stop="selectPost(post)" :href="route('post.show', [post.id])">
					{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
				</Link>
				<div class="d-inline-block float-end form-check form-switch">
					<CheckInput :name="'is_enabled'" v-model="post.is_enabled" :label="$page.props.lang.admin.enabled" :post="post" isComment="false" @toggleState="toggleState(post)"></CheckInput>
				</div>
			</template>
			<template v-else>
				{{ post.user.firstname }} {{ post.user.lastname }} | {{ new Date(post.created_at).toLocaleString() }}
			</template>
		</div>
		<div class="card-body fs-6">
			<div class="p-3">
				<h5 class="card-title">
					<template v-if="!post || !post.id">{{ $page.props.lang.customer.not_posts_yet }}</template>
				</h5>
				<p class="card-text">
					<template v-if="!post || !post.id">{{ $page.props.lang.customer.can_be_first }}</template>
					<template v-else>{{ post.text }}</template>
				</p>
			</div>
			<template v-if="post && post.id">
			<CommentCard v-for="comm in post.comments" :comment="comm" @selectComment="$emit('selectComment', comm)"/>
			</template>
		</div>
		<div v-if="post && post.id" class="card-footer text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#commentFormModal" :disabled="!props.auth || !props.auth.user" @click="$emit('addComment', post.id)">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.customer.comment_ }}</PrimaryButton>
		</div>
	</div>
</template>
