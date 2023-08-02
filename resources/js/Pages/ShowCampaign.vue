<template>
  <div>
    <AppLayout title="Dashboard">
        <div class="bg-base-200 px-8 py-6">
          <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1 flex items-center justify-center">
              <!-- Back button -->
              <button @click="$inertia.visit(route('campaigns.index'))" class="mr-4 inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/20">
                <ArrowLeftCircleIcon  class="h-5 w-5 mr-2"/>
                Torna Indietro
              </button>
              <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">Dettaglio campagna</h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
              <a :href="route('campaigns.edit', campaign.id)" type="button" class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/20">Modifica</a>
              <button type="button" class="ml-3 inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Pubblica</button>
            </div>
          </div>
          <div class="mt-6 border-t border-white/10">
              <dl class="divide-y divide-white/10">
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium leading-6 text-white">Titolo</dt>
                  <dd class="mt-1 text-sm leading-6  sm:col-span-2 sm:mt-0">{{ campaign.title }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium leading-6 text-white">Stato</dt>
                  <dd class="mt-1 text-sm leading-6  sm:col-span-2 sm:mt-0">{{ campaign.status }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium leading-6 text-white">Data inizio</dt>
                  <dd class="mt-1 text-sm leading-6  sm:col-span-2 sm:mt-0">{{ campaign.startingDate }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium leading-6 text-white">Data fine</dt>
                  <dd class="mt-1 text-sm leading-6  sm:col-span-2 sm:mt-0">{{ campaign.endDate }}</dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                  <dt class="text-sm font-medium leading-6 text-white">Descrizione</dt>
                  <dd class="mt-1 text-sm leading-6  sm:col-span-2 sm:mt-0">{{ campaign.description }}</dd>
              </div>
              </dl>
          </div>
          </div>
    </AppLayout>
  </div>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { ArrowLeftCircleIcon } from '@heroicons/vue/24/solid';
  
  defineProps({
  campaign: Object
  })
  </script>
  