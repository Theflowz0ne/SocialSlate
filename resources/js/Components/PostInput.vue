<template>
    <div class="mb-4">
        <textarea
            v-model="form.content"
            placeholder="What's on your mind?"
            class="w-full rounded min-h-[100px]"
            @keydown.tab.prevent="insertTab"
        ></textarea>
        <button
            @click="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Post
        </button>
    </div>
    <!-- Display area for posts -->
    <div v-for="post in posts" :key="post.id" class="post-content">
        <div>{{ post.content }}</div>
    </div>
</template>

<style scoped>
.post-content pre {
    white-space: pre-wrap; /* preserves spaces, tabs, and line breaks */
    word-wrap: break-word; /* ensures the text breaks to prevent overflow */
}
</style>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/core";

import { defineProps } from "vue";

const props = defineProps({
    posts: Array,
});

const form = reactive({
    content: "",
});

function insertTab(event) {
    const textarea = event.target;
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;

    // Set textarea value to: text before caret + tab + text after caret
    form.content =
        textarea.value.substring(0, start) +
        "\t" +
        textarea.value.substring(end);

    // Put caret at right position again
    textarea.selectionStart = textarea.selectionEnd = start + 1;

    // Prevent the default tab behavior
    event.preventDefault();
}

function submit() {
    router.post(
        "/posts",

        form,
        {
            preserveScroll: true,
        }
    );
    form.content = ""; // Clear form after submission
}
</script>
