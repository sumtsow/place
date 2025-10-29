<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="$page.props.lang.auth.confirm_password" />

        <div class="mb-3">
            {{ $page.props.lang.auth.confirm_your_password }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" :value="$page.props.lang.auth.password" />
                <TextInput
                    id="password"
                    type="password"
                    class=""
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex justify-end">
                <PrimaryButton
                    class=""
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $page.props.lang.auth.confirm }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
