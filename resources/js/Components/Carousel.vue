<script setup>

defineProps({
	images: {
        type: Array,
	},
});
</script>

<template>
	<div id="imageCarousel" class="carousel slide carousel-dark">
		<div class="carousel-indicators mb-0">
			<button v-for="image, key in images" type="button" data-bs-target="#imageCarousel" :data-bs-slide-to="key" :class="{ active: key == 0 }" :aria-current="!key" :aria-label="'Slide ' + ++key"></button>
		</div>
		<div class="carousel-inner">
			<div v-for="image, key in images" class="carousel-item" :class="{ active: key == 0 }">
				<img :src="'/storage/img/' + image" :alt="'image-' + key" class="d-block" style="height: 256px; width: auto; margin: 30px auto;">
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</template>
