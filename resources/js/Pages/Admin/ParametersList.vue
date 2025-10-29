<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Parameter from '@/Pages/Admin/Parameter.vue';
import ParameterForm from '@/Components/Forms/ParameterForm.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';

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
	groupId: {
		type: Number,
	},
});

const selectParameter = (param) => {
	if ( param ) props.parameter = param;
};

const selectGroup = () => {
	router.visit( route('parameter.admin', [ props.groupId ] ) );
};

const toggleState = (group) => {
	if (!group) return;
	useForm({
		id: group.id,
		is_enabled: !!group.is_enabled,
	}).put( route('parameter.update-state') );
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.parameters.toLowerCase(), route: false } ]" />
		<h2>{{ $page.props.lang.admin.parameters }}</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#parameterFormModal" @click.prevent.stop="selectParameter(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.admin.parameter.toLowerCase() }}</Link>
				<Link v-else @click.prevent.stop="selectParameter(0)" :href="route('parameter.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.admin.parameter.toLowerCase() }}</Link>
			</div>
		</div>
		<div class="row my-3">
			<InputLabel for="group-id" :value="$page.props.lang.admin.group" class="col-3 text-end" />
			<SelectList
				:options="groups"
				id="group-id"
				type="number"
				:defaultOption="$page.props.lang.admin.all"
				class="col"
				v-model="props.groupId"
				@change="selectGroup"
			/>
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
					<th>{{ $page.props.lang.admin.name }}</th>
					<th>{{ $page.props.lang.admin.order }}</th>
					<th>{{ $page.props.lang.admin.group }}</th>
					<th>{{ $page.props.lang.admin.measuring_unit }}</th>
					<th>{{ $page.props.lang.admin.enabled }}</th>
					<th>{{ $page.props.lang.admin.created }}</th>
					<th>{{ $page.props.lang.admin.updated }}</th>
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
				<td :class="{ 'text-danger': !parameter.paramgroup_id && parameter.is_enabled, 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.paramgroup_id ? parameter.group.name : empty }}</td>
				<td :class="{ 'text-danger': !parameter.unit, 'text-body-tertiary': !parameter.is_enabled }">{{ parameter.unit ? parameter.unit.name : empty }}</td>
				<td :class="{ 'text-body-tertiary': !parameter.is_enabled }">
				<div class="d-inline-block form-check form-switch">
					<CheckInput name="is_enabled" v-model="parameter.is_enabled" label="Enabled" @toggleState="toggleState(parameter)"/>
				</div>
				</td>
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
		<ParameterForm v-if="modal" :parameter="parameter" />
	</Page>
</template>
