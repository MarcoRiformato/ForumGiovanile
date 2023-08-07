<template>
    <AppLayout>
        <div class="bg-base-200">
          <p>{{ article }}</p>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  article: Object
  })

</script>