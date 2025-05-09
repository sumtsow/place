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
	category: {
        type: Object,
		default: {
			id: 0,
			category_id: 0,
			name: '',
			is_enabled: false,
			logo: '',
		},
	},
	modal: {
		type: Boolean,
	},
});

let selectCat = (cat) => {
	props.category = cat;
	props.category.is_enabled = !!props.category.is_enabled;
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Top level categories</h2>
		<div class="accordion" id="accordionList">
			<div v-for="cat in categories" class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+cat.id" aria-expanded="false" :aria-controls="'collapse-'+cat.id">
						<template v-if="modal">
							<Link data-bs-toggle="modal" data-bs-target="#categoryFormModal" class="w-100 justify-content-between" @click.prevent.stop="selectCat(cat)" :href="route('category', [cat.id])">
							{{ cat.name }}
							</Link>
						</template>
						<Link v-else :href="route('category.edit', [cat.id])" class="w-100 d-flex justify-content-between">
							{{ cat.name }}
						</Link>
						<div class="badge text-bg-primary float-end me-3">
							{{ cat.subcategories.length }}
						</div>
					</button>
				</h2>
				<div :id="'collapse-'+cat.id" class="accordion-collapse collapse" data-bs-parent="#accordionList">
					<div class="accordion-body">
						<div v-for="subcategory in cat.subcategories">
							<Category :category="subcategory" :modal="modal"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<CategoryForm v-if="modal" :category="category"/>
	</Page>
</template>
