<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const props = usePage().props;
const modal = props.modal;
const processing = ref(false);
const saved = ref(false);

defineProps({
	value: {
		type: Object,
	},
	emptyValue: {
		type: Object,
	},
});

if ( !props.value ) props.value = props.emptyValue;

const closeForm = () => {
	processing.value = false;
	saved.value = false;
};

const saveValue = () => {
	processing.value = true;
	return useForm( props.value ).put( route('value.update'), {
		onSuccess: () => {
			processing.value = false;
			saved.value = true;
		},
	});
};
</script>

<template>
	<div v-if="value" :class="{ modal: modal }" tabindex="-1" id="parameterValueFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="valueForm" id="value-form" class="p-3 needs-validation" @submit.prevent.stop="saveValue">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">Edit {{ props.value.parameter_id }} value</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="closeForm"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group row mb-3">
							<InputLabel for="value" value="Value" class="col-3 text-end" />
							<TextInput
								id="value"
								type="text"
								class="col"
								v-model="props.value.value"
								autofocus
								autocomplete="value"
							/>
						</div>
					</div>
					<div class="row justify-content-end">
						<div class="col-2 m-4">
						<PrimaryButton :disabled="processing">Save</PrimaryButton>
							<p v-if="saved" class="text-success">
								Saved
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
