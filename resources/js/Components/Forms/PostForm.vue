<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { ref, watch, useAttrs } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const auth = useAttrs().auth;

const comments = ref([]);

defineProps({
	auth: {
		type: Object,
	},
	editedPost: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
	emptyPost: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
	isComment: {
		type: Boolean,
	},
});

let formTpl = props.modal ? props.emptyPost : props.editedPost;

const form = useForm(formTpl);

watch(
	() => props.editedPost,
	() => {
		props.isComment = false;
		form.id = props.editedPost ? props.editedPost.id : 0;
		form.item_id = props.editedPost ? props.editedPost.item_id : 0;
		form.post_id = 0;
		form.user_id = props.editedPost ? props.editedPost.user_id : 0;
		form.comment_id = props.editedPost ? props.editedPost.id : 0;
		form.is_enabled = props.editedPost ? props.editedPost.is_enabled : false;
		form.text = props.editedPost ? props.editedPost.text : '';
});

watch(
	() => props.editedComment,
	() => {
		props.isComment = true;
		form.id = props.editedComment ? props.editedComment.id : 0;
		form.item_id = 0;
		form.post_id = props.editedComment ? props.editedComment.post_id : 0;
		form.user_id = props.editedComment ? props.editedComment.user_id : 0;
		form.comment_id = props.editedComment ? props.editedComment.id : 0;
		form.is_enabled = props.editedComment ? props.editedComment.is_enabled : false;
		form.text = props.editedComment ? props.editedComment.text : '';
});

let savePost = () => {
	if (props.isComment) {
		return !!form.id ? form.put( route('comment.update', [form.id])) : form.put( route('comment.store') );
	} else {
		return !!form.id ? form.put( route('post.update', [form.id])) : form.put( route('post.store') );
	};
};
</script>

<template>
	<div :class="{ modal: modal }" tabindex="-1" id="postFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="postForm" id="post-form" class="p-3 needs-validation" @submit.prevent.stop="savePost">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add new ' }} {{ isComment ? 'comment' : 'post' }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="form.clearErrors"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div v-if="auth && auth.user" class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"><InputError :message="form.errors.is_enabled" /></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
									<label class="form-check-label" for="is_enabled">Enabled</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="text" value="Text" class="col-3 text-end" />
							<TextArea
								id="text"
								class="col"
								v-model="form.text"
								autofocus
								autocomplete="text"
							/>
							<InputError class="mt-2" :message="form.errors.text" />
						</div>
					</div>
					<div class="row justify-content-end">
						<div class="col-2 m-4">
						<PrimaryButton :disabled="form.processing">Save</PrimaryButton>
							<p v-if="form.recentlySuccessful">Saved.</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
