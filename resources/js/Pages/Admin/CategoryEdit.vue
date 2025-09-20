<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CategoryForm from '@/Components/Forms/CategoryForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	category: {
        type: Object,
	},
	catList: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Category Edit',
	},
});
if (!props.category.id) props.category = {
	id: 0,
	category_id: 0,
	name: '',
	is_enabled: false,
	logo: '',
	token: props.csrf_token,
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Categories', route: 'category.admin' }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <CategoryForm :category="category" :catList="catList"/>
            </div>
        </div>
    </Page>
</template>
