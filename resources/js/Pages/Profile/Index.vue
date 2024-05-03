<template>
    <AuthenticatedLayout>
        <Head title="Profile" />
        <div class="container mx-auto">
            <h1>{{ user.name }}</h1>
            <h2>Posts:</h2>
            <PostList :posts="posts" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import PostList from "../../Components/PostList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    user: Object,
    posts: Array,
});
</script>
