<template>
    <div>
        <div
            v-for="post in posts"
            :key="post.id"
            class="p-4 mb-4 shadow rounded bg-white"
        >
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-bold">{{ post.author_name }}</p>
                    <small>Posted on: {{ post.formatted_date }}</small>
                </div>
                <div
                    v-if="$page.props.auth.user.name === post.author_name"
                    class="flex space-x-5"
                >
                    <button @click="editPost(post)">Edit</button>
                    <button @click="deletePost(post.id)">Delete</button>
                </div>
            </div>
            <p>{{ post.content }}</p>
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/core";

defineProps({
    posts: Array,
});

function deletePost(id) {
    router.post(`/posts/${id}/delete`);
}
</script>
