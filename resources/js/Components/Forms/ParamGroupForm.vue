<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

props.paramGroup.token = props.csrf_token;

defineProps({
	paramGroup: {
        type: Object,
	},
});

const form = useForm(props.paramGroup);

watch(
	() => props.paramGroup,
	() => {
		form.id = props.paramGroup ? props.paramGroup.id : 0;
		form.name = props.paramGroup ? props.paramGroup.name : '';
		form.order = props.paramGroup ? props.paramGroup.order : 0;
		form.is_enabled = props.paramGroup ? props.paramGroup.is_enabled : false;
		form.token = props.csrf_token;
		form.clearErrors();
});

const saveGroup = () => {
	return !!form.id ? form.put( route('param-group.update', [form.id])) : form.put(route('param-group.store'));
};
</script>

<template>
	<div v-if="paramGroup" :class="{ modal: modal }" tabindex="-1" id="groupFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="paramGroupForm" id="param-group-form" class="p-3 needs-validation" @submit.prevent.stop="saveGroup">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add' }} group</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="form.clearErrors"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
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
							<InputLabel for="order" value="Order" class="col-3 text-end" />
							<TextInput
								id="order"
								type="number"
								class="col"
								v-model="form.order"
								autofocus
								autocomplete="order"
							/>
							<InputError class="mt-2" :message="form.errors.order" />
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
