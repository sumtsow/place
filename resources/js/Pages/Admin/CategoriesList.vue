<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Category from '@/Pages/Admin/Category.vue';
import CategoryForm from '@/Components/Forms/CategoryForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
    title: {
        type: String,
		default: 'Manage categories',
    },
	categories: {
        type: Object,
	},
	selectedCategory: {
        type: Object,
	},
	modal: {
		type: String,
	},
});

if (props.categories.length) {
	let cat = props.categories[0];
	let clone = JSON.parse(JSON.stringify(cat));
	props.selectedCategory = clone;
}

function selectCat(cat) {
	props.selectedCategory = cat;
	props.selectedCategory.is_enabled = !!props.selectedCategory.is_enabled;
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Top level categories</h2>
		<div class="accordion" id="accordionList">
			<div v-for="category in categories" class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+category.id" aria-expanded="false" :aria-controls="'collapse-'+category.id">
						<template v-if="modal">
							<Link data-bs-toggle="modal" data-bs-target="#categoryFormModal" class="w-100 d-flex justify-content-between" @click.prevent.stop="selectCat(category)" href="#">
							{{ category.name }}
							</Link>
						</template>
						<Link v-else :href="route('category.edit', [category.id])" class="w-100 d-flex justify-content-between">
						{{ category.name }}
						</Link>
						<div class="badge text-bg-primary float-end me-3">
							{{ category.subcategories.length }}
						</div>
					</button>
				</h2>
				<div :id="'collapse-'+category.id" class="accordion-collapse collapse" data-bs-parent="#accordionList">
					<div class="accordion-body">
						<div v-for="subcategory in category.subcategories">
							<Category :category="subcategory" :modal="parseInt(modal, 10)"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<CategoryForm v-if="modal" :category="selectedCategory" />
	</Page>
</template>
