<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
	firstname: user.firstname,
	patronymic: user.patronymic,
	lastname: user.lastname,
	address: user.address,
	birthdate: user.birthdate,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="">
                Profile Information
            </h2>

            <p class="">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class=""
        >
			<div>
			Roles:
			<ul>
				<li v-for="role in user.roles">{{ role.id }}: {{ role.name }}</li>
			</ul>
			</div>
            <div>
                <InputLabel for="firstname" value="First Name" />

                <TextInput
                    id="firstname"
                    type="text"
                    class="mb-3"
                    v-model="form.firstname"
                    required
                    autofocus
                    autocomplete="firstname"
                />

                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>

            <div>
                <InputLabel for="patronymic" value="Patronymic" />

                <TextInput
                    id="patronymic"
                    type="text"
                    class="mb-3"
                    v-model="form.patronymic"
                    autofocus
                    autocomplete="patronymic"
                />

                <InputError class="mt-2" :message="form.errors.patronymic" />
            </div>

            <div>
                <InputLabel for="lastname" value="Last Name" />

                <TextInput
                    id="lastname"
                    type="text"
                    class="mb-3"
                    v-model="form.lastname"
                    autofocus
                    autocomplete="lastname"
                />

                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />

                <TextInput
                    id="address"
                    type="text"
                    class="mb-3"
                    v-model="form.address"
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="birthdate" value="Birth Date" />

                <TextInput
                    id="birthdate"
                    type="date"
                    class="mb-3"
                    v-model="form.birthdate"
                    autofocus
                    autocomplete="birthdate"
                />

                <InputError class="mt-2" :message="form.errors.birthdate" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mb-3"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class=""
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
