<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { watch, useAttrs } from 'vue';

const auth = useAttrs().auth;
const props = usePage().props;

defineProps({
    title: {
        type: String,
		default: 'Post edit',
    },
	editedPost: {
        type: Object,
	},
	editedComment: {
        type: Object,
	},
	emptyComment: {
		type: Object,
	},
	emptyPost: {
		type: Object,
	},
	modal: {
		type: Number,
	},
	isComment: {
		type: Boolean,
	},
});

if ( !props.editedPost ) {
	props.editedPost = props.emptyPost;
};

if ( !props.editedComment ) {
	props.editedComment = props.emptyComment;
};

</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Posts', route: 'post.admin', param: [editedPost.item_id] }, { title: title, route: false } ]" />
		<div class="justify-content-between ms-3">
			<PostForm :item="editedPost.item_id" :auth="auth" :editedPost="editedPost" :isComment="isComment" :emptyComment="emptyComment" :emptyPost="emptyPost"/>
		</div>
	</Page>
</template>
