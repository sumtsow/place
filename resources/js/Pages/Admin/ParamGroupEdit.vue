<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import ParamGroupForm from '@/Components/Forms/ParamGroupForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	paramGroup: {
        type: Object,
	},
	emptyGroup: {
        type: Object,
	},
});

</script>

<template>
	<Page :title="paramGroup.id ? $page.props.lang.admin.edit + $page.props.lang.admin.parameter_group_ + paramGroup.id : $page.props.lang.admin.add + $page.props.lang.admin.parameter_group_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.parameter_groups, route: 'param-group.admin' }, { title: paramGroup.id ? $page.props.lang.admin.edit + $page.props.lang.admin.parameter_group_ + paramGroup.id : $page.props.lang.admin.add + $page.props.lang.admin.parameter_group_, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <ParamGroupForm :paramGroup="paramGroup" />
            </div>
        </div>
    </Page>
</template>