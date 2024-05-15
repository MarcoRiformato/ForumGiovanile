<template>
<AppLayout title="LavorElba">
<div class="flex justify-end items-center w-full py-4 pb-6">
  <div class="relative rounded-full px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
    Sei un azienda? <a @click="$inertia.visit(route('workers.index'))" class="font-semibold text-secondary"><span class="absolute inset-0" aria-hidden="true" />Trova dipendenti<span aria-hidden="true">&rarr;</span></a>
  </div>
</div>

<ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
  <li v-for="job in jobs" :key="job.id" class="overflow-hidden rounded-xl border border-gray-200" @click="$inertia.visit(route('jobs.show', job.id))">
    <div class="flex items-center gap-x-4 border-b border-gray-900/5 p-6 mb-4">
      <img :src="job.imageUrl" :alt="job.lavoro" class="h-12 w-12 flex-none rounded-lg object-cover ring-1 ring-gray-900/10" />
      <div class="text-sm font-medium leading-6">{{ job.lavoro }}</div>
    </div>
    <dl class="-mt-8 px-6 py-4 text-sm leading-6">
      <div class="flex justify-between py-1">
        <p>📍 {{ job.luogo }}</p>
      </div>
      <div class="flex justify-between py-1">
        <p>💼 {{ job.azienda }}</p>
      </div>
      <div class="flex justify-between py-1 divide-y">
        <p>💶 € {{ job.stipendio }}</p>
      </div>
      <p class="pt-4 pb-6">{{ job.descrizione }}</p>
      <div class="flex justify-between items-center">
        <button class="btn btn-primary btn-sm">Candidati</button>
        <p class="text-gray-500">Pubblicato<br/> 3 giorni fa</p>
      </div>
    </dl>
  </li>
</ul>

</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  jobs: Object
})

</script>

<style>
  @media (max-width: 800px) {
    #tr-1 {
      position: relative !important;
    }
    #td-1 {
      padding-top: 13px !important;
    }
    #td-2 {
      padding-left: 0.5em !important;
    }
  }
  @media (max-width: 600px) {
    #td-1 {
      padding: 3.5px !important;
    }
    #img-1 {
      width: 40px !important; height: 40px !important;
    }
    #td-2 {
      padding: 3.5px !important;
    }
    #td-3 {
      display: none !important; padding: 3.5px !important;
    }
    #td-4 {
      padding: 3.5px !important;
    }
    #td-5 {
      padding: 3.5px !important;
    }
  }
  @media (max-width: 1000px) {
    #td-1 {
      padding-top: 7px !important;
    }
    #td-5 {
      display: none !important;
    }
  }
  @media (max-width: 700px) {
    #td-3 {
      display: none !important;
    }
  }
  @media (max-width: 500px) {
    #td-5 {
      width: auto !important; display: none !important;
    }
  }
</style>