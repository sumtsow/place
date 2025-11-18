<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import DistributorItemForm from '@/Components/Forms/DistributorItemForm.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, usePage, useForm  } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;
const formItems = useForm({ items: [], distributor_id: 0 });
const modal = props.modal;

defineProps({
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
	if ( id.value == 0 ) return;
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
	}).put( route('distributor-item.update-state') );
};
</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase() + $page.props.lang.admin.distributors_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.distributors_, route: 'distributor.admin' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase() + $page.props.lang.admin.distributors_, route: false } ]" />
		<div class="justify-content-between ms-3">
			<h2>{{ distributor.name }}</h2>

			<form name="distributor-item" id="distributor-item-form" class="p-3 needs-validation" @submit.prevent.stop="saveItems"></form>

			<div class="input-group mb-3">
				<InputLabel for="items" :value="$page.props.lang.admin.add + $page.props.lang.admin.item.toLowerCase()" class="col-3 text-end pe-2" />
				<SelectList
					:options="items"
					:defaultOption="$page.props.lang.admin.select + $page.props.lang.admin.item.toLowerCase() + '...'"
					id="items"
					class="col"
					v-model="id"
					autofocus
					autocomplete="items"
				/>
				<PrimaryButton @click="addItem">{{ $page.props.lang.admin.add + $page.props.lang.admin.item.toLowerCase() }}</PrimaryButton>
				<InputError class="mt-2" :message="formItems.errors.items" />
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>{{ $page.props.lang.admin.name }}</th>
						<th>{{ $page.props.lang.admin.count }}</th>
						<th>{{ $page.props.lang.customer.price }}</th>
						<th>{{ $page.props.lang.customer.discount }}</th>
						<th>{{ $page.props.lang.customer.delivery }}</th>
						<th>URL</th>
						<th>{{ $page.props.lang.admin.enabled }}</th>
						<th>{{ $page.props.lang.admin.created }}</th>
						<th>{{ $page.props.lang.admin.updated }}</th>
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
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.price + '&nbsp;' + $page.props.lang.customer.currency }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.discount }} %</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">{{ distributorItem.delivery }}</td>
						<td :class="{ 'text-body-tertiary': !distributorItem.is_enabled }">
							<a v-if="distributorItem.url" :href="distributorItem.url" target="_blank">
							{{ distributorItem.url }}
							</a>
						</td>
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
				<div class="col text-end">
					<PrimaryButton form="distributor-item-form" :disabled="formItems.processing">{{ $page.props.lang.customer.save }}</PrimaryButton>
				</div>
			</div>
			<div class="row">
				<div class="col text-end text-success">
					<template v-if="formItems.recentlySuccessful">{{ $page.props.lang.customer.saved }}</template>
				</div>
			</div>
		</div>
		<DistributorItemForm v-if="modal" :currentDistributorItem="currentDistributorItem"/>
	</Page>
</template>
