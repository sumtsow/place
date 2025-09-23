<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

defineProps({
	value: {
        type: Object,
	},
});

if (!props.value) props.value = {
	item_id: 0,
	parameter_id: 0,
	value: '',
	token: props.csrf_token,
};

const valueForm = useForm(props.value);

watch(
	() => props.value,
	() => {
		valueForm.item_id = props.value ? props.value.item_id : 0;
		valueForm.parameter_id = props.value ? props.value.parameter_id : 0;
		valueForm.value = props.value ? props.value.value : '';
		//valueForm.token = props.csrf_token;
		valueForm.clearErrors();
});

let saveValue = () => {
	return valueForm.put( route('value.update') );
};
</script>

<template>
	<div v-if="value" :class="{ modal: modal }" tabindex="-1" id="parameterValueFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="valueForm" id="value-form" class="p-3 needs-validation" @submit.prevent.stop="saveValue">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">Edit {{ valueForm.id }} value</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="valueForm.clearErrors"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group row mb-3">
							<InputLabel for="value" value="Value" class="col-3 text-end" />
							<TextInput
								id="value"
								type="text"
								class="col"
								v-model="valueForm.value"
								required
								autofocus
								autocomplete="value"
							/>
							<InputError class="mt-2" :message="valueForm.errors.value" />
						</div>
					</div>
					<div class="row justify-content-end">
						<div class="col-2 m-4">
						<PrimaryButton :disabled="valueForm.processing">Save</PrimaryButton>
							<p v-if="valueForm.recentlySuccessful" class="text-success">
								Saved
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
