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
	category_id: {
        type: Number,
	},
	image_max: {
        type: Number,
	},
});

if (!props.item.id) props.item = JSON.parse( JSON.stringify( props.emptyItem ) );

</script>

<template>
	<Page :title="item.id ? $page.props.lang.admin.edit + $page.props.lang.admin.item.toLowerCase() + item.id : $page.props.lang.admin.add + $page.props.lang.admin.item.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.items.toLowerCase(), route: 'item.admin' }, { title: item.id ? $page.props.lang.admin.edit + $page.props.lang.admin.item.toLowerCase() + item.id : $page.props.lang.admin.add + $page.props.lang.admin.item.toLowerCase(), route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <ItemForm :item="item" :emptyItem="emptyItem" :category_id="0" :image_max="image_max" />
            </div>
        </div>
    </Page>
</template>
