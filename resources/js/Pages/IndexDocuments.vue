<template>
<AppLayout title="Documenti">
<div class="bg-base-200">
    <h1>Documenti del forum</h1>
    <div v-for="document in documents" :key="document.id">
        <p>{{ document }}</p>
    </div>
</div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  documents: Object
})

</script>