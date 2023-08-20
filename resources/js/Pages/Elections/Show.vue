<template>
    <AppLayout>
    <div class="bg-base-200">
        <p>{{ election }}</p>
    </div>
    </AppLayout>
    </template>
    
    <script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    
    defineProps({
      election: Object
    })
    
    </script>