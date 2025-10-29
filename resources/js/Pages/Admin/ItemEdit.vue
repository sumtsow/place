<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import ItemForm from '@/Components/Forms/ItemForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	item: {
        type: Object,
	},
	emptyItem: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Item Edit',
	},
});

if (!props.item.id) props.item = { ...props.emptyItem };

</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase(), route: 'item.admin' }, { title: item.id ? $page.props.lang.admin.edit + $page.props.lang.admin.item.toLowerCase() + item.id : $page.props.lang.admin.add + $page.props.lang.admin.item, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <ItemForm :item="item" />
            </div>
        </div>
    </Page>
</template>
