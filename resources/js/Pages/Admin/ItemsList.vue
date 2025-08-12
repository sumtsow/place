<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Item from '@/Pages/Admin/Item.vue';
import ItemForm from '@/Components/Forms/ItemForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
    title: {
        type: String,
		default: 'Manage items',
    },
	items: {
        type: Object,
	},
	item: {
        type: Object,
	},
	modal: {
		type: Boolean,
	},
});

let selectItem = (item) => {
	props.item = item ? item : {};
	if (props.item) props.item.is_enabled = !!props.item.is_enabled;
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Items</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#itemFormModal" @click.prevent.stop="selectItem()" class="btn btn-primary m-3">Add new item</Link>
				<Link v-else @click.prevent.stop="selectItem()" :href="route('item.create')" class="btn btn-primary m-3">Add new item</Link>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Description</th>
					<th>Unit</th>
					<th>Enabled</th>
					<th>Category</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
			</thead>
			<tbody>
			<tr v-for="item in items">
				<td>{{ item.id }}</td>
				<td>
					<template v-if="modal">
						<Link data-bs-toggle="modal" data-bs-target="#itemFormModal" class="" @click.prevent.stop="selectItem(item)">
						{{ item.name }}
						</Link>
					</template>
					<Link v-else :href="route('item.edit', [item.id])">
						{{ item.name }}
					</Link>
				</td>
				<td>{{ item.description }}</td>
				<td>{{ item.unit.name }}</td>
				<td>{{ +item.is_enabled }}</td>
				<td>
					<template v-for="cat in item.categories">
					<p :class="{'text-secondary': ( !item.main_category[0] || cat.id !== item.main_category[0].id )}">{{ cat.name }}</p>
					</template>
				</td>
				<td>{{ new Date(item.created_at).toLocaleString() }}</td>
				<td>{{ new Date(item.updated_at).toLocaleString() }}</td>
			</tr>
			</tbody>
		</table>
		<ItemForm v-if="modal" :item="item"/>
	</Page>
</template>
