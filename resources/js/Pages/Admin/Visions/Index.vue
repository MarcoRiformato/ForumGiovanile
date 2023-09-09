<template>
    <AppLayout>
      <div class="bg-base-200">
        <div class="flex justify-between items-center p-4">
          <h1 class="text-4xl">Lista visioni</h1>
          <button
          @click="$inertia.visit(route('admin.visions.create'))"
          class="btn btn-primary" disabled>Crea nuova visione</button>
        </div>
        <div class="cards-container">
          <div v-for="vision in visions" :key="vision.id" class="card-container mb-4">
            <div class="card w-full sm:w-96 bg-primary text-primary-content">
              <div class="card-body">
                <component :is="vision.icon" class="icon"></component>
                <h2 class="card-title">{{ vision.title }}</h2>
                <p>{{ vision.desc }}</p>
                <div class="card-actions justify-end">
                  <button
                  @click="$inertia.visit(route('admin.visions.edit', vision.id))"
                  class="btn btn-secondary">Modifica</button>
                  <button class="btn btn-error">Cancella</button> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>
  
  
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    visions: Object
})
</script>