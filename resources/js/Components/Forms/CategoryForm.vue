<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { reactive, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;
props.category.token = props.csrf_token;
props.category.is_enabled = !!props.category.is_enabled;
const form = useForm(props.category);

defineProps({
	category: {
        type: Object,
	},
});

watch(
	() => props.category,
	() => {
		form.id = props.category.id;
		form.name = props.category.name;
		form.is_enabled = props.category.is_enabled;
		form.category_id = props.category.category_id;
		form.logo = props.category.logo;
});

let clearCategoryValids = () => {
};
let saveCategory = () => {
	return form.put(route('category.update', [form.id]));
};
</script>

<template>
	<div v-if="category" :class="{ modal: modal }" tabindex="-1" id="categoryFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="categoryForm" id="category-form" class="p-3 needs-validation" @submit.prevent="saveCategory">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit category ' + form.id : 'Add category' }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" v-on:click="clearCategoryValids"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
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
							<InputLabel for="category_id" value="CategoryId" class="col-3 text-end" />
							<TextInput
								id="category_id"
								type="number"
								class="col"
								v-model="form.category_id"
								autofocus
								autocomplete="category_id"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="logo" value="Logo" class="col-3 text-end" />
							<TextInput
								id="logo"
								type="text"
								class="col"
								v-model="form.logo"
								autofocus
								autocomplete="logo"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
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
