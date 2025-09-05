<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { ref, watch, useAttrs } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const props = page.props;
const attrs = useAttrs();
const comments = ref([]);

const form = useForm({
	id: 0,
	text: '',
	item_id: attrs.item ? attrs.item.id : 0,
	post_id: attrs.post ? attrs.post: 0,
	comment_id: attrs.comment ? attrs.comment: 0,
});

watch(
	() => attrs.post,
	() => {
		form.id = attrs.isComment ? attrs.comment : attrs.post;
		form.item_id = attrs.item ? attrs.item.id : 0;
		form.post_id = attrs.post ? attrs.post : 0;
});

let updatePost = () =>  {
	let editedPost = findModelById( attrs.item.posts, attrs.post );
	comments.value = editedPost && editedPost.comments ? editedPost.comments : [];
	findModelById( props.item.posts, attrs.post ).comments = comments;
};

let savePost = () => {
	if (form.post_id) {
		!!form.id ? form.put( route('comment.update', [form.id])) : form.put( route('comment.store'), { onSuccess: updatePost } );
	} else {
		!!form.id ? form.put( route('post.update', [form.id])) : form.put( route('post.store') );
	};
};
</script>

<template>
	<div class="modal" tabindex="-1" id="postFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="postForm" id="post-form" class="p-3 needs-validation" @submit.prevent.stop="savePost">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<div class="modal-title h5" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add new ' }} {{ attrs.post ? 'comment' : 'post' }}</div>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="form.clearErrors"></button>
					</div>
					<div class="modal-body">
						<div v-if="auth && auth.user" class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
									<label class="form-check-label" for="visible">Enabled</label>
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
							<p v-if="form.recentlySuccessful" class="">
								Saved.
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
