<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import PropositionForm from '@/Components/Forms/PropositionForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	currentProposition: {
        type: Object,
	},
	distributors: {
        type: Array,
	},
	emptyProposition: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Proposition Edit',
	},
});

if (!props.currentProposition.id) props.currentProposition = { ...emptyProposition };
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.orders, route: 'order.admin' }, { title: $page.props.lang.admin.propositions, route: 'proposition.admin', param: currentProposition.order_id }, { title: $page.props.lang.admin.edit + $page.props.lang.admin.proposition_, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <PropositionForm :currentProposition="currentProposition" :distributors="distributors"/>
            </div>
        </div>
    </Page>
</template>
