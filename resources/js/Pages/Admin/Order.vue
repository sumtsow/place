<script setup>

import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import OrderForm from '@/Components/Forms/OrderForm.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

defineProps({
    title: {
        type: String,
		default: 'Manage distributors',
    },
	order: {
        type: Object,
	},
	customers: {
		type: Array,
	},
	statuses: {
		type: Array,
	},
	modal: {
		type: Number,
	},
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.all + $page.props.lang.admin.orders.toLowerCase(), route: 'order.admin' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.order.toLowerCase(), route: false } ]" />
		<div class="justify-content-between ms-3">
			<OrderForm :order="order" :customers="customers" :statuses="statuses" :modal="modal"/>
		</div>
	</Page>
</template>
