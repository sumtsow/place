<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Item from '@/Pages/Admin/Item.vue';
import ItemForm from '@/Components/Forms/ItemForm.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
//import { ref } from 'vue';

const props = usePage().props;
let category_id = route().params.category_id ? route().params.category_id : 0;

defineProps({
    title: {
        type: String,
		default: 'Manage items',
    },
	categories: {
        type: Array,
	},
	items: {
        type: Array,
	},
	item: {
        type: Object,
	},
	modal: {
		type: Boolean,
	},
});

const selectItem = (item) => {
	if ( !item ) {
		item = {
			id: 0,
			name: '',
			is_enabled: false,
			unit_id: 0,
			description: '',
			images: '',
			categories: [],
		}
	};
	item.is_enabled = !!item.is_enabled;
	props.item = item;
};

const selectCategory = () => {
	if ( category_id) useForm().get( route('item.admin', category_id) );
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Items</h2>
		<div class="input-group row mb-3">
			<InputLabel for="category_id" value="Category" class="col-3 text-end" />
			<SelectList
				:options="categories"
				id="category_id"
				class="col"
				v-model="category_id"
				children="itemCount"
				defaultOption="Select..."
				@change="selectCategory"
			/>
		</div>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#itemFormModal" @click.prevent.stop="selectItem(0)" class="btn btn-primary m-3">Add new item</Link>
				<Link v-else @click.prevent.stop="selectItem(0)" :href="route('item.create')" class="btn btn-primary m-3">Add new item</Link>
			</div>
		</div>
		<div v-if="items.last_page > 1" class="row my-5">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in items.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Description</th>
					<th>Images</th>
					<th>Unit</th>
					<th>Enabled</th>
					<th>Category</th>
					<th>Parameters</th>
					<th>Posts</th>
					<th>Created</th>
					<th>Updated</th>
				</tr>
			</thead>
			<tbody>
			<tr v-for="item in items.data">
				<td>{{ item.id }}</td>
				<td>
					<template v-if="modal">
						<Link data-bs-toggle="modal" data-bs-target="#itemFormModal" @click.prevent.stop="selectItem(item)">
						{{ item.name }}
						</Link>
					</template>
					<Link v-else :href="route('item.edit', [item.id])" @click.prevent.stop="selectItem(item)">
						{{ item.name }}
					</Link>
				</td>
				<td>{{ item.description }}</td>
				<td>
					<p v-for="image in JSON.parse(item.images)">
						<img :src="'/storage/img/' + image" :alt="item.name" style="width: 100px;"/>
					</p>
				</td>
				<td>{{ item.unit.name }}</td>
				<td>{{ +item.is_enabled }}</td>
				<td>
					<template v-for="cat in item.categories">
					<p :class="{'text-secondary': ( !item.main_category[0] || cat.id !== item.main_category[0].id )}">{{ cat.name }}</p>
					</template>
				</td>
				<td>
					<Link :href="route('item.show', [item.id])" class="btn":class="{'btn-primary': item.parameters.length, 'btn-outline-primary': !item.parameters.length }">
					{{ item.parameters ? item.parameters.length : 0 }}
					</Link>
				</td>
				<td>
					<Link :href="route('post.admin', [item.id])" class="btn":class="{'btn-success': item.posts, 'btn-outline-success': !item.posts }">
					{{ item.posts ? item.posts.length : 0 }}
					</Link>
				</td>
				<td>{{ new Date(item.created_at).toLocaleString() }}</td>
				<td>{{ new Date(item.updated_at).toLocaleString() }}</td>
			</tr>
			</tbody>
		</table>
		<div v-if="items.last_page > 1" class="row my-5">
			<div class="col w-100 text-center">
				<Link v-for=" (link, index) in items.links" :key="index" :href="link.url" class="btn btn-outline-primary mx-1" :class="{ active: link.active }" v-html="link.label"/>
			</div>
		</div>
		<ItemForm v-if="modal" :item="item"/>
	</Page>
</template>
