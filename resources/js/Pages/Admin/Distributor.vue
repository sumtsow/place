<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DistributorForm from '@/Components/Forms/DistributorForm.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, useAttrs } from 'vue';

const props = usePage().props;
const modal = props.modal;

defineProps({
    title: {
        type: String,
		default: 'Manage distributors',
    },
	distributor: {
        type: Object,
	},
	modal: {
		type: Number,
	},
});

let selectDistributor = (distr) => {
	if (distr) {
		props.distributor = distr;
	};
	return true;
};

/*onMounted(() => {
	if(!modal) selectDistributor(props.distributor);
});*/
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Distributors', route: 'distributor.admin' }, { title: title, route: false } ]" />
		<div class="justify-content-between ms-3">
			<DistributorForm :distributor="distributor" :modal="modal" />
		</div>
	</Page>
</template>
