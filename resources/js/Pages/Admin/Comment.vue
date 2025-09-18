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
		default: 'Comment edit',
    },
	comment: {
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
	if (comment) {
		props.comment = comment;
		props.comment.is_enabled = !!props.comment.is_enabled;
	}
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Posts', route: 'post.admin', param: [comment.post.item_id] }, { title: title, route: false } ]" />
		<div class="justify-content-between ms-3">
			<PostForm :item="comment.post.item_id" :auth="auth" :post="comment" :isComment="isComment"/>
		</div>
	</Page>
</template>
