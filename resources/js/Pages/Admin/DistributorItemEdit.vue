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
	title: {
		type: String,
		default: 'Distributor`s Item Edit',
	},
});

if (!props.currentDistributorItem.id) props.currentDistributorItem = { ...emptyDistributorItem };
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Distributors', route: 'distributor.admin' }, { title: 'Distributor`s Items', route: 'distributor-item.admin', param: currentDistributorItem.distributor_id }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <DistributorItemForm :currentDistributorItem="currentDistributorItem"/>
            </div>
        </div>
    </Page>
</template>
