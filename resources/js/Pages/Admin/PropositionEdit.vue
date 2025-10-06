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
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Orders', route: 'order.admin' }, { title: 'Propositions', route: 'proposition.admin', param: currentProposition.order_id }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
                <PropositionForm :currentProposition="currentProposition" :distributors="distributors"/>
            </div>
        </div>
    </Page>
</template>
