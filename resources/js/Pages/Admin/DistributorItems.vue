<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, usePage, useForm  } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;
const form = useForm({items: [], distributor_id: 0});

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
});

let currentItem = {id: 0, name: ''};

const addItem = () => {
	if ( currentItem.id == 0 ) return;
	if ( !collectionHasModel( props.distributor.items, currentItem.id ) ) {
		props.distributor.items.push( findModelById(props.items, currentItem.id ) );
	}
};

const getItemIds = () => {
	return props.distributor.items.flatMap( (item) => item.id ).sort();
};

const saveItems = () => {
	form.distributor_id = props.distributor.id;
	form.items = getItemIds();
	return form.put( route('distributor.items') );
};

const toggleState = (item) => {
	if (!item) return;
	useForm({
		item_id: item.item_id,
		distributor_id: item.distributor_id,
		is_enabled: !!item.is_enabled,
	}).put( route('distributor.updateItemState') );
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
					v-model="currentItem.id"
					autofocus
					autocomplete="items"
				/>
				<PrimaryButton @click="addItem">Add&nbsp;item</PrimaryButton>
				<InputError class="mt-2" :message="form.errors.items" />
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
					<tr v-for="item in props.distributor.items">
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.id }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.name }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.pivot ? item.pivot.count : 0 }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.pivot ? item.pivot.price : '0.00' }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.pivot ? item.pivot.discount : 0 }} %</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ item.pivot ? item.pivot.delivery : '' }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">
							<div class="d-inline-block form-check form-switch">
							<template v-if="!item.pivot">
								<CheckInput name="is_enabled" value="false" label="Enabled"/>
							</template>
							<template v-else>
								<CheckInput name="is_enabled" v-model="item.pivot.is_enabled" label="Enabled" @toggleState="toggleState(item.pivot)"/>
							</template>
							</div>
						</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ new Date(item.pivot ? item.pivot.created_at : null).toLocaleString() }}</td>
						<td :class="{ 'text-secondary': item.pivot && !item.pivot.is_enabled }">{{ new Date(item.pivot ? item.pivot.updated_at : null).toLocaleString() }}</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
			<div class="col">
				<PrimaryButton form="distributor-item-form" :disabled="form.processing">Save</PrimaryButton>
			</div>
			<div class="col text-success">
				<template v-if="form.recentlySuccessful">Saved.</template>
			</div>
			</div>
		</div>
	</Page>
</template>
