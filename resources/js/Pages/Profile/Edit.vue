<script setup>
import Page from '@/Layouts/PageLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
	title: {
		type: String,
		default: 'Profile',
	}
});
</script>

<template>
	<Page :title="title">
		<Breadcrumbs :links="[ { title: title, route: false } ]" />
        <div class="row justify-content-center">
            <div class="col col-md-6 my-md-5">
                <div class="mb-3">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class=""
                    />
                </div>

                <div class="my-3">
                    <UpdatePasswordForm class="" />
                </div>

                <div class="my-3">
                    <DeleteUserForm class="" />
                </div>
            </div>
        </div>
    </Page>
</template>
