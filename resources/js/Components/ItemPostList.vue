<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import PostCard from '@/Components/PostCard.vue';
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const currentPost = ref( { id: 0, text: '' } );
const isComment = ref(false);
const props = usePage().props;

defineProps({
	item: {
		type: Object,
	},
	auth: {
		type: Object,
	},
	emptyPost: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
});

let addComment = () => {
	currentPost.value = props.emptyPost;
	isComment.value = true;
};

let addPost = () => {
	currentPost.value = props.emptyComment;
	isComment.value = false;
};

</script>

<template>
	<div class="row row-cols-1 mx-0">
		<template v-if="item.posts && item.posts.length">
			<PostCard v-for="post in item.posts" :post="post" :auth="auth" @addComment="addComment(post)" />
		</template>
		<template v-else>
			<PostCard :post="currentPost" :auth="false"/>
		</template>
	</div>
	<div class="row my-3">
		<div class="col text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!auth || !auth.user" @click="addPost">Add new Post</PrimaryButton>
		</div>
		<PostForm modal="true" :item="item" :post="currentPost" :comment="0" :isComment="isComment"/>
	</div>
</template>
