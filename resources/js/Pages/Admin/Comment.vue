<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CommentForm from '@/Components/Forms/CommentForm.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = usePage().props;

defineProps({
	comment: {
        type: Object,
	},
	emptyComment: {
		type: Object,
	},
	item: {
		type: Number,
	},
});

if ( !props.comment ) {
	props.comment = JSON.parse( JSON.stringify( props.emptyComment ) );
};

const selectComment = (comment) => {
	if (comment) props.comment = comment;
};
</script>

<template>
	<Page :title="$page.props.lang.admin.edit + $page.props.lang.customer.comment.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.customer.posts + ' ' + $page.props.lang.admin.of_item + editedPost.post.item_id, route: 'post.admin', param: [editedPost.post.item_id] }, { title: $page.props.lang.admin.edit + $page.props.lang.customer.comment.toLowerCase(), route: false } ]" />
		<div class="justify-content-between ms-3">
			<CommentForm :emptyComment="emptyComment" :comment="comment"/>
		</div>
	</Page>
</template>
