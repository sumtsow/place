<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
	post: {
		type: Object,
	},
	emptyPost: {
		type: Object,
	},
});

const props = usePage().props;
const modal = props.modal;

if(!props.post) props.post = JSON.parse( JSON.stringify( props.emptyPost ) );

const form = useForm(props.post);

const closeForm = () => {
	resetForm();
};

const resetForm = () => {
	props.post = JSON.parse( JSON.stringify( props.emptyPost ) );
	form.clearErrors();
};

const savePost = () => {
	form.id = props.post ? props.post.id : props.emptyPost.id;
	form.item_id = props.post ? props.post.item_id : props.emptyPost.item_id;
	form.user_id = props.post ? props.post.user_id : props.emptyPost.user_id;
	form.is_enabled = props.post ? props.post.is_enabled : props.emptyPost.is_enabled;
	form.text = props.post ? props.post.text : props.emptyPost.text;
	return !!form.id ? form.put( route('post.update', [form.id])) : form.put( route('post.store') );
};
</script>

<template>
	<div :class="{ modal: modal }" tabindex="-1" id="postFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="postForm" id="post-form" class="p-3 needs-validation" @submit.prevent.stop="savePost">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ props.post && props.post.id > 0 ? $page.props.lang.admin.edit + props.post.id : $page.props.lang.admin.add + $page.props.lang.admin.new_male }} {{ $page.props.lang.customer.post_ }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" @click="closeForm"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div v-if="props.auth && props.auth.isAdmin" class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"><InputError :message="form.errors.is_enabled" /></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="props.post.is_enabled"/>
									<label class="form-check-label" for="is_enabled">{{ $page.props.lang.admin.enabled }}</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="text" :value="$page.props.lang.admin.text" class="col-3 text-end" />
							<TextArea
								id="text"
								class="col"
								v-model="props.post.text"
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
