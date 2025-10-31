<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
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
	catList: {
        type: Object,
	},
});

watch(
	() => props.category,
	() => {
		form.id = props.category ? props.category.id : 0;
		form.name = props.category ? props.category.name : '';
		form.is_enabled = props.category ? props.category.is_enabled : false;
		form.category_id = props.category ? props.category.category_id : 0;
		form.logo = props.category ? props.category.logo : '';
		form.token = props.csrf_token;
});

const saveCategory = () => {
	return !!form.id ? form.put(route('category.update', [form.id])) : form.put(route('category.store'));
};
</script>

<template>
	<div v-if="category" :class="{ modal: modal }" tabindex="-1" id="categoryFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="categoryForm" id="category-form" class="p-3 needs-validation" @submit.prevent="saveCategory">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? $page.props.lang.admin.edit + $page.props.lang.admin.category_ + form.id : $page.props.lang.admin.add + $page.props.lang.admin.new_female_ + $page.props.lang.admin.category_ }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" v-on:click="clearCategoryValids"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-2"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
									<label class="form-check-label" for="visible">{{ $page.props.lang.admin.enabled }}</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="name" :value="$page.props.lang.admin.name" class="col-3 text-end" />
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
							<InputLabel for="category_id" :value="$page.props.lang.admin.category" class="col-3 text-end" />
							<SelectList
								:options="props.catList"
								id="category_id"
								class="col d-inline-block w-75"
								v-model="form.category_id"
								autofocus
								autocomplete="category_id"
							/>
							<InputError class="mt-2" :message="form.errors.category_id" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="logo" :value="$page.props.lang.admin.logo" class="col-3 text-end" />
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
						<div class="row justify-content-end">
							<div class="col text-end pe-4">
							<PrimaryButton :disabled="form.processing">{{ $page.props.lang.customer.save }}</PrimaryButton>
								<p v-if="form.recentlySuccessful" class="text-success">
									{{ $page.props.lang.customer.saved }}
								</p>
							</div>
						</div>						
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
