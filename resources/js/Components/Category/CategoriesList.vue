<script setup>
import { Link, router } from '@inertiajs/vue3';
import ItemCards from '@/Components/Category/ItemCards.vue';
import TabLabel from '@/Components/TabLabel.vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
	items: {
		type: Object,
	},
});

const openLink = (e) => {
	router.visit(e.target.href);
};
</script>

<template>
	<div class="container-fluid overflow-hidden pe-5">
		<div class="row flex-md-nowrap pb-5">
			<div class="col-12 col-md-3 mt-3" style="min-width: 320px;">
				<div class="accordion" id="accordionList">
					<template v-for="cat in categories">
					<div v-if="cat.subcategories.length" class="accordion-item">
						<div class="accordion-header">
							<button class="accordion-button collapsed p-2" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+cat.id" aria-expanded="false" :aria-controls="'collapse-'+cat.id">
							<div class="d-inline-flex w-75 pe-2" >
								<Link :href="route('category', [cat.id])" class="z-3 text-decoration-none text-truncate" @click="openLink">
									{{ cat.name }}
								</Link>
							</div>
							<div class="d-inline-flex ms-3 badge text-bg-light border border-light" style="font-size: small !important;">
								{{ cat.subcategories.length }}
							</div>
							</button>
						</div>
						<div :id="'collapse-'+cat.id" class="accordion-collapse collapse" data-bs-parent="#accordionList">
							<div class="accordion-body">
								<div v-for="subcategory in cat.subcategories" class="list-group list-group-flush">
									<Link :href="route('category', [subcategory.id])" class="text-truncate list-group-item list-group-item-action" style="font-size: small !important;">
										{{ subcategory.name }}
									</Link>
								</div>
							</div>
						</div>
					</div>
					</template>
				</div>
			</div>
			<div class="col-12 col-md-9 mt-2">
				<TabLabel :label="$page.props.lang.customer.new" />
				<ItemCards :items="items.newest"/>
				<TabLabel :label="$page.props.lang.customer.favorites" />
				<ItemCards :items="items.liked"/>
				<TabLabel :label="$page.props.lang.customer.discussed" />
				<ItemCards :items="items.discussed"/>
			</div>
		</div>
	</div>
</template>
