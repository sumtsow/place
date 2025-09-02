<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import ParameterValueForm from '@/Components/Forms/ParameterValueForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	value: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Value edit',
	},
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Items', route: 'item.admin' }, { title: ('Item ' + value.item_id + ' params'), route: 'item.show', param: value.parameter_id }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
				<ParameterValueForm :value="value"/>
            </div>
        </div>
    </Page>
</template>
