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
	title: {
		type: String,
		default: 'Parameter Edit',
	},
});

if ( !props.parameter.id ) props.parameter = {
	id: 0,
	name: '',	
	is_enabled: false,
	unit_id: 0,
	token: props.csrf_token,
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Parameters', route: 'parameter.admin' }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <ParameterForm :parameter="parameter" />
            </div>
        </div>
    </Page>
</template>