<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <div class="container mx-auto mt-10">
            <div class="flex flex-col items-center w-full">
                <img
                    class="w-52 rounded-full"
                    :src="
                        'https://ui-avatars.com/api/?name=' +
                        user.first_name +
                        '+' +
                        user.last_name
                    "
                />
                <h1 class="text-4xl mt-5">
                    {{ user.first_name }} {{ user.last_name }}
                </h1>
            </div>
            <div class="mt-10">
                <div v-if="$page?.props?.auth?.user?.id === user?.id">
                    <PostInput />
                </div>
                <PostList :posts="posts" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import PostList from "../../Components/PostList.vue";
import PostInput from "../../Components/PostInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    user: Object,
    posts: Array,
});
</script>
