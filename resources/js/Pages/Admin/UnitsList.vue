<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Unit from '@/Pages/Admin/Unit.vue';
import UnitForm from '@/Components/Forms/UnitForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
    title: {
        type: String,
		default: 'Manage measuring units',
    },
	units: {
        type: Array,
	},
	unit: {
        type: Object,
	},
	modal: {
		type: Boolean,
	},
});

let selectUnit = (unit) => {
	if ( !unit ) {
		unit = {
			id: 0,
			name: '',
			type: 0,
			is_enabled: false,
		}
	};
	unit.is_enabled = !!unit.is_enabled;
	props.unit = unit;
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Units</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#unitFormModal" @click.prevent.stop="selectUnit(0)" class="btn btn-primary m-3">Add new unit</Link>
				<Link v-else @click.prevent.stop="selectUnit(0)" :href="route('unit.create')" class="btn btn-primary m-3">Add new unit</Link>
			</div>
		</div>
		<div v-if="units.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in units.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Type</th>
					<th>Enabled</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
			</thead>
			<tbody>
			<tr v-for="unit in units.data">
				<td>{{ unit.id }}</td>
				<td>
					<template v-if="modal">
						<Link data-bs-toggle="modal" data-bs-target="#unitFormModal" @click.prevent.stop="selectUnit(unit)">
						{{ unit.name }}
						</Link>
					</template>
					<Link v-else :href="route('unit.edit', [unit.id])">
						{{ unit.name }}
					</Link>
				</td>
				<td>{{ unit.type }}</td>
				<td>{{ +unit.is_enabled }}</td>
				<td>{{ new Date(unit.created_at).toLocaleString() }}</td>
				<td>{{ new Date(unit.updated_at).toLocaleString() }}</td>
			</tr>
			</tbody>
		</table>
		<div v-if="units.last_page > 1" class="row">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in units.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<UnitForm v-if="modal" :unit="unit"/>
	</Page>
</template>
