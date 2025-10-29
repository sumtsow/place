<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectList from '@/Components/SelectList.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

props.unit.token = props.csrf_token;
props.unit.is_enabled = !!props.unit.is_enabled;


defineProps({
	unit: {
        type: Object,
	},
});

const form = useForm(props.unit);
watch(
	() => props.unit,
	() => {
		form.id = props.unit ? props.unit.id : 0;
		form.name = props.unit ? props.unit.name : '';
		form.type = props.unit ? props.unit.type : 0;
		form.is_enabled = props.unit ? props.unit.is_enabled : false;
		form.token = props.csrf_token;
		form.clearErrors();
});

let saveUnit = () => {
	return !!form.id ? form.put( route('unit.update', [form.id])) : form.put(route('unit.store'));
};
</script>

<template>
	<div v-if="unit" :class="{ modal: modal }" tabindex="-1" id="unitFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="unitForm" id="unit-form" class="p-3 needs-validation" @submit.prevent.stop="saveUnit">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? $page.props.lang.admin.edit + $page.props.lang.admin.measuring_unit_ + form.id : $page.props.lang.admin.add + $page.props.lang.admin.measuring_unit_ }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" @click="form.clearErrors"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
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
							<InputLabel for="type" :value="$page.props.lang.admin.type" class="col-3 text-end" />
							<SelectList
								:options="props.types"
								id="type"
								type="number"
								class="col"
								v-model="form.type"
								autofocus
								autocomplete="type"
							/>
							<InputError class="mt-2" :message="form.errors.unit_id" />
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
