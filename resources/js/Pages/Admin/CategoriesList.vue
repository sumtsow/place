<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
defineProps({
    title: {
        type: String,
		default: 'Manage categories',
    },
	categories: {
        type: Object,
	},
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<template v-for="category in categories">
		<div class="row">
			<div class="col">
				<h2 class="h4" >
					<Link :href="route('categoryShow', [category.id])">
					{{ category.name }}
					</Link>
				</h2>
			</div>
		</div>
	</template>
	</Page>
</template>
