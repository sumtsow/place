<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ParamGroupForm from '@/Components/Forms/ParamGroupForm.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const params = new URLSearchParams( new URL( usePage().url, window.location.origin ).search );
const sort = params.get('sort') ? params.get('sort') : 'id';
const order = params.get('order') === 'desc' ? 'asc' : 'desc';
const page = params.get('page') ? params.get('page') : 1;

defineProps({
	paramGroups: {
        type: Array,
	},
	paramGroup: {
        type: Object,
	},
	modal: {
		type: Boolean,
	},
});

const selectGroup = (group) => {
	if ( group ) props.paramGroup = group;
};

const toggleState = (group) => {
	if (!group) return;
	useForm(group).put( route('param-group.update', [group.id]) );
};
</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.parameter_groups">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.parameter_groups, route: false } ]" />
		<h2>{{ $page.props.lang.admin.parameter_groups }}</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#groupFormModal" @click.prevent.stop="selectGroup(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_female_ + $page.props.lang.admin.parameter_group_ }}</Link>
				<Link v-else :href="route('param-group.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_female_ + $page.props.lang.admin.parameter_group_ }}</Link>
			</div>
		</div>
		<div v-if="paramGroups.last_page > 1" class="row my-5">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in paramGroups.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>
						<Link :class="{ active: sort === 'id' }" :href="route('param-group.admin', { sort: 'id', order: order, page: page })">Id</Link>
						<span v-if="sort === 'id'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'name' }" :href="route('param-group.admin', { sort: 'name', order: order, page: page })">{{ $page.props.lang.admin.name }}</Link>
						<span v-if="sort === 'name'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'order' }" :href="route('param-group.admin', { sort: 'order', order: order, page: page })">{{ $page.props.lang.customer.order }}</Link>
						<span v-if="sort === 'order'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'is_enabled' }" :href="route('param-group.admin', { sort: 'is_enabled', order: order, page: page })">{{ $page.props.lang.admin.enabled }}</Link>
						<span v-if="sort === 'is_enabled'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'created_at' }" :href="route('param-group.admin', { sort: 'created_at', order: order, page: page })">{{ $page.props.lang.admin.created }}</Link>
						<span v-if="sort === 'created_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'updated_at' }" :href="route('param-group.admin', { sort: 'updated_at', order: order, page: page })">{{ $page.props.lang.admin.updated }}</Link>
						<span v-if="sort === 'updated_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="group in paramGroups.data">
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">{{ group.id }}</td>
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">
						<template v-if="modal">
							<Link data-bs-toggle="modal" data-bs-target="#groupFormModal" @click.prevent.stop="selectGroup(group)">
							{{ group.name }}
							</Link>
						</template>
						<Link v-else :href="route('param-group.edit', [group.id])" @click.prevent.stop="selectGroup(group)">
							{{ group.name }}
						</Link>
					</td>
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">{{ group.order }}</td>
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">
						<div class="d-inline-block form-check form-switch">
							<CheckInput name="is_enabled" v-model="group.is_enabled" label="Enabled" @toggleState="toggleState(group)"/>
						</div>
					</td>
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">{{ new Date(group.created_at).toLocaleString() }}</td>
					<td :class="{ 'text-body-tertiary': !group.is_enabled }">{{ new Date(group.updated_at).toLocaleString() }}</td>
				</tr>
			</tbody>
		</table>
		<div v-if="paramGroups.last_page > 1" class="row my-5">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in paramGroups.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<ParamGroupForm v-if="modal" :paramGroup="paramGroup"/>
	</Page>
</template>
