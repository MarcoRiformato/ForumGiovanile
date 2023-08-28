<template>
  <AppLayout title="Documenti">
    <div class="bg-base-200">
      <div class="cards-container">
        <div v-for="document in documents" :key="document.id" class="card-container">
          <div class="card w-full sm:w-96 bg-primary text-primary-content">
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
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
  margin: auto;
  justify-items: center;
}

@media (min-width: 822px) {
  .cards-container {
    gap: 8rem;
    padding-left: 2rem; /* Add this line */

  }
}

@media (min-width: 1024px) {
  .cards-container {
    gap: 8rem;
    padding-left: 4rem; /* Add this line */

  }
}

.card-container {
  padding: 0 15px;
  margin: 1rem;
}

</style>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  documents: Object
})
</script>
