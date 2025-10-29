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
});
</script>

<template>
	<Page :title="(value.value ? $page.props.lang.admin.edit : $page.props.lang.admin.add) + $page.props.lang.admin.value.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.items, route: 'item.admin' }, { title: $page.props.lang.admin.item + value.item_id + ' ' + $page.props.lang.admin.parameters.toLowerCase(), route: 'item.show', param: value.item_id }, { title: (value.value ? $page.props.lang.admin.edit : $page.props.lang.admin.add) + $page.props.lang.admin.value.toLowerCase(), route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-lg-6 my-lg-5">
				<ParameterValueForm :value="value"/>
            </div>
        </div>
    </Page>
</template>
