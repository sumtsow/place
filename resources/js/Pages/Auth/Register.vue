<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    firstname: '',
	patronymic: '',
	lastname: '',
	address: '',
	birthdate: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
		<div class="row justify-content-center">
			<form @submit.prevent="submit" class="col col-md-6 my-md-5">
				<div class="mb-3">
					<InputLabel class="form-label" for="firstname" value="First Name" />

					<TextInput
						id="firstname"
						type="text"
						class="form-control"
						v-model="form.firstname"
						required
						autofocus
						autocomplete="firstname"
					/>

					<InputError class="mt-2" :message="form.errors.firstname" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="patronymic" value="Patronymic" />

					<TextInput
						id="patronymic"
						type="text"
						class="form-control"
						v-model="form.patronymic"
						autofocus
						autocomplete="patronymic"
					/>

					<InputError class="mt-2" :message="form.errors.patronymic" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="lastname" value="Last Name" />

					<TextInput
						id="lastname"
						type="text"
						class="form-control"
						v-model="form.lastname"
						autofocus
						autocomplete="lastname"
					/>

					<InputError class="mt-2" :message="form.errors.lastname" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="address" value="Address" />

					<TextInput
						id="address"
						type="text"
						class="form-control"
						v-model="form.address"
						autofocus
						autocomplete="address"
					/>

					<InputError class="mt-2" :message="form.errors.address" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="birthdate" value="Birth Date" />

					<TextInput
						id="birthdate"
						type="date"
						class="form-control"
						v-model="form.birthdate"
						autofocus
						autocomplete="birthdate"
					/>

					<InputError class="mt-2" :message="form.errors.birthdate" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="email" value="Email" />

					<TextInput
						id="email"
						type="email"
						class="form-control"
						v-model="form.email"
						required
						autocomplete="username"
					/>

					<InputError class="mt-2" :message="form.errors.email" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="password" value="Password" />

					<TextInput
						id="password"
						type="password"
						class="form-control"
						v-model="form.password"
						required
						autocomplete="new-password"
					/>

					<InputError class="mt-2" :message="form.errors.password" />
				</div>

				<div class="mb-3">
					<InputLabel class="form-label" for="password_confirmation" value="Confirm Password" />

					<TextInput
						id="password_confirmation"
						type="password"
						class="form-control"
						v-model="form.password_confirmation"
						required
						autocomplete="new-password"
					/>

					<InputError
						class="mt-2"
						:message="form.errors.password_confirmation"
					/>
				</div>

				<div class="">
					<Link
						:href="route('login')"
						class="float-end"
					>
						Already registered?
					</Link>

					<PrimaryButton
						class=""
						:class="{ 'opacity-25': form.processing }"
						:disabled="form.processing"
					>
						Register
					</PrimaryButton>
				</div>
			</form>
		</div>
    </GuestLayout>
</template>
