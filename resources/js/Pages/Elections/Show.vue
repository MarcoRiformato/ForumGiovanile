<template>
  <AppLayout>
    <div class="bg-base-200">
      <p class="text-xl pb-4">Election Details</p>
      <p><strong>Name:</strong> {{ election.name }}</p>
      <p><strong>Description:</strong> {{ election.description }}</p>
      <p><strong>Start Date:</strong> {{ election.start_date }}</p>
      <p><strong>End Date:</strong> {{ election.end_date }}</p>
      <p class="pb-4"><strong>Status:</strong> {{ election.status }}</p>

      <div v-for="question in election.questions" :key="question.id">
        <h2 class="text-lg pb-2">{{ question.text }}</h2>
        <div v-if="question.type === 'options'">
          <h3 class="text-md pb-2">Options:</h3>
          <ul>
            <li v-for="option in question.options" :key="option.id">{{ option.text }}</li>
          </ul>
        </div>
        <div v-if="question.type === 'candidates'">
          <h3 class="text-md pb-2">Candidates:</h3>
          <ul>
            <li v-for="candidate in question.candidates" :key="candidate.id">
              {{ candidate.name }} - {{ candidate.description }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  election: Object
})
</script>
