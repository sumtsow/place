<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
	comment: {
		type: Object,
	},
	emptyComment: {
		type: Object,
	},
});

const props = usePage().props;
const modal = props.modal;
if(!props.comment) props.comment = JSON.parse( JSON.stringify( props.emptyComment ) );
const form = useForm(props.comment);

const closeForm = () => {
	resetForm();
};

const resetForm = () => {
	props.comment = JSON.parse( JSON.stringify( props.emptyComment ) );
	form.clearErrors();
};

const saveComment = () => {
	form.id = props.comment ? props.comment.id : props.emptyComment.id;
	form.post_id = props.comment ? props.comment.post_id : props.emptyComment.post_id;
	form.user_id = props.comment ? props.comment.user_id : props.emptyComment.user_id;
	form.is_enabled = props.comment ? props.comment.is_enabled : props.emptyCommentis_enabled;
	form.text = props.comment ? props.comment.text : props.emptyComment.text;
	return !!form.id ? form.put( route('comment.update', [form.id])) : form.put( route('comment.store') );
};
</script>

<template>
	<div :class="{ modal: modal }" tabindex="-1" id="commentFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="commentForm" id="comment-form" class="p-3 needs-validation" @submit.prevent.stop="saveComment">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ props.comment && props.comment.id > 0 ? $page.props.lang.admin.edit + props.comment.id : $page.props.lang.admin.add + $page.props.lang.admin.new_male }} {{ $page.props.lang.customer.comment_ }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" @click="closeForm"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div v-if="auth && auth.isAdmin" class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"><InputError :message="form.errors.is_enabled" /></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="props.comment.is_enabled"/>
									<label class="form-check-label" for="is_enabled">{{ $page.props.lang.admin.enabled }}</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="text" :value="$page.props.lang.admin.text" class="col-3 text-end" />
							<TextArea
								id="text"
								class="col"
								v-model="props.comment.text"
								autofocus
								autocomplete="text"
							/>
							<InputError class="mt-2" :message="form.errors.text" />
						</div>
						<div class="row justify-content-end">
							<div class="col text-end pe-4">
							<PrimaryButton :disabled="form.processing">{{ $page.props.lang.customer.save }}</PrimaryButton>
								<p class="text-success" v-if="form.recentlySuccessful">{{ $page.props.lang.customer.saved }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
