<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

const form = useForm(props.currentDistributorItem);

defineProps({
	currentDistributorItem: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
});

watch(
	() => props.currentDistributorItem,
	() => {
		form.id = props.currentDistributorItem ? props.currentDistributorItem.id : 0;
		form.item_id = props.currentDistributorItem ? props.currentDistributorItem.item_id : 0;
		form.distributor_id = props.currentDistributorItem ? props.currentDistributorItem.distributor_id : 0;
		form.count = props.currentDistributorItem ? props.currentDistributorItem.count : 0;
		form.price = props.currentDistributorItem ? props.currentDistributorItem.price : 0;
		form.discount = props.currentDistributorItem ? props.currentDistributorItem.discount : 0;
		form.delivery = props.currentDistributorItem ? props.currentDistributorItem.delivery : 0;
		form.is_enabled = props.currentDistributorItem ? props.currentDistributorItem.is_enabled : false;
		form.token = props.csrf_token;
		form.clearErrors();
});

const saveDistributorItem = () => {
	return form.put( route( 'distributor-item.update' ), {
		onSuccess: () => {
			props.currentDistributorItem.count = form.count;
			props.currentDistributorItem.is_enabled = !!form.is_enabled;
		},
	});
};
</script>

<template>
	<div v-if="currentDistributorItem" :class="{ modal: modal }" tabindex="-1" id="distributorItemFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="distributorItemForm" id="distributor-item-form" class="p-3 needs-validation" @submit.prevent.stop="saveDistributorItem">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ ( form && form.id > 0 ? $page.props.lang.admin.edit : $page.props.lang.admin.add ) + $page.props.lang.admin.distributor_ + form.id + ' ' + $page.props.lang.admin.item.toLowerCase() }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" @click="form.reset"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled" value="1"/>
									<label class="form-check-label" for="visible">{{ $page.props.lang.admin.enabled }}</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="count" :value="$page.props.lang.admin.count" class="col-3 text-end" />
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

						<div class="input-group row mb-3">
							<InputLabel for="price" :value="$page.props.lang.customer.price + ', ' + $page.props.lang.customer.currency" class="col-3 text-end" />
							<TextInput
								id="price"
								type="text"
								class="col"
								v-model="form.price"
								required
								autofocus
								autocomplete="price"
							/>
							<InputError class="mt-2" :message="form.errors.price" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="discount" :value="$page.props.lang.customer.discount + ', %'" class="col-3 text-end" />
							<TextInput
								id="discount"
								type="text"
								class="col"
								v-model="form.discount"
								required
								autofocus
								autocomplete="discount"
							/>
							<InputError class="mt-2" :message="form.errors.discount" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="delivery" :value="$page.props.lang.customer.delivery + ', ' + $page.props.lang.customer.days" class="col-3 text-end" />
							<TextInput
								id="delivery"
								type="text"
								class="col"
								v-model="form.delivery"
								required
								autofocus
								autocomplete="delivery"
							/>
							<InputError class="mt-2" :message="form.errors.discount" />
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
