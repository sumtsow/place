<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import ParameterForm from '@/Components/Forms/ParameterForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	parameter: {
        type: Object,
	},
	groups: {
        type: Array,
    },
	units: {
        type: Array,
    },
});

</script>

<template>
	<Page :title="parameter.id ? $page.props.lang.admin.edit + $page.props.lang.admin.parameter.toLowerCase() + parameter.id : $page.props.lang.admin.add + $page.props.lang.admin.parameter.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.parameters, route: 'parameter.admin', params: [0] }, { title: parameter.id ? $page.props.lang.admin.edit + $page.props.lang.admin.parameter.toLowerCase() + parameter.id : $page.props.lang.admin.add + $page.props.lang.admin.parameter.toLowerCase(), route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <ParameterForm :parameter="parameter" />
            </div>
        </div>
    </Page>
</template>