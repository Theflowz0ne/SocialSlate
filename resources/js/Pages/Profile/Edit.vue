<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile Settings" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template> -->

        <div class="py-8 container mx-auto">
            <div class="space-y-6">
                <div class="flex gap-8 justify-between max-lg:flex-col">
                    <div
                        class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                    >
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class=""
                        />
                    </div>
                    <div
                        class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                    >
                        <UpdatePasswordForm class="" />
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
