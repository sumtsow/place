<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import DistributorItemForm from '@/Components/Forms/DistributorItemForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, usePage, useForm  } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;
const formItems = useForm({ items: [], distributor_id: 0 });
const modal = props.modal;

defineProps({
    title: {
        type: String,
		default: 'Manage distributor\'s items',
    },
	distributor: {
        type: Object,
	},
	items: {
        type: Array,
	},
	currentDistributorItem: {
        type: Object,
	},
	modal: {
        type: Boolean,
	},
});

const id = ref(0);
const emptyDistributorItem = JSON.parse( JSON.stringify( props.currentDistributorItem ) );

const addItem = () => {
	if ( id == 0 ) return;
	if ( !collectionHasModel( props.distributor.distributor_items, id ) ) {
		let model = JSON.parse( JSON.stringify( emptyDistributorItem ) );
		if (model) {
			model.item = findModelById( props.items, id.value );
			model.item_id = model.item.id;
			props.distributor.distributor_items.push( model );
		}
	}
};

const saveItems = () => {
	formItems.distributor_id = props.distributor.id;
	formItems.items = props.distributor.distributor_items.filter( (prop) => !prop.id );
	return formItems.put( route('distributor-items.update') );
};

const selectDistributorItem = (di) => {
	if (di) props.currentDistributorItem = di;
};

const toggleState = (di) => {
	if (!di) return;
	useForm({
		item_id: di.item_id,
		distributor_id: di.distributor_id,
		is_enabled: !!di.is_enabled,
	}).put( route('distributor-item.updateState') );
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Distributors', route: 'distributor.admin' }, { title: title, route: false } ]" />
		<div class="justify-content-between ms-3">
			<h2>{{ distributor.name }}</h2>

			<form name="distributor-item" id="distributor-item-form" class="p-3 needs-validation" @submit.prevent.stop="saveItems"></form>

			<div class="input-group mb-3">
				<InputLabel for="items" value="Add item" class="col-3 text-end" />
				<SelectList
					:options="items"
					:defaultOption="'Select item'"
					id="items"
					class="col"
					v-model="id"
					autofocus
					autocomplete="items"
				/>
				<PrimaryButton @click="addItem">Add&nbsp;item</PrimaryButton>
				<InputError class="mt-2" :message="formItems.errors.items" />
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Count</th>
						<th>Price</th>
						<th>Discount</th>
						<th>Delivery</th>
						<th>Enabled</th>
						<th>Created</th>
						<th>Updated</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="distributorItem in distributor.distributor_items">
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.id }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">
							<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#distributorItemFormModal" @click.prevent.stop="selectDistributorItem(distributorItem)" :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">
								{{ distributorItem.item ? distributorItem.item.name : '' }}
							</Link>
							<Link v-else :href="route('distributor-item.edit', [distributorItem.id])" :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">
								{{ distributorItem.item ? distributorItem.item.name : '' }}
							</Link>
						</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.count }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.price }}&nbsp;{{ props.currency }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.discount }} %</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.delivery }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">
							<div class="d-inline-block form-check form-switch">
								<CheckInput name="is_enabled" v-model="distributorItem.is_enabled" label="Enabled" @toggleState="toggleState(distributorItem)"/>
							</div>
						</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.created_at ? new Date(distributorItem.created_at).toLocaleString() : null }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.updated_at ? new Date(distributorItem.updated_at).toLocaleString() : null }}</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
			<div class="col">
				<PrimaryButton form="distributor-item-form" :disabled="formItems.processing">Save</PrimaryButton>
			</div>
			<div class="col text-success">
				<template v-if="formItems.recentlySuccessful">Saved.</template>
			</div>
			</div>
		</div>
		<DistributorItemForm v-if="modal" :currentDistributorItem="currentDistributorItem"/>
	</Page>
</template>
