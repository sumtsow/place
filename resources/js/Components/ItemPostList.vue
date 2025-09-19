<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import PostCard from '@/Components/PostCard.vue';
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const currentPost = props.emptyPost;
currentPost.item_id = props.item.id;
const isComment = ref(false);

defineProps({
	item: {
		type: Object,
	},
	auth: {
		type: Object,
	},
	editedComment: {
		type: Object,
	},
	editedPost: {
		type: Object,
	},
	emptyPost: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
});

let addComment = (postId) => {
	props.editedComment = props.emptyComment;
	props.editedComment.id = 0;
	props.editedComment.post_id = postId;
	isComment.value = true;
};

let addPost = () => {
	props.editedPost = props.emptyPost;
	props.editedPost.id = 0;
	props.editedPost.post_id = 0;
	props.editedPost.item_id = props.item.id;
	isComment.value = false;
};

</script>

<template>
	<div class="row row-cols-1 mx-0">
		<template v-if="item.posts && item.posts.length">
			<PostCard v-for="post in item.posts" :post="post" :auth="auth" @addComment="addComment(post.id)" />
		</template>
		<template v-else>
			<PostCard :post="editedPost" :auth="false"/>
		</template>
	</div>
	<div class="row my-3">
		<div class="col text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!auth || !auth.user" @click="addPost">Add new Post</PrimaryButton>
		</div>
		<PostForm :modal="true" :item="item" :editedPost="editedPost" :comment="0" :isComment="isComment"/>
	</div>
</template>
