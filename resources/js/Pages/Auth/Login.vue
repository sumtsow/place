<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

		<div class="row justify-content-center">
			<form @submit.prevent="submit" class="col col-md-6 my-md-5">
				<div class="mb-3">
					<InputLabel for="email" value="Email" />

					<TextInput
						id="email"
						type="email"
						class="form-control"
						v-model="form.email"
						required
						autofocus
						autocomplete="username"
					/>

					<InputError class="mt-2" :message="form.errors.email" />
				</div>

				<div class="mb-3">
					<InputLabel for="password" :value="$page.props.lang.auth.password" />

					<TextInput
						id="password"
						type="password"
						class="form-control"
						v-model="form.password"
						required
						autocomplete="current-password"
					/>

					<InputError class="mb-3" :message="form.errors.password" />
				</div>

				<div class="mb-3">
					<label class="form-label">
						<Checkbox name="remember" v-model:checked="form.remember" />
						<span class="ms-2 text-sm text-gray-600"
							>{{ $page.props.lang.auth.remember_me }}</span
						>
					</label>
				</div>

				<div class="mb-3">
					<Link
						v-if="canResetPassword"
						:href="route('password.request')"
						class="float-end"
					>
						{{ $page.props.lang.auth.forgot_password }}
					</Link>

					<PrimaryButton
						class=""
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
					>
						{{ $page.props.lang.auth.login }}
					</PrimaryButton>
				</div>
			</form>
		</div>
    </GuestLayout>
</template>
