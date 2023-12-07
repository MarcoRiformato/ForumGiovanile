<template>
    <AppLayout title="Grazie">
        <div class="bg-base-200">
            <p>Grazie per aver votato!</p>
        </div>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { onMounted } from 'vue';

onMounted(() => {
  window.history.pushState(null, null, window.location.href);
  window.addEventListener('popstate', onBackButtonEvent);
});

function onBackButtonEvent(e) {
  e.preventDefault();
  window.location.href = '/elections.thanks';
}

</script>