<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import PostForm from '@/Components/Forms/PostForm.vue';
import CommentForm from '@/Components/Forms/CommentForm.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { watch } from 'vue';

const props = usePage().props;

defineProps({
	post: {
        type: Object,
	},
	emptyPost: {
		type: Object,
	},
});

if ( !props.post ) {
	props.post = props.emptyPost;
};

if ( !props.comment ) {
	props.comment = props.emptyComment;
};

</script>

<template>
	<Page :title="$page.props.lang.admin.edit + $page.props.lang.customer.post_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.items, route: 'item.admin' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.item.toLowerCase() + post.item_id, route: 'item.edit', param: [post.item_id] }, { title: $page.props.lang.customer.posts, route: 'post.admin', param: [post.item_id] }, { title: $page.props.lang.admin.edit + $page.props.lang.customer.post_, route: false } ]" />
		<div class="justify-content-between ms-3">
			<PostForm :post="post" :emptyPost="emptyPost"/>
		</div>
	</Page>
</template>
