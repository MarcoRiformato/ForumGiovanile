<template>
    <AppLayout>
        <div class="bg-base-200">
            <h1>Admin Dashboard</h1>
            <div v-for="article in articles" :key="article.id">
                <p>{{ article.title }}</p>
                <p>{{ article.extract }}</p>
                <p>{{ article.body }}</p>
                <p>{{ article.user_id }}</p>
                <br/>
            </div>
        </div>
    </AppLayout>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  articles: Object
})
</script>