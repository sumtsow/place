<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CategoryForm from '@/Components/Forms/CategoryForm.vue';

defineProps({
	category: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Category Edit',
	},
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Categories', route: 'category.admin' }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <CategoryForm :category="category" />
            </div>
        </div>
    </Page>
</template>
