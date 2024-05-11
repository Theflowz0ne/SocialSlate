<template>
    <div class="mb-4 flex">
        <textarea
            v-model="form.content"
            placeholder="What's on your mind?"
            class="w-full rounded-l-lg min-h-[100px] shadow border-white box-border focus:border-none focus:border-inline"
            @keydown.tab.prevent="insertTab"
        ></textarea>
        <button
            @click="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r-lg"
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
    white-space: pre-wrap;
    word-wrap: break-word;
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
    form.content =
        textarea.value.substring(0, start) +
        "\t" +
        textarea.value.substring(end);

    textarea.selectionStart = textarea.selectionEnd = start + 1;

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
    form.content = "";
}
</script>
