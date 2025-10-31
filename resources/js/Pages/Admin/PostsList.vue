<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CommentForm from '@/Components/Forms/CommentForm.vue';
import Post from '@/Pages/Admin/Post.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import PostCard from '@/Components/PostCard.vue';
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const isComment = ref(false);

defineProps({
	posts: {
        type: Array,
    },
	comment: {
		type: Object,
	},
	post: {
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

const addComment = (postId) => {
	props.comment.post_id = postId;
};

const selectPost = (post) => {
	if (post) props.post = post;
};

const selectComment = (comment) => {
	if (comment) props.comment = comment;
};
</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.customer.posts.toLowerCase() + $page.props.lang.admin.of_item">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.items, route: 'item.admin' }, { title: $page.props.lang.admin.manage + $page.props.lang.customer.posts.toLowerCase() + $page.props.lang.admin.of_item, route: false } ]" />
		<h2>{{ $page.props.lang.customer.posts }}</h2>
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
		<PostForm v-if="modal"/>
		<CommentForm v-if="modal"/>
	</Page>
</template>
