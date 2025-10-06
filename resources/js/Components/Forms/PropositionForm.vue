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
	order: {
		type: Object,
	},
	currentProposition: {
		type: Object,
	},
	distributors: {
        type: Array,
	},
	modal: {
		type: Boolean,
	},
});

const form = useForm(props.currentProposition);

watch(
	() => props.currentProposition,
	() => {
		form.id = props.currentProposition ? props.currentProposition.id : 0;
		form.distributor_item_id = props.currentProposition ? props.currentProposition.distributor_item_id : 0;
		form.count = props.currentProposition ? props.currentProposition.count  : 0;
		form.is_enabled = props.currentProposition ? props.currentProposition.is_enabled : false;
		form.token = props.csrf_token;
		form.clearErrors();
});

const saveProposition = () => {
	return form.put( route( 'proposition.update' ), {
		onSuccess: () => {
			props.currentProposition.count = form.count;
			props.currentProposition.is_enabled = !!form.is_enabled;
		},
	});
};
</script>

<template>
	<div v-if="currentProposition" :class="{ modal: modal }" tabindex="-1" id="propositionFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="propositionForm" id="proposition-form" class="p-3 needs-validation" @submit.prevent.stop="saveProposition">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.distributor_item_id > 0 ? 'Edit #' + form.distributor_item_id : 'Add' }} order's Proposition</div>
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
							<InputLabel for="count" value="Count" class="col-3 text-end" />
							<TextInput
								id="count"
								type="number"
								class="col"
								v-model="form.count"
								required
								autofocus
								autocomplete="count"
							/>
							<InputError class="mt-2" :message="form.errors.count" />
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
