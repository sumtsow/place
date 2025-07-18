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
	},
	modal: {
		type: Boolean,
	},
});

let selectCat = (cat) => {
	props.category = cat ? cat : {};
	if (props.category) props.category.is_enabled = !!props.category.is_enabled;
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Top level categories</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#categoryFormModal" @click.prevent.stop="selectCat()" class="btn btn-primary m-3">Add new category</Link>
				<Link v-else @click.prevent.stop="selectCat()" :href="route('category.create')" class="btn btn-primary m-3">Add new category</Link>
			</div>
		</div>
		<div class="accordion" id="accordionList">
			<div v-for="cat in categories" class="accordion-item">
				<h2 class="accordion-header position-relative">
					<button class="accordion-button collapsed" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+cat.id" aria-expanded="false" :aria-controls="'collapse-'+cat.id">
					<div class="badge text-bg-primary position-absolute me-3" style="right: 3em;">
						{{ cat.subcategories.length }}
					</div>
					</button>
					<div class="z-3 position-absolute top-0 start-0 m-3 pe-5 fs-5">
						<template v-if="modal">
							<Link data-bs-toggle="modal" data-bs-target="#categoryFormModal" class="" @click.prevent.stop="selectCat(cat)">
							{{ cat.name }}
							</Link>
						</template>
						<Link v-else :href="route('category.edit', [cat.id])" class="">
							{{ cat.name }}
						</Link>
					</div>
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
