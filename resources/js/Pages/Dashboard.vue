<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />
        <div class="container mx-auto px-4 py-4">
            <PostForm />
            <PostList :posts="posts" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PostForm from "../Components/PostInput.vue";
import PostList from "../Components/PostList.vue";

defineProps({
    posts: Array,
});
</script>
