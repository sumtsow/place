<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import UnitForm from '@/Components/Forms/UnitForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	unit: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Unit Edit',
	},
});

if ( !props.unit.id ) props.unit = {
	id: 0,
	name: '',
	type: 0,
	is_enabled: false,
	token: props.csrf_token,
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Units', route: 'unit.admin' }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <UnitForm :unit="unit" />
            </div>
        </div>
    </Page>
</template>