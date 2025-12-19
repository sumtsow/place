<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DistributorForm from '@/Components/Forms/DistributorForm.vue';
import LikeIcon from '@/Components/LikeIcon.vue';
import Parameter from '@/Pages/Admin/Parameter.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;
const params = new URLSearchParams( new URL( usePage().url, window.location.origin ).search );
const sort = params.get('sort') ? params.get('sort') : 'id';
const order = params.get('order') === 'desc' ? 'asc' : 'desc';
const page = params.get('page') ? params.get('page') : 1;

defineProps({
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
	<Page :title="$page.props.lang.admin.manage + $page.props.lang.admin.distributors_">
		<Breadcrumbs :links="[ { title: $page.props.lang.navbar.dashboard, route: 'dashboard' }, { title: $page.props.lang.admin.manage + $page.props.lang.admin.distributors_, route: false } ]" />
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
							<th>
								<Link :class="{ active: sort === 'id' }" :href="route('distributor.admin', { sort: 'id', order: order, page: page })">Id</Link>
								<span v-if="sort === 'id'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'name' }" :href="route('distributor.admin', { sort: 'name', order: order, page: page })">{{ $page.props.lang.admin.name }}</Link>
								<span v-if="sort === 'name'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'url' }" :href="route('distributor.admin', { sort: 'url', order: order, page: page })">URL</Link>
								<span v-if="sort === 'url'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'email' }" :href="route('distributor.admin', { sort: 'email', order: order, page: page })">Email</Link>
								<span v-if="sort === 'email'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'phone' }" :href="route('distributor.admin', { sort: 'phone', order: order, page: page })">{{ $page.props.lang.admin.phone }}</Link>
								<span v-if="sort === 'phone'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th class="text-nowrap">
								<Link :class="{ active: sort === 'items' }" :href="route('distributor.admin', { sort: 'items', order: order, page: page })">{{ $page.props.lang.admin.items }}</Link>
								<span v-if="sort === 'items'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'like' }" :href="route('distributor.admin', { sort: 'like', order: order, page: page })">{{ $page.props.lang.admin.likes }}</Link>
								<span v-if="sort === 'like'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'dislike' }" :href="route('distributor.admin', { sort: 'dislike', order: order, page: page })">{{ $page.props.lang.admin.dislikes }}</Link>
								<span v-if="sort === 'dislike'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'sales' }" :href="route('distributor.admin', { sort: 'sales', order: order, page: page })">{{ $page.props.lang.admin.sales }}</Link>
								<span v-if="sort === 'sales'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'created_at' }" :href="route('distributor.admin', { sort: 'created_at', order: order, page: page })">{{ $page.props.lang.admin.created }}</Link>
								<span v-if="sort === 'created_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
							<th>
								<Link :class="{ active: sort === 'updated_at' }" :href="route('distributor.admin', { sort: 'updated_at', order: order, page: page })">{{ $page.props.lang.admin.updated }}</Link>
								<span v-if="sort === 'updated_at'" v-html="order==='asc' ? props.arrow.down : props.arrow.up"/>
							</th>
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
								<span class="d-inline-block me-2" style="width: 20px; height: 20px;">
									<LikeIcon />
								</span>
								<span class="d-inline-block fs-6 align-middle">
									{{ distributor.like }}
								</span>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								<span class="d-inline-block me-2" style="width: 20px; height: 20px; transform: scaleY(-1);">
									<LikeIcon />
								</span>
								<span class="d-inline-block fs-6 align-middle">
									{{ distributor.dislike }}
								</span>
							</td>
							<td :class="{ 'text-body-tertiary': !distributor.is_enabled }">
								{{ +distributor.sales }}
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
