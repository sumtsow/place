<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="">
				{{ $page.props.lang.auth.delete_account }}
            </h2>

            <p class="mb-3">
                {{ $page.props.lang.auth.delete_account_warning }}
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">{{ $page.props.lang.auth.delete_account }}</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal" class="bg-white">
            <div class="bg-white">
                <h2 class="" >
					{{ $page.props.lang.auth.delete_account_request }} 
                </h2>

                <p class="">
                    {{ $page.props.lang.auth.delete_account_confirm }} 
                </p>

                <div class="mb-3">
                    <InputLabel
                        for="password"
                        :value="$page.props.lang.auth.password"
                        class=""
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class=""
                        :placeholder="$page.props.lang.auth.password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mb-3">
                    <SecondaryButton @click="closeModal">
                        {{ $page.props.lang.customer.cancel }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        {{ $page.props.lang.auth.delete_account }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
