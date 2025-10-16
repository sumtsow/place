<script setup>
import { Link } from '@inertiajs/vue3';
import CategoryCards from '@/Components/Category/CategoryCards.vue';

defineProps({
    categories: {
        type: Array,
        required: true,
    },
	items: {
		type: Object,
	},
});
</script>

<template>
	<div class="container-fluid overflow-hidden">
		<div class="row flex-nowrap pb-5">
			<div class="col-12 col-md-3 mt-3" style="min-width: 320px;">
				<div class="accordion" id="accordionList">
					<template v-for="cat in categories">
					<div v-if="cat.subcategories.length" class="accordion-item">
						<div class="accordion-header">
							<button class="accordion-button collapsed p-2" data-bs-toggle="collapse" :data-bs-target="'#collapse-'+cat.id" aria-expanded="false" :aria-controls="'collapse-'+cat.id">
							<div class="d-inline-flex w-75 pe-2" >
								<Link :href="route('category', [cat.id])" class="text-decoration-none text-truncate" @click.stop="">
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
			<div class="col mt-3">
				<h4 class="mb-3">New</h4>
				<CategoryCards :items="items.newest"/>
				<h4 class="my-3">Liked</h4>
				<CategoryCards :items="items.liked"/>
				<h4 class="my-3">Discussed</h4>
				<CategoryCards :items="items.discussed"/>
			</div>
		</div>
	</div>
</template>
