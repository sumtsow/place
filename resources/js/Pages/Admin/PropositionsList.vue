<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import CheckInput from '@/Components/CheckInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PropositionForm from '@/Components/Forms/PropositionForm.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, router, usePage, useForm  } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;
const modal = props.modal;
const formPropositions = useForm( { propositions: [] } );
let proposition = JSON.parse( JSON.stringify(props.currentProposition) );
const emptyProposition = JSON.parse( JSON.stringify(props.currentProposition) );

defineProps({
    title: {
        type: String,
		default: 'Manage order\'s propositions',
    },
	order: {
        type: Object,
	},
	propositions: {
        type: Array,
	},
	distributors: {
        type: Array,
	},
	items: {
        type: Array,
	},
	currentProposition: {
        type: Object,
	},
});

const addProposition = () => {
	if ( !( proposition && proposition.distributor_item.distributor_id && proposition.distributor_item.item_id ) ) return false;
	proposition.order_id = props.order.id;
	if ( hasProposition() ) {
		alert('Item already added!');
	} else {
		let distributorItem = getDistributorItem(props.propositions);
		if ( distributorItem ) {
			proposition.distributor_item = JSON.parse( JSON.stringify( distributorItem ) );
			proposition.distributor_item_id = distributorItem.id;
			props.order.propositions.push( JSON.parse( JSON.stringify( proposition ) ) );		
		} else {
			alert('This Distributor doesn`t sell this Item!');
		}
	}
};

const getDistributorItem = (collection) => {
	return collection.find( ( model ) => {
		return proposition.distributor_item.distributor_id == model.distributor_id && proposition.distributor_item.item_id  == model.item_id;
	});
};

const hasProposition = () => {
	return props.order.propositions.find( ( model ) => {
		return proposition.distributor_item.distributor_id == model.distributor_item.distributor_id && proposition.distributor_item.item_id  == model.distributor_item.item_id;
	});
};

const savePropositions = () => {
	formPropositions.propositions = props.order.propositions.filter( (prop) => !prop.id );
	return formPropositions.put( route('proposition.update-items', [ props.order.id ] ), {
		onSuccess: () => {
			router.reload({ only: ['order'] });
		},
	} );
};

const selectDistributor = () => {
	if (proposition.distributor_item.distributor_id) {
		proposition.distributor_item.distributor = findModelById( props.distributors, proposition.distributor_item.distributor_id );
	}
};

const selectItem = () => {
	if (proposition.distributor_item.item_id) {
		proposition.distributor_item.item = findModelById( props.items, proposition.distributor_item.item_id );
	}
};

const selectProposition = (prop) => {
	if (prop) {
		props.currentProposition = prop;
	} else {
		props.currentProposition = emptyProposition;
	}
};

const toggleState = (prop) => {
	if (!prop) return;
	useForm({
		id: prop.id,
		distributor_item_id: prop.distributor_item_id,
		order_id: prop.order_id,
		is_enabled: !!prop.is_enabled,
	}).put( route('proposition.update-state') );
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Orders', route: 'order.admin' }, { title: title, route: false } ]" />
		<div class="justify-content-between ms-3">
			<h2>Order #{{ order.id }} - {{ order.customer.user.lastname }} {{ order.customer.user.firstname }}</h2>

			<form name="formPropositions" id="form-propositions" class="p-3 needs-validation" @submit.prevent.stop="savePropositions"></form>

			<div class="input-group mb-3">
				<InputLabel for="distributor" value="Distributor" class="col-3 me-2 text-end" />
				<SelectList
					:options="distributors"
					:defaultOption="'Select distributor'"
					id="distributor"
					class="col"
					v-model="proposition.distributor_item.distributor_id"
					autofocus
					autocomplete="distributor"
					@change="selectDistributor"
				/>
				<InputError class="mt-2" :message="formPropositions.errors.distributor" />
			</div>

			<div class="input-group mb-3">
				<InputLabel for="item" value="Item" class="col-3 me-2 text-end" />
				<SelectList
					:options="items"
					:defaultOption="'Select item'"
					id="item"
					class="col"
					v-model="proposition.distributor_item.item_id"
					autofocus
					autocomplete="item"
					@change="selectItem"
				/>
				<InputError class="mt-2" :message="formPropositions.errors.item" />
			</div>

			<div class="input-group mb-3 justify-content-end">
				<PrimaryButton @click="addProposition">Add&nbsp;proposition</PrimaryButton>
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Distributor</th>
						<th>Count</th>
						<th>Enabled</th>
						<th>Created</th>
						<th>Updated</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="proposition in props.order.propositions">
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">{{ proposition.id }}</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">{{ proposition.distributor_item && proposition.distributor_item.item ? proposition.distributor_item.item.name : '' }}</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">
						{{ proposition.distributor_item && proposition.distributor_item.distributor ? proposition.distributor_item.distributor.name : '' }}
						</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled && !proposition.id }">
						<template v-if="modal">
							<Link data-bs-toggle="modal" data-bs-target="#propositionFormModal" @click.prevent.stop="selectProposition(proposition)" class="btn py-0 px-2" :class="{ 'btn-primary': proposition.is_enabled, 'btn-outline-secondary': !proposition.is_enabled, 'disabled': !proposition.id }">
								{{ proposition.count }}
							</Link>
						</template>
						<template v-else>
							<Link class="btn btn-primary py-0 px-2" v-if="proposition.id" :href="route('proposition.edit', [proposition.id])" :class="{ 'btn-primary': proposition.is_enabled, 'btn-outline-secondary': !proposition.is_enabled }" as="button">
								{{ proposition.count }}
							</Link>
							<Link v-else class="btn btn-outline-secondary py-0 px-2" :href="false" as="button" disabled>
								{{ proposition.count }}
							</Link>
						</template>
						</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">
							<div class="d-inline-block form-check form-switch">
								<CheckInput name="is_enabled" v-model="proposition.is_enabled" label="Enabled" @toggleState="toggleState(proposition)" :disabled="!proposition.id"/>
							</div>
						</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">{{ proposition.created_at ? new Date(proposition.created_at).toLocaleString() : ''}}</td>
						<td :class="{ 'text-body-tertiary': !proposition.is_enabled }">{{ proposition.updated_at ? new Date(proposition.updated_at).toLocaleString() : '' }}</td>
					</tr>
				</tbody>
			</table>

			<div class="row">
			<div class="col">
				<PrimaryButton form="form-propositions" :disabled="formPropositions.processing">Save</PrimaryButton>
			</div>
			<div class="col text-success">
				<template v-if="formPropositions.recentlySuccessful">Saved.</template>
			</div>
			</div>
		</div>
		<PropositionForm v-if="modal" :distributors="distributors" :order="order" :currentProposition="currentProposition" :modal="modal"/>
	</Page>
</template>
