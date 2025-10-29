<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DistributorItemForm from '@/Components/Forms/DistributorItemForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	currentDistributorItem: {
        type: Object,
	},
	emptyDistributorItem: {
        type: Object,
	},
});

if (!props.currentDistributorItem.id) props.currentDistributorItem = { ...emptyDistributorItem };
</script>

<template>
	<Page :title="currentDistributorItem.id ? $page.props.lang.admin.edit + $page.props.lang.admin.distributor_ + $page.props.lang.admin.item_ + currentDistributorItem.id : $page.props.lang.admin.add + $page.props.lang.admin.distributor_ + $page.props.lang.admin.item_">
		<Breadcrumbs :links="[
		{ title: $page.props.lang.navbar.dashboard, route: 'dashboard' },
		{ title: $page.props.lang.admin.distributors, route: 'distributor.admin' },
		{ title: $page.props.lang.admin.distributors + $page.props.lang.admin.items, route: 'distributor-item.admin', param: currentDistributorItem.distributor_id },
		{ title: currentDistributorItem.id ? $page.props.lang.admin.edit + $page.props.lang.admin.distributor_ + $page.props.lang.admin.item_ + currentDistributorItem.id : $page.props.lang.admin.add + $page.props.lang.admin.distributor_ + $page.props.lang.admin.item_, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <DistributorItemForm :currentDistributorItem="currentDistributorItem"/>
            </div>
        </div>
    </Page>
</template>
