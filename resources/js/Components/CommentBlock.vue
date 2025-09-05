<script setup>

import { useAttrs } from 'vue';

const comment = useAttrs().comment;
const pid = useAttrs().post;

</script>

<template>
	<div class="card m-3 p-0" :class="{'ms-0': pid == comment.user_id, 'me-0 bg-light': pid != comment.user_id}">
		<div class="card-header">
			{{ comment.user.firstname }} {{ comment.user.lastname }} | {{ new Date(comment.created_at).toLocaleString() }}
		</div>
		<h5 class="card-title m-3">Comment {{ comment.id }}</h5>
		<p class="card-text m-3">{{ comment.text }}</p>
	</div>
</template>
