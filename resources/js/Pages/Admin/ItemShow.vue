<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import ParameterValueForm from '@/Components/Forms/ParameterValueForm.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;

defineProps({
	item: {
        type: Object,
	},
	parameters: {
        type: Array,
	},
	emptyParameter: {
		type: String,
	},
	title: {
		type: String,
		default: 'Item`s parameters edit',
	},
	modal: {
		type: Boolean,
	},
});

let newParameterId = 0;

const value = ref({});

const form = useForm({
	parameters: [],
	token: props.csrf_token,
});

let addParameter = () => {
	if ( !newParameterId ) return false;
	if ( !collectionHasModel( props.item.parameters, newParameterId ) ) {
		props.item.parameters.push( findModelById(props.parameters, newParameterId ) );
		form.parameters = props.item.parameters;
	};
};

let selectValue = (pivot) => {
	value.value = pivot ? pivot : {};
	props.value = value.value;
};

let saveParameters = () => {
	form.put( route( 'item-param.update', [ props.item.id ] ) );
	value.value = {};
};

</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Items', route: 'item.admin' }, { title: title, route: false } ]" />
		<form name="itemParametersForm" id="item-parameters-form" @submit.prevent="saveParameters">
			<ul class="list-group">
				<template v-if="item.parameters.length">
				<li v-for="parameter in item.parameters" class="list-group-item d-flex justify-content-between align-items-center">
					{{ parameter.name }}
					<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#parameterValueFormModal" @click.prevent.stop="selectValue(parameter.pivot)" class="btn text-decoration-none":class="{'btn-outline-danger': (parameter.pivot && !parameter.pivot.value), 'btn-outline-primary': (parameter.pivot && parameter.pivot.value) }">
					{{ parameter.pivot ? (parameter.pivot.value ? parameter.pivot.value : emptyParameter ) : '' }}
					{{ parameter.unit && parameter.pivot.value !== null ? parameter.unit.name : '' }}
					</Link>
					<Link v-else @click.prevent.stop="selectValue(parameter.pivot)" :href="route('value.edit', [ item.id, parameter.id ])" class="btn text-decoration-none" :class="{'btn-outline-danger': (parameter.pivot && !parameter.pivot.value), 'btn-outline-primary': (parameter.pivot && parameter.pivot.value) }">
					{{ parameter.pivot ? (parameter.pivot.value ? parameter.pivot.value : emptyParameter ) : '' }}
					{{ parameter.unit && parameter.pivot.value !== null ? parameter.unit.name : '' }}
					</Link>
				</li>
				</template>
				<li class="list-group-item">
					<SelectList
						:options="parameters"
						id="parameter_id"
						type="number"
						class="col d-inline-block w-75"
						v-model="newParameterId"
						:default-option="'Select parameter ...'"
						:data-key="key"
						autofocus
						autocomplete="parameter_id"
					/>
					<PrimaryButton @click.prevent.stop="addParameter" class="d-inline-block float-end"><span class="fs-3 lh-1 py-0">+</span></PrimaryButton>
				</li>
			</ul>
			<div class="row justify-content-end">
				<div class="col-2 m-4">
				<PrimaryButton :disabled="form.processing">Save</PrimaryButton>
					<p v-if="form.recentlySuccessful" class="">
						Saved.
					</p>
				</div>
			</div>
		</form>
		<ParameterValueForm v-if="modal" :value="value"/>
    </Page>
</template>
