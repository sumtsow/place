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
	<Page :title="category.id ? $page.props.lang.admin.edit + $page.props.lang.admin.category_ + category.id : $page.props.lang.admin.add + $page.props.lang.admin.category_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.categories.toLowerCase(), route: 'category.admin' }, { title: category.id ? $page.props.lang.admin.edit + $page.props.lang.admin.category_ + category.id : $page.props.lang.admin.add + $page.props.lang.admin.category_, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <CategoryForm :category="category" :catList="catList"/>
            </div>
        </div>
    </Page>
</template>
