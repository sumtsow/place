<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;
props.item.token = props.csrf_token;
props.item.is_enabled = !!props.item.is_enabled;
const form = useForm(props.item);

defineProps({
	item: {
        type: Object,
	},
});

watch(
	() => props.item,
	() => {
		form.id = props.item ? props.item.id : 0;
		form.name = props.item ? props.item.name : '';
		form.is_enabled = props.item ? props.item.is_enabled : false;
		form.unit_id = props.item ? props.item.unit_id : 0;
		form.description = props.item ? props.item.description : '';
		form.token = props.csrf_token;
});

let clearItemValids = () => {
};
let saveItem = () => {
	return !!form.id ? form.put(route('item.update', [form.id])) : form.put(route('item.store'));
};
</script>

<template>
	<div v-if="item" :class="{ modal: modal }" tabindex="-1" id="itemFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="itemForm" id="item-form" class="p-3 needs-validation" @submit.prevent="saveItem">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit item ' + form.id : 'Add item' }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" v-on:click="clearItemalids"></button>
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
							<InputLabel for="unit_id" value="unit" class="col-3 text-end" />
							<TextInput
								id="unit_id"
								type="number"
								class="col"
								v-model="form.unit_id"
								autofocus
								autocomplete="unit_id"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="description" value="Description" class="col-3 text-end" />
							<TextInput
								id="description"
								type="text"
								class="col"
								v-model="form.description"
								autofocus
								autocomplete="description"
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
