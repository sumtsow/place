<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import ItemForm from '@/Components/Forms/ItemForm.vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

defineProps({
	item: {
        type: Object,
	},
	title: {
		type: String,
		default: 'Item Edit',
	},
});
if (!props.item.id) props.item = {
	id: 0,
	name: '',	
	is_enabled: false,
	unit_id: 0,
	description: '',
	token: props.csrf_token,
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: 'Items', route: 'item.admin' }, { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <ItemForm :item="item" />
            </div>
        </div>
    </Page>
</template>
