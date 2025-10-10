<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

props.parameter.token = props.csrf_token;

defineProps({
	parameter: {
        type: Object,
	},
});

const form = useForm(props.parameter);

watch(
	() => props.parameter,
	() => {
		form.id = props.parameter ? props.parameter.id : 0;
		form.name = props.parameter ? props.parameter.name : '';
		form.order = props.parameter ? props.parameter.order : 0;
		form.is_enabled = props.parameter ? props.parameter.is_enabled : false;
		form.unit_id = props.parameter ? +props.parameter.unit_id : 0;
		form.paramgroup_id = props.parameter ? +props.parameter.paramgroup_id : 0;
		form.token = props.csrf_token;
		form.clearErrors();
});

const saveParameter = () => {
	return !!form.id ? form.put( route('parameter.update')) : form.put(route('parameter.store'));
};
</script>

<template>
	<div v-if="parameter" :class="{ modal: modal }" tabindex="-1" id="parameterFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="parameterForm" id="parameter-form" class="p-3 needs-validation" @submit.prevent.stop="saveParameter">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add' }} parameter</div>
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
								required
								autofocus
								autocomplete="order"
							/>
							<InputError class="mt-2" :message="form.errors.order" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="paramgroup_id" value="Group" class="col-3 text-end" />
							<SelectList
								:options="props.groups"
								id="paramgroup_id"
								type="number"
								defaultOption="None"
								class="col"
								v-model="form.paramgroup_id"
								autofocus
								autocomplete="paramgroup_id"
							/>
							<InputError class="mt-2" :message="form.errors.paramgroup_id" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="unit_id" value="Unit" class="col-3 text-end" />
							<SelectList
								:options="props.units"
								id="unit_id"
								type="number"
								defaultOption="None"
								class="col"
								v-model="form.unit_id"
								autofocus
								autocomplete="unit_id"
							/>
							<InputError class="mt-2" :message="form.errors.unit_id" />
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
