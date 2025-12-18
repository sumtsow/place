<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import OrderForm from '@/Components/Forms/OrderForm.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;
const emptyOrder = {...props.order};
const url = new URL(usePage().url, window.location.origin);
const params = new URLSearchParams(url.search);
const sort = params.get('sort') ? params.get('sort') : 'id';
const sortOrder = params.get('sortorder') === 'desc' ? 'asc' : 'desc';

defineProps({
	orders: {
		type: Array,
	},
	order: {
		type: Object,
	},
	customers: {
		type: Array,
	},
	statuses: {
		type: Array,
	},
});

const selectOrder = (ord) => {
	if (ord) {
		props.order = ord;
	} else {
		props.order = emptyOrder;
	};
};

const toggleState = (order) => {
	if (!order) return;
	useForm({
		id: order.id,
		customer_id: order.customer_id,
		address: order.address,
		status: order.status,
		is_enabled: !!order.is_enabled,
	}).put( route('order.update', [order.id])) ;
};

</script>

<template>
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.order.toLowerCase()">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.order.toLowerCase(), route: false } ]" />
		<h2>{{ $page.props.lang.admin.orders }}</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#orderFormModal" @click.prevent.stop="selectOrder(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_neuter + $page.props.lang.admin.order.toLowerCase() }}</Link>
				<Link v-else @click.prevent.stop="selectOrder(0)" :href="route('order.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.new_neuter + $page.props.lang.admin.order.toLowerCase() }}</Link>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>
								<Link :class="{ active: sort === 'id' }" :href="route('order.admin', { sort: 'id', sortorder: sortOrder, page: orders.current_page })">Id</Link>
								<span v-if="sort === 'id'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'customer_id' }" :href="route('order.admin', { sort: 'customer_id', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.name }}</Link>
								<span v-if="sort === 'customer_id'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'is_enabled' }" :href="route('order.admin', { sort: 'is_enabled', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.enabled }}</Link>
								<span v-if="sort === 'is_enabled'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'status' }" :href="route('order.admin', { sort: 'status', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.status }}</Link>
								<span v-if="sort === 'status'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								{{ $page.props.lang.admin.total }}
							</th>
							<th>
								{{ $page.props.lang.admin.propositions }}
							</th>
							<th>
								<Link :class="{ active: sort === 'address' }" :href="route('order.admin', { sort: 'address', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.auth.address }}</Link>
								<span v-if="sort === 'address'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'expired' }" :href="route('order.admin', { sort: 'expired', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.expired }}</Link>
								<span v-if="sort === 'expired'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'created_at' }" :href="route('order.admin', { sort: 'created_at', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.created }}</Link>
								<span v-if="sort === 'created_at'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'updated_at' }" :href="route('order.admin', { sort: 'updated_at', sortorder: sortOrder, page: orders.current_page })">{{ $page.props.lang.admin.updated }}</Link>
								<span v-if="sort === 'updated_at'" v-html="sortOrder==='asc' ? '&darr;' : '&uarr;'"/>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="order in orders">
							<td>{{ order.id }}</td>
							<td>{{ order.customer.user.lastname }} {{ order.customer.user.firstname }}</td>
							<td>
								<div class="d-inline-block form-check form-switch">
								<CheckInput name="is_enabled" v-model="order.is_enabled" label="Enabled" @toggleState="toggleState(order)"/>
								</div>
							</td>
							<td>
								<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#orderFormModal" @click.prevent.stop="selectOrder(order)" :class="{ 'link-secondary': !order.is_enabled }">
								{{ order.status }}
								</Link>
								<Link v-else :href="route('order.edit', [order.id])" :class="{ 'link-secondary': !order.is_enabled }">
									{{ order.status }}
								</Link>
							</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">{{ order.totalPrice.toFixed(2) }} {{ $page.props.lang.customer.currency }}</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">
								<Link class="btn btn-primary py-0 px-2" :href="route('proposition.admin', [order.id])">{{ order.propositions.length }}</Link>
							</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">{{ order.address }}</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled, 'text-danger': order.is_enabled && ( new Date(order.expired) < new Date() ) }">{{ order.expired ? new Date(order.expired).toLocaleString() : null }}</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">{{ new Date(order.created_at).toLocaleString() }}</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">{{ new Date(order.updated_at).toLocaleString() }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<OrderForm v-if="modal" :order="order" :customers="customers" :statuses="statuses" :modal="modal"/>
	</Page>
</template>
