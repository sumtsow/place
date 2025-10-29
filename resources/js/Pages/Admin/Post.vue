<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = usePage().props;

defineProps({
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
	<Page :title="$page.props.lang.admin.edit + $page.props.lang.customer.post_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.items, route: 'item.admin' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.item.toLowerCase() + editedPost.item_id, route: 'item.edit', param: [editedPost.item_id] }, { title: $page.props.lang.customer.posts, route: 'post.admin', param: [editedPost.item_id] }, { title: $page.props.lang.admin.edit + $page.props.lang.customer.post_, route: false } ]" />
		<div class="justify-content-between ms-3">
			<PostForm :item="editedPost.item_id" :auth="props.auth" :editedPost="editedPost" :isComment="isComment" :emptyComment="emptyComment" :emptyPost="emptyPost"/>
		</div>
	</Page>
</template>
