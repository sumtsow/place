<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import PostCard from '@/Components/PostCard.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import CommentForm from '@/Components/Forms/CommentForm.vue';
import { usePage } from '@inertiajs/vue3';

defineProps({
	comment: {
		type: Object,
	},
	post: {
		type: Object,
	},
	item: {
		type: Object,
	},
});

const props = usePage().props;

const addComment = (postId) => {
	props.comment.post_id = postId;
};

const selectComment = (comment) => {
	if (comment) props.comment = comment;
};

const selectPost = (post) => {
	if (post) props.post = post;
};
</script>

<template>
	<PostForm :post="post"/>
	<CommentForm :comment="props.comment"/>
	<div class="row row-cols-1 mx-0">
		<template v-if="item.posts && item.posts.length">
			<PostCard v-for="post in item.posts" :post="post" @addComment="addComment(post.id)" @selectComment="selectComment" @selectPost="selectPost(post)" />
		</template>
		<template v-else>
			<PostCard :post="post"/>
		</template>
	</div>
	<div class="row my-3">
		<div class="col text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!props.auth || !props.auth.user">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.customer.post_ }}</PrimaryButton>
		</div>
	</div>
</template>
