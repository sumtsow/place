<script setup>

import InputLabel from '@/Components/InputLabel.vue';
import { ref, useAttrs } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const model = defineModel({
    type: Number, Boolean,
    required: true,
});

const attrs = useAttrs();
const props = usePage().props;
const input = ref(null);

const form = useForm({
	id: 0,
	is_enabled: false,
});

defineProps({
	name: {
        type: String,
	},
	label: {
        type: String,
	},
	post: {
        type: Object,
	},
	isComment: {
        type: Boolean,
	},
});

let toggleState = (post) => {
	if (!post) return;
	form.id = post.id;
	form.is_enabled = !!post.is_enabled;
	if (post.post_id) {
		form.put( route('comment.update', [form.id]) );
	} else {
		form.put( route('post.update', [form.id]) );
	};
};
</script>

<template>
	<input type="checkbox" class="form-check-input" v-model="model" :name="name" :id="name" @change="toggleState(post)"/>
	<InputLabel class="form-check-label" :value="label" :for="name"/>
</template>
