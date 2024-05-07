<template>
    <div>
        <div
            v-for="post in posts"
            :key="post.id"
            class="p-4 mb-4 shadow rounded bg-white"
        >
            <div class="flex justify-between items-center">
                <div>
                    <Link :href="route('profile.show', { id: post.user.id })">
                        <p class="text-xs font-bold">{{ post.user.name }}</p>
                        <small>Posted on: {{ post.formatted_date }}</small>
                    </Link>
                </div>
                <div class="relative">
                    <button @click="toggleDropdown(post.id)" ref="button">
                        <img
                            class="w-5 hover:scale-110 transition-all duration-500"
                            src="/images/option.png"
                            alt="Options"
                        />
                    </button>
                    <div
                        v-if="activePost === post.id"
                        class="absolute top-10 right-0 border-[1px] bg-white p-4 rounded-md min-w-64"
                    >
                        <div
                            class="flex flex-col items-start"
                            v-if="$page.props.auth.user.name === post.user.name"
                        >
                            <div
                                class="border-b-[1px] w-full p-2 hover:bg-gray-300 cursor-pointer flex items-center space-x-2"
                                @click="enableEditing(post)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                    />
                                </svg>
                                <span> Edit </span>
                            </div>
                            <div
                                class="p-2 w-full hover:bg-gray-300 cursor-pointer flex items-center space-x-2"
                                @click="deletePost(post.id)"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-5 h-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                    />
                                </svg>
                                <span> Delete </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span
                v-if="editingPost !== post.id"
                class="whitespace-pre-wrap border-none w-full p-0"
                v-text="post.content"
                disabled
            ></span>
            <div v-if="editingPost === post.id">
                <textarea
                    ref="editInput"
                    class="rounded-lg border-[1px] p-2 whitespace-pre-wrap resize-none w-full overflow-y-hidden"
                    v-model="editableContent"
                />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    <div
                        @click="toggleLike(post)"
                        :class="[
                            'flex',
                            'items-center',
                            'space-x-1',
                            'px-3',
                            'py-1',
                            'rounded-md',
                            'cursor-pointer',
                            post.liked_by_user
                                ? 'border border-blue-400 text-blue-400 hover:bg-gray-200'
                                : 'hover:bg-gray-200',
                        ]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"
                            />
                        </svg>
                        <span>{{ post.liked_by_user ? "Liked" : "Like" }}</span>
                    </div>

                    <div>
                        <div
                            @click="toggleReshare(post)"
                            :class="[
                                'flex',
                                'items-center',
                                'space-x-1',
                                'px-3',
                                'py-1',
                                'rounded-md',
                                'cursor-pointer',
                                post.reshared_by_user
                                    ? 'text-blue-400 border border-blue-400 hover:bg-gray-200'
                                    : 'hover:bg-gray-200',
                            ]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 0 1 3.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 0 0-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 0 0-4.392-4.392 49.422 49.422 0 0 0-7.436 0A4.756 4.756 0 0 0 3.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 1 0 1.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 0 1 3.01-3.01c1.19-.09 2.392-.135 3.605-.135Zm-6.97 6.22a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 0 0 4.392 4.392 49.413 49.413 0 0 0 7.436 0 4.756 4.756 0 0 0 4.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 0 0-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 0 1-3.01 3.01 47.953 47.953 0 0 1-7.21 0 3.256 3.256 0 0 1-3.01-3.01 47.759 47.759 0 0 1-.1-1.759L6.97 15.53a.75.75 0 0 0 1.06-1.06l-3-3Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>{{
                                post.reshared_by_user ? "Reshared" : "Reshare"
                            }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button
                        v-if="editingPost === post.id"
                        class="bg-blue-200 px-3 rounded"
                        @click="saveChanges(post)"
                    >
                        Save
                    </button>
                    <div
                        class="flex space-x-1 items-center"
                        v-if="post.likes.length > 0"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-5 h-5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"
                            />
                        </svg>
                        <span>
                            {{ post.likes.length }}
                        </span>
                    </div>
                    <div
                        class="flex space-x-1 items-center"
                        v-if="post.reshares.length > 0"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-5 h-5"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 0 1 3.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 0 0-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 0 0-4.392-4.392 49.422 49.422 0 0 0-7.436 0A4.756 4.756 0 0 0 3.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 1 0 1.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 0 1 3.01-3.01c1.19-.09 2.392-.135 3.605-.135Zm-6.97 6.22a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 0 0 4.392 4.392 49.413 49.413 0 0 0 7.436 0 4.756 4.756 0 0 0 4.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 0 0-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 0 1-3.01 3.01 47.953 47.953 0 0 1-7.21 0 3.256 3.256 0 0 1-3.01-3.01 47.759 47.759 0 0 1-.1-1.759L6.97 15.53a.75.75 0 0 0 1.06-1.06l-3-3Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span>
                            {{ post.reshares.length }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// Add this inside your <script setup> block
import { Link } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import { router } from "@inertiajs/core";

defineProps({
    posts: Array,
});

const activePost = ref(null);
const editingPost = ref(null);
const editableContent = ref("");
const editInput = ref("");

function enableEditing(post) {
    editingPost.value = post.id;
    editableContent.value = post.content;
    activePost.value = null;
}

function saveChanges(post) {
    router.put(
        route("post.update", post.id),
        { content: editableContent.value },
        {
            onSuccess: () => {
                editingPost.value = null;
            },
        }
    );
}

function toggleDropdown(id) {
    activePost.value = activePost.value === id ? null : id;
}

function deletePost(id) {
    if (confirm("Are you sure you want to delete this post?")) {
        router.delete(`/posts/${id}`, {
            preserveScroll: true,
        });
    }
}

const toggleLike = async (post) => {
    try {
        if (post.liked_by_user) {
            await router.delete(`/posts/${post.id}/like`, {
                preserveScroll: true,
            });
        } else {
            await router.post(`/posts/${post.id}/like`, {
                preserveScroll: true,
            });
        }
    } catch (error) {
        console.error("Failed to toggle like:", error);
    }
};

const toggleReshare = async (post) => {
    try {
        if (post.reshared_by_user) {
            await router.delete(`/posts/${post.id}/reshare`, {
                preserveScroll: true,
            });
        } else {
            await router.post(`/posts/${post.id}/reshare`, {
                preserveScroll: true,
            });
        }
    } catch (error) {
        console.error("Failed to toggle reshare:", error);
    }
};
</script>
