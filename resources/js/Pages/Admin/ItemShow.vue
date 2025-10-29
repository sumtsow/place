<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import ParameterValueForm from '@/Components/Forms/ParameterValueForm.vue';
import { Link, usePage, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = usePage().props;

defineProps({
	item: {
        type: Object,
	},
	parameters: {
        type: Array,
	},
	groups: {
        type: Array,
	},
	gid: {
		type: Number,
	},
	emptyParameter: {
		type: String,
	},
	emptyValue: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
});

let newParameterId = 0;

const value = ref({});
let gid = +props.gid;

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

let selectGroup = () => {
	useForm().get( route('item.show', [ props.item.id, gid ] ) );
}

let selectValue = (pivot) => {
	value.value = pivot ? pivot : {};
	props.value = value.value;
};

let saveParameters = () => {
	form.put( route( 'item-param.update', [ props.item.id ] ), {
		onSuccess: () => {
			router.visit( route('item.show', [ props.item.id ] ) );
		},
	});
};
</script>

<template>
	<Page :title="$page.props.lang.admin.edit + $page.props.lang.admin.parameters.toLowerCase() + $page.props.lang.admin.of_item">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.items, route: 'item.admin' }, { title: $page.props.lang.admin.edit + $page.props.lang.admin.parameters.toLowerCase() + $page.props.lang.admin.of_item, route: false } ]" />
		<h5>{{ item.name }} {{ $page.props.lang.admin.parameters.toLowerCase() }}</h5>
		<div class="d-none">{{ item.parameters = props.item.parameters }}</div>
		<form name="itemParametersForm" id="item-parameters-form" @submit.prevent="saveParameters">
			<ul class="list-group">
				<template v-if="item.parameters.length">
				<li v-for="parameter in props.item.parameters" class="list-group-item d-flex justify-content-between align-items-center">
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
					<div class="row">
						<div class="col">
							<InputLabel for="paramgroup_id" :value="$page.props.lang.admin.parameter_group" class="text-end fw-bold" />
							<SelectList
								:options="groups"
								id="paramgroup_id"
								class="form-select"
								v-model="gid"
								:default-option="$page.props.lang.admin.select + $page.props.lang.admin.parameter_group_ + '...'"
								@change="selectGroup"
							/>
						</div>
						<div class="col">
							<InputLabel for="parameter_id" :value="$page.props.lang.admin.parameter" class="text-end fw-bold" />
							<SelectList
								:options="parameters"
								id="parameter_id"
								class="form-select"
								v-model="newParameterId"
								:default-option="$page.props.lang.admin.select + $page.props.lang.admin.parameter + '...'"
							/>
						</div>
						<div class="col">
							<PrimaryButton @click.prevent.stop="addParameter" class="d-inline-block float-end"><span class="fs-3 lh-1 py-0">+</span></PrimaryButton>
						</div>
                    </div>
				</li>
			</ul>
			<div class="row justify-content-end">
				<div class="col-2 m-4">
				<PrimaryButton :disabled="form.processing">{{ $page.props.lang.customer.save }}</PrimaryButton>
					<p v-if="form.recentlySuccessful" class="">
						{{ $page.props.lang.customer.saved }}
					</p>
				</div>
			</div>
		</form>
		<ParameterValueForm v-if="modal" :value="value" :emptyValue="emptyValue"/>
    </Page>
</template>
