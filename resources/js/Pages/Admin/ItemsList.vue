<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Item from '@/Pages/Admin/Item.vue';
import ItemForm from '@/Components/Forms/ItemForm.vue';
import SelectList from '@/Components/SelectList.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
let category_id = route().params.category_id ? route().params.category_id : 0;
const params = new URLSearchParams( new URL( usePage().url, window.location.origin ).search );
const sort = params.get('sort') ? params.get('sort') : 'id';
const order = params.get('order') === 'desc' ? 'asc' : 'desc';
const page = params.get('page') ? params.get('page') : 1;

defineProps({
	categories: {
        type: Array,
	},
	items: {
        type: Array,
	},
	item: {
        type: Object,
	},
	emptyItem: {
        type: Object,
	},	
	modal: {
		type: Boolean,
	},
	description_rows:  {
        type: Number,
	},
	category_id:  {
        type: Number,
	},
	image_max:  {
        type: Number,
	},
});

props.emptyItem = JSON.parse( JSON.stringify( props.item ) );

const selectItem = (item) => {
	if ( !item ) {
		item = JSON.parse( JSON.stringify( props.emptyItem ) );
	};
	props.item = item;
};

const selectCategory = () => {
	if ( category_id ) useForm().get( route('item.admin', category_id) );
};
</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase(), route: false } ]" />
		<h2>{{ $page.props.lang.admin.items }}</h2>
		<div class="input-group row mb-3">
			<InputLabel for="category_id" :value="$page.props.lang.admin.category" class="col-3 text-end" />
			<SelectList
				:options="categories"
				id="category_id"
				class="col"
				v-model="category_id"
				children="itemCount"
				:defaultOption="$page.props.lang.admin.select + '...'"
				@change="selectCategory"
			/>
		</div>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#itemFormModal" @click.prevent.stop="selectItem(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.admin.item.toLowerCase() }}</Link>
				<Link v-else @click.prevent.stop="selectItem(0)" :href="route('item.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_male + $page.props.lang.admin.item.toLowerCase() }}</Link>
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
					<th>
						<Link :class="{ active: sort === 'id' }" :href="route('item.admin', { category_id: category_id, sort: 'id', order: order, page: page })">Id</Link>
						<span v-if="sort === 'id'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'name' }" :href="route('item.admin', { category_id: category_id, sort: 'name', order: order, page: page })">{{ $page.props.lang.admin.name }}</Link>
						<span v-if="sort === 'name'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'description' }" :href="route('item.admin', { category_id: category_id, sort: 'description', order: order, page: page })">{{ $page.props.lang.admin.description }}</Link>
						<span v-if="sort === 'description'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'images' }" :href="route('item.admin', { category_id: category_id, sort: 'images', order: order, page: page })">{{ $page.props.lang.admin.images }}</Link>
						<span v-if="sort === 'images'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'unit_id' }" :href="route('item.admin', { category_id: category_id, sort: 'unit_id', order: order, page: page })">{{ $page.props.lang.admin.measuring_units }}</Link>
						<span v-if="sort === 'unit_id'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'like' }" :href="route('item.admin', { category_id: category_id, sort: 'like', order: order, page: page })">{{ $page.props.lang.admin.likes }}</Link>
						<span v-if="sort === 'like'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'is_enabled' }" :href="route('item.admin', { category_id: category_id, sort: 'is_enabled', order: order, page: page })">{{ $page.props.lang.admin.enabled }}</Link>
						<span v-if="sort === 'is_enabled'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'categories' }" :href="route('item.admin', { category_id: category_id, sort: 'categories', order: order, page: page })">{{ $page.props.lang.admin.category }}</Link>
						<span v-if="sort === 'categories'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'parameters' }" :href="route('item.admin', { category_id: category_id, sort: 'parameters', order: order, page: page })">{{ $page.props.lang.admin.parameters }}</Link>
						<span v-if="sort === 'parameters'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'posts' }" :href="route('item.admin', { category_id: category_id, sort: 'posts', order: order, page: page })">{{ $page.props.lang.customer.posts }}</Link>
						<span v-if="sort === 'posts'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'created_at' }" :href="route('item.admin', { category_id: category_id, sort: 'created_at', order: order, page: page })">{{ $page.props.lang.admin.created }}</Link>
						<span v-if="sort === 'created_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
					<th>
						<Link :class="{ active: sort === 'updated_at' }" :href="route('item.admin', { category_id: category_id, sort: 'updated_at', order: order, page: page })">{{ $page.props.lang.admin.updated }}</Link>
						<span v-if="sort === 'updated_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
					</th>
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
				<td><span class="text-truncate text-wrap" :style="'display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: ' + description_rows + ';'">{{ item.description }}</span></td>
				<td>
					<template v-if="item.images">
					<p v-for="image in JSON.parse(item.images)">
						<img :src="'/storage/img/' + image" :alt="item.name" style="max-width: 100px; max-height: 100px;"/>
					</p>
					</template>
				</td>
				<td>{{ item.unit.name }}</td>
				<td>{{ item.like }}</td>
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
		<ItemForm v-if="modal" :item="props.item" :emptyItem="emptyItem" :category_id="category_id" :image_max="image_max"/>
	</Page>
</template>
