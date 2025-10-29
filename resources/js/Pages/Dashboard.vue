<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
	<Page :title="$page.props.lang.navbar.dashboard">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: false } ]" />
		<h2>{{ $page.props.lang.admin.possible_operations }}</h2>
		<div class="list-group">
			<Link class="list-group-item" :href="route('category.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.categories.toLowerCase() }}</Link>
			<Link class="list-group-item" :href="route('distributor.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.distributors_ }}</Link>
			<Link class="list-group-item" :href="route('item.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.items.toLowerCase() }}</Link>
			<Link class="list-group-item" :href="route('order.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.orders.toLowerCase() }}</Link>
			<Link class="list-group-item" :href="route('unit.admin')">{{ $page.props.lang.admin.manage }}  {{ $page.props.lang.admin.measuring_units.toLowerCase() }}</Link>
			<Link class="list-group-item" :href="route('parameter.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.parameters.toLowerCase() }} </Link>
			<Link class="list-group-item" :href="route('param-group.admin')">{{ $page.props.lang.admin.manage }} {{ $page.props.lang.admin.parameter_groups.toLowerCase() }}</Link>
		</div>
	</Page>
</template>
