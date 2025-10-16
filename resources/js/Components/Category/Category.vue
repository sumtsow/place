<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	category: {
        type: Object,
	},
});
</script>

<template>
	<div class="row m-0 py-3">
		<div class="col-auto bg-light border border-primary-subtle rounded-4 text-center">
            
			<div class="" v-if="category.logo" style="width: 100px; height: 100px;" v-html="category.logo"></div>
			<Link :href="route('category', [category.id])" class="h5">
			{{ category.name }}
			</Link>
			<div class="" v-if="category.subcategories.length">
				<ul>
					<li v-for="subcategory in category.subcategories" class="ms-3 mt-3">
						<Link :href="route('category', [subcategory.id])">
						{{ subcategory.name }}
						</Link>
					</li>
				</ul>
				
			</div>
			<template v-else>
				<div class="row row-cols-1 row-cols-md-3 g-3 my-3">
					<div v-for="item in category.items" class="col">
						<div class="card h-100 justify-content-center">
							<img :src="JSON.parse(item.images) ? '/storage/img/' + JSON.parse(item.images)[0] : '/storage/img/no-image.png'" class="card-img-top" :alt="'image-' + item.id" style="height: 128px; width: auto; margin: 30px auto;">
							<div class="card-body">
								<h5 class="card-title">{{ item.name }}</h5>
								<p class="card-text text-truncate">
									<Link :href="route('item', [item.id])" class="stretched-link text-decoration-none link-dark">
										{{ item.description }}
									</Link>
								</p>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
	</div>
</template>
