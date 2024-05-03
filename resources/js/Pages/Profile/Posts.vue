<template>
    <div>
        <h1>User Posts</h1>
        <div v-for="post in posts" :key="post.id" class="post">
            <h2>{{ post.title }}</h2>
            <p>{{ post.content }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        posts: Array,
    },
};
</script>

<style>
.post {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
}
</style>
