<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

const form = useForm(props.distributor);

defineProps({
	distributor: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
});

watch(
	() => props.distributor,
	() => {
		form.id = props.distributor ? props.distributor.id : 0;
		form.name = props.distributor ? props.distributor.name : '';
		form.is_enabled = props.distributor ? props.distributor.is_enabled : false;
		form.url = props.distributor ? props.distributor.url : 0;
		form.email = props.distributor ? props.distributor.email : 0;
		form.phone = props.distributor ? props.distributor.phone : 0;
		form.like = props.distributor ? +props.distributor.like : 0;
		form.dislike = props.distributor ? +props.distributor.dislike : 0;
		form.sales = props.distributor ? +props.distributor.sales : 0;
		form.token = props.csrf_token;
		form.clearErrors();
});

let saveDistributor = () => {
	if (!form.name) return false;
	return !!form.id ? form.put( route('distributor.update', [form.id])) : form.put(route('distributor.store'));
};
</script>

<template>
	<div v-if="distributor" :class="{ modal: modal }" tabindex="-1" id="distributorFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="distributorForm" id="distributor-form" class="p-3 needs-validation" @submit.prevent.stop="saveDistributor">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add' }} distributor</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="form.reset"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled" value="1"/>
									<label class="form-check-label" for="visible">Enabled</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="name" value="Name" class="col-3 text-end" />
							<TextInput
								id="name"
								type="text"
								class="col"
								v-model="form.name"
								required
								autofocus
								autocomplete="name"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="url" value="Url" class="col-3 text-end" />
							<TextInput
								id="url"
								type="text"
								class="col"
								v-model="form.url"
								required
								autofocus
								autocomplete="url"
							/>
							<InputError class="mt-2" :message="form.errors.url" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="email" value="E-mail" class="col-3 text-end" />
							<TextInput
								id="email"
								type="text"
								class="col"
								v-model="form.email"
								required
								autofocus
								autocomplete="email"
							/>
							<InputError class="mt-2" :message="form.errors.email" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="phone" value="Phone" class="col-3 text-end" />
							<TextInput
								id="phone"
								type="text"
								class="col"
								v-model="form.phone"
								required
								autofocus
								autocomplete="phone"
							/>
							<InputError class="mt-2" :message="form.errors.phone" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="like" value="Likes" class="col-3 text-end" />
							<TextInput
								id="like"
								type="number"
								class="col"
								v-model="form.like"
								required
								autofocus
								autocomplete="like"
							/>
							<InputError class="mt-2" :message="form.errors.like" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="dislike" value="Dislikes" class="col-3 text-end" />
							<TextInput
								id="dislike"
								type="number"
								class="col"
								v-model="form.dislike"
								required
								autofocus
								autocomplete="dislike"
							/>
							<InputError class="mt-2" :message="form.errors.dislike" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="sales" value="Sales" class="col-3 text-end" />
							<TextInput
								id="sales"
								type="number"
								class="col"
								v-model="form.sales"
								required
								autofocus
								autocomplete="sales"
							/>
							<InputError class="mt-2" :message="form.errors.sales" />
						</div>
					</div>
					<div class="row justify-content-end">
						<div class="col-2 m-4">
						<PrimaryButton :disabled="form.processing">Save</PrimaryButton>
							<p v-if="form.recentlySuccessful" class="text-success">
								Saved
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
