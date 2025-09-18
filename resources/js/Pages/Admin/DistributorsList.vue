<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DistributorForm from '@/Components/Forms/DistributorForm.vue';
import Parameter from '@/Pages/Admin/Parameter.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;

defineProps({
    title: {
        type: String,
		default: 'Manage distributors',
    },
	distributors: {
		type: Array,
	},
	distributor: {
		type: Object,
	},
	modal: {
		type: Boolean,
	},
});

let selectDistributor = (distr) => {
	if (distr) {
		props.distributor = distr;
	};
	return true;
};
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: 'Dashboard', route: 'dashboard' }, { title: title, route: false } ]" />
		<h2>Distributors</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#distributorFormModal" @click.prevent.stop="selectDistributor(0)" class="btn btn-primary m-3">Add new distributor</Link>
				<Link v-else @click.prevent.stop="selectDistributor(0)" :href="route('distributor.create')" class="btn btn-primary m-3">Add new Distributor</Link>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>URL</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Likes</th>
							<th>Dislikes</th>
							<th>Sales</th>
							<th>Created</th>
							<th>Updated</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="distributor in distributors">
							<td>{{ distributor.id }}</td>
							<td>
								<template v-if="modal">
									<Link data-bs-toggle="modal" data-bs-target="#distributorFormModal" @click.prevent.stop="selectDistributor(distributor)" :class="{ 'link-secondary': !distributor.is_enabled }">
									{{ distributor.name }}
									</Link>
								</template>
								<Link v-else :href="route('distributor.edit', [distributor.id])" :class="{ 'link-secondary': !distributor.is_enabled }">
									{{ distributor.name }}
								</Link>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ distributor.url }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ distributor.email }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ distributor.phone }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ +distributor.like }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ +distributor.dislike }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ +distributor.sales }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ new Date(distributor.created_at).toLocaleString() }}</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">{{ new Date(distributor.updated_at).toLocaleString() }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<DistributorForm v-if="modal" :distributor="distributor" :modal="modal"/>
	</Page>
</template>
