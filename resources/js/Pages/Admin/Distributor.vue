<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DistributorForm from '@/Components/Forms/DistributorForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

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
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.distributors, route: 'distributor.admin' }, { title: distributor.id ? $page.props.lang.admin.edit + $page.props.lang.admin.distributor_ + distributor.id : $page.props.lang.admin.add + $page.props.lang.admin.distributor_, route: false } ]" />
		<div class="justify-content-between ms-3">
			<DistributorForm :distributor="distributor" :modal="modal" />
		</div>
	</Page>
</template>
