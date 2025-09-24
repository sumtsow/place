<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import CheckInput from '@/Components/CheckInput.vue';
import OrderForm from '@/Components/Forms/OrderForm.vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = usePage().props;
const modal = props.modal;
const findModelById = ref(window.findModelById);

defineProps({
    title: {
        type: String,
		default: 'Manage Orders',
    },
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
	modal: {
		type: Boolean,
	},
});

const selectOrder = (ord) => {
	if (ord) {
		props.order = ord;
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
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Orders</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#orderFormModal" @click.prevent.stop="selectOrder(0)" class="btn btn-primary m-3">Add new order</Link>
				<Link v-else @click.prevent.stop="selectOrder(0)" :href="route('order.create')" class="btn btn-primary m-3">Add new Order</Link>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Id</th>
							<th>Customer</th>
							<th>Enabled</th>
							<th>Status</th>
							<th>Address</th>
							<th>Created</th>
							<th>Updated</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="order in orders">
							<td>{{ order.id }}</td>
							<td>{{ findModelById(customers, order.customer_id).name }}</td>
							<td>
								<div class="d-inline-block form-check form-switch">
								<CheckInput name="is_enabled" v-model="order.is_enabled" label="Enabled" @toggleState="toggleState(order)"/>
								</div>
							</td>
							<td>
								<template v-if="modal">
									<Link data-bs-toggle="modal" data-bs-target="#orderFormModal" @click.prevent.stop="selectOrder(order)" :class="{ 'link-secondary': !order.is_enabled }">
									{{ order.status }}
									</Link>
								</template>
								<Link v-else :href="route('order.edit', [order.id])" :class="{ 'link-secondary': !order.is_enabled }">
									{{ order.status }}
								</Link>
							</td>
							<td :class="{ 'text-body-tertiary': !order.is_enabled }">{{ order.address }}</td>
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
