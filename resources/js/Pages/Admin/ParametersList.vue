<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Parameter from '@/Pages/Admin/Parameter.vue';
import ParameterForm from '@/Components/Forms/ParameterForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
    title: {
        type: String,
		default: 'Manage parameters',
    },
	parameters: {
        type: Array,
	},
	parameter: {
        type: Object,
	},
	empty: {
        type: String,
    },
	groups: {
        type: Array,
    },
	units: {
        type: Array,
    },
	modal: {
		type: Boolean,
	},
});

let selectParameter = (param) => {
	if ( param ) props.parameter = param;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Parameters</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#parameterFormModal" @click.prevent.stop="selectParameter(0)" class="btn btn-primary m-3">Add new parameter</Link>
				<Link v-else @click.prevent.stop="selectParameter(0)" :href="route('parameter.create')" class="btn btn-primary m-3">Add new parameter</Link>
			</div>
		</div>
		<div v-if="parameters.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in parameters.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Order</th>
					<th>Group</th>
					<th>Unit</th>
					<th>Enabled</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
			</thead>
			<tbody>
			<tr v-for="parameter in parameters.data">
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.id }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">
					<template v-if="modal">
						<Link data-bs-toggle="modal" data-bs-target="#parameterFormModal" @click.prevent.stop="selectParameter(parameter)">
						{{ parameter.name }}
						</Link>
					</template>
					<Link v-else :href="route('parameter.edit', [parameter.id])">
						{{ parameter.name }}
					</Link>
				</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.order }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.paramgroup_id }}</td>
				<td :class="{ 'text-danger': !parameter.unit, 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.unit ? parameter.unit.name : empty }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ +parameter.is_enabled }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ new Date(parameter.created_at).toLocaleString() }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">{{ new Date(parameter.updated_at).toLocaleString() }}</td>
			</tr>
			</tbody>
		</table>
		<div v-if="parameters.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in parameters.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<ParameterForm v-if="modal" :parameter="parameter"/>
	</Page>
</template>
