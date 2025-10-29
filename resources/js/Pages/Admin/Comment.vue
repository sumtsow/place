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
	modal: {
		type: Number,
	},
	isComment: {
		type: Boolean,
	},
});

if ( !props.comment ) {
	props.comment = {
		id: 0,
		text: '',
		is_enabled: false,
		user_id: null,
		item_id: null,
	}
};

let selectComment = (comment) => {
	if (comment) props.editedPost = comment;
};
</script>

<template>
	<Page :title="$page.props.lang.admin.edit + $page.props.lang.customer.comment.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.customer.posts + ' ' + $page.props.lang.admin.of_item + editedPost.post.item_id, route: 'post.admin', param: [editedPost.post.item_id] }, { title: $page.props.lang.admin.edit + $page.props.lang.customer.comment.toLowerCase(), route: false } ]" />
		<div class="justify-content-between ms-3">
			<PostForm :item="editedPost.post.item_id" :auth="props.auth" :editedPost="editedPost" :isComment="isComment"/>
		</div>
	</Page>
</template>
