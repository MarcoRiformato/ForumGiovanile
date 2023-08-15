<template>
  <AppLayout title="Documenti">
    <div class="bg-base-200 ">
      <div class="cards-container">
        <div v-for="document in documents" :key="document.id" class="card-container">
          <div class="card w-96 bg-primary text-primary-content">
            <div class="card-body">
              <h2 class="card-title">{{ document.title }}</h2>
              <p>{{ document.description }}</p>
              <div class="card-actions justify-end">
                <a :href="document.link" class="btn">Consulta</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style>
.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(375px, 1fr));
  gap: 30px;
  padding: 30px;
  margin-right: 30px; /* Add some margin to the right */
  justify-items: center; /* Center the cards */
}

.card-container {
  margin: 30px;
}

</style>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  documents: Object
})

</script>
