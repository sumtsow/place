<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Unit from '@/Pages/Admin/Unit.vue';
import UnitForm from '@/Components/Forms/UnitForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const url = new URL(usePage().url, window.location.origin);
const params = new URLSearchParams(url.search);
const sort = params.get('sort') ? params.get('sort') : 'id';
const order = params.get('order') === 'desc' ? 'asc' : 'desc';

defineProps({
	units: {
        type: Array,
	},
	unit: {
        type: Object,
	},
	types: {
        type: Array,
	},
	unitTypes: {
        type: Array,
	},	
	modal: {
		type: Boolean,
	},
});

const selectUnit = (unit) => {
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
};
</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.measuring_units.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.measuring_units.toLowerCase(), route: false } ]" />
		<h2>{{ $page.props.lang.admin.measuring_units }}</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#unitFormModal" @click.prevent.stop="selectUnit(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_female_ + $page.props.lang.admin.measuring_unit_ }}</Link>
				<Link v-else @click.prevent.stop="selectUnit(0)" :href="route('unit.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_female_ + $page.props.lang.admin.measuring_unit_ }}</Link>
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
					<th>
						<Link :class="{ active: sort === 'id' }" :href="route('unit.admin', { sort: 'id', order: order, page: units.current_page })">Id</Link>
						<span v-if="sort === 'id'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'name' }" :href="route('unit.admin', { sort: 'name', order: order, page: units.current_page })">{{ $page.props.lang.admin.name }}</Link>
						<span v-if="sort === 'name'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'type' }" :href="route('unit.admin', { sort: 'type', order: order, page: units.current_page })">{{ $page.props.lang.admin.type }}</Link>
						<span v-if="sort === 'type'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'is_enabled' }" :href="route('unit.admin', { sort: 'is_enabled', order: order, page: units.current_page })">{{ $page.props.lang.admin.enabled }}</Link>
						<span v-if="sort === 'is_enabled'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'created_at' }" :href="route('unit.admin', { sort: 'created_at', order: order, page: units.current_page })">{{ $page.props.lang.admin.created }}</Link>
						<span v-if="sort === 'created_at'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'updated_at' }" :href="route('unit.admin', { sort: 'updated_at', order: order, page: units.current_page })">{{ $page.props.lang.admin.updated }}</Link>
						<span v-if="sort === 'updated_at'" v-html="order==='asc' ? '&darr;' : '&uarr;'"/>
					</th>
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
				<td>{{ unitTypes[unit.type] }}</td>
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
