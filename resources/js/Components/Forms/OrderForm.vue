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

defineProps({
	order: {
		type: Object,
	},
	customers: {
		type: Array,
	},
	statuses: {
		type: Array,
	},
	modal: {
		type: Boolean,
	},
});

const form = useForm(props.order);

watch(
	() => props.order,
	() => {
		form.id = props.order ? props.order.id : 0;
		form.customer_id = props.order ? props.order.customer_id : 0;
		form.is_enabled = props.order ? props.order.is_enabled : false;
		form.status = props.order ? props.order.status : 'undefined';
		form.address = props.order ? props.order.address : '';
		form.expired = props.order ? props.order.expired : null;
		form.token = props.csrf_token;
		form.clearErrors();
});

const saveOrder = () => {
	return !!form.id ? form.put( route('order.update', [form.id])) : form.put(route('order.store'));
};
</script>

<template>
	<div v-if="order" :class="{ modal: modal }" tabindex="-1" id="orderFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="orderForm" id="order-form" class="p-3 needs-validation" @submit.prevent.stop="saveOrder">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit ' + form.id : 'Add' }} order</div>
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
							<InputLabel for="customer_id" value="Customer" class="col-3 text-end" />
							<SelectList
								:options="customers"
								id="unit_id"
								class="col"
								v-model="form.customer_id"
								autofocus
								autocomplete="customer_id"
							/>
							<InputError class="mt-2" :message="form.errors.customer_id" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="status" value="Status" class="col-3 text-end" />
							<SelectList
								:options="statuses"
								id="status"
								class="col"
								v-model="form.status"
								autofocus
								autocomplete="status"
							/>
							<InputError class="mt-2" :message="form.errors.status" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="address" value="Address" class="col-3 text-end" />
							<TextInput
								id="address"
								type="text"
								class="col"
								v-model="form.address"
								required
								autofocus
								autocomplete="address"
							/>
							<InputError class="mt-2" :message="form.errors.address" />
						</div>
					
						<div class="input-group row mb-3">
							<InputLabel for="expired" value="Expired" class="col-3 text-end" />
							<TextInput
								id="expired"
								type="datetime-local"
								class="col"
								v-model="form.expired"
								autofocus
								autocomplete="expired"
							/>
							<InputError class="mt-2" :message="form.errors.expired" />
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
