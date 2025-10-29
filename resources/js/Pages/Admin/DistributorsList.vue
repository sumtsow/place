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

const selectDistributor = (distr) => {
	if (distr) {
		props.distributor = distr;
	};
};

</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.distributors, route: false } ]" />
		<h2>{{ $page.props.lang.admin.distributors }}</h2>
		<div class="row justify-content-end">
			<div class="col-auto">
				<Link v-if="modal" data-bs-toggle="modal" data-bs-target="#distributorFormModal" @click.prevent.stop="selectDistributor(0)" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.distributor_ }}</Link>
				<Link v-else @click.prevent.stop="selectDistributor(0)" :href="route('distributor.create')" class="btn btn-primary m-3">{{ $page.props.lang.admin.add + $page.props.lang.admin.distributor_ }}</Link>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Id</th>
							<th>{{ $page.props.lang.admin.name }}</th>
							<th>URL</th>
							<th>Email</th>
							<th>{{ $page.props.lang.admin.phone }}</th>
							<th>{{ $page.props.lang.admin.items }}</th>
							<th>{{ $page.props.lang.admin.likes }}</th>
							<th>{{ $page.props.lang.admin.dislikes }}</th>
							<th>{{ $page.props.lang.admin.sales }}</th>
							<th>{{ $page.props.lang.admin.created }}</th>
							<th>{{ $page.props.lang.admin.updated }}</th>
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
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								<Link class="btn btn-primary py-0 px-2" :href="route('distributor-item.admin', [distributor.id])">{{ distributor.distributor_items.length }}</Link>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								<span class="badge text-bg-success fs-6 fw-normal">{{ +distributor.like }}</span>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								<span class="badge text-bg-danger fs-6 fw-normal">{{ +distributor.dislike }}</span>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								<span class="badge text-bg-info fs-6 fw-normal">{{ +distributor.sales }}</span>
							</td>
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
