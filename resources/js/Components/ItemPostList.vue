<script setup>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import PostCard from '@/Components/PostCard.vue';
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const post_id = ref(0);
const isComment = ref(false);
const props = usePage().props;

defineProps({
	item: {
		type: Object,
	},
	auth: {
		type: Object,
	},
});

let addComment = (pid) => {
	post_id.value = pid;
	isComment.value = true;
};

let addPost = () => {
	post_id.value = 0;
	isComment.value = false;
};

</script>

<template>
	<div class="row row-cols-1 mx-0">
		<template v-if="item.posts && item.posts.length">
			<PostCard v-for="post in item.posts" :post="post" :auth="auth" @addComment="addComment(post.id)" />
		</template>
		<template v-else>
			<PostCard :post="{id: 0, text: ''}" :auth="false"/>
		</template>
	</div>
	<div class="row my-3">
		<div class="col text-end">
			<PrimaryButton data-bs-toggle="modal" data-bs-target="#postFormModal" :disabled="!auth || !auth.user" @click="addPost">Add new Post</PrimaryButton>
		</div>
		<PostForm :item="item" :post="post_id" :comment="0" :isComment="isComment"/>
	</div>
</template>
