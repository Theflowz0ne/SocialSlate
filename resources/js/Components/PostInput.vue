<template>
    <div class="mb-4">
        <textarea
            v-model="form.content"
            placeholder="What's on your mind?"
            class="w-full rounded min-h-[100px]"
        ></textarea>
        <button
            @click="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
            Post
        </button>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/core";

const form = reactive({
    content: "",
});

function submit() {
    router.post("/posts", form);
    form.content = ""; // Clear form after submission
}
</script>
