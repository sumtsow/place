<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Post from '@/Pages/Admin/Post.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import PostCard from '@/Components/PostCard.vue';
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const isComment = ref(false);

defineProps({
    title: {
        type: String,
		default: 'Manage item posts',
    },
	posts: {
        type: Array,
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
	modal: {
		type: Boolean,
	},
});

let addComment = (postId) => {
	props.editedComment = props.emptyComment;
	props.editedComment.post_id = postId;
	isComment.value = true;
};

let selectPost = (post) => {
	if (post) props.editedPost = post;
};

</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Items', route: 'item.admin' }, { title: title, route: false } ]" />
		<h2>Posts</h2>
		<div v-if="posts.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in posts.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<template v-if="posts && posts.length">
			<PostCard v-for="post in posts" :post="post" :auth="props.auth" @selectPost="selectPost(post)" @addComment="addComment(post.id)"/>
		</template>
		<div v-if="posts.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in posts.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<PostForm v-if="modal" :modal="modal" :auth="props.auth" :emptyPost="emptyPost" :emptyComment="emptyComment" :isComment="isComment" :post="editedPost" :comment="editedComment"/>
	</Page>
</template>
