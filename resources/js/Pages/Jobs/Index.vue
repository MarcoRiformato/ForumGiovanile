<template>
<AppLayout title="ElbaJobz">
  <div class="flex justify-end items-center w-full py-4 pb-6">
    <div class="relative rounded-full px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
      Sei un azienda? <a @click="$inertia.visit(route('workers.index'))" class="font-semibold text-secondary"><span class="absolute inset-0" aria-hidden="true" />Trova collaboratori<span aria-hidden="true">&rarr;</span></a>
    </div>
  </div>
  <Banner 
    message="La piattaforma lavoro del Forum Giovanile dell'Elba nasce per aiutare la conoscenza reciproca di domanda/offerta nel mondo del lavoro ma soprattutto per far si che ciò avvenga nel rispetto dei principi di: trasparenza legalità rispetto dei diritti dei lavoratori reciproca buona fede che tutti gli utenti,aziende e lavoratori, si impegnano a rispettare - Il Forum Giovanile dell'Elba"
    class="m-4 rounded-xl"
  />
  
  <div role="tablist" class="tabs tabs-boxed mb-6">
    <a role="tab" 
       class="tab" 
       :class="{ 'tab-active': activeTab === 'all' }"
       @click="activeTab = 'all'">
      Tutti
    </a>
    <a role="tab" 
       class="tab" 
       :class="{ 'tab-active': activeTab === 'jobs' }"
       @click="activeTab = 'jobs'">
      Offerte di lavoro
    </a>
    <a role="tab" 
       class="tab" 
       :class="{ 'tab-active': activeTab === 'courses' }"
       @click="activeTab = 'courses'">
      Corsi formativi
    </a>
  </div>
  
  <div v-if="filteredJobs.length === 0" class="text-center py-8">
    <p class="text-xl text-gray-600">Al momento non ci sono offerte disponibili, riprova più tardi 😕</p>
  </div>

  <ul v-else role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
    <li v-for="job in filteredJobs" 
        :key="job.id" 
        :class="[
          'overflow-hidden rounded-xl border cursor-pointer transition-all duration-300', 
          job.isCorso ? 'border-secondary bg-secondary/10' : 'border-primary bg-primary/10',
          { 'lg:col-span-3': expandedCard === job.id }
        ]"
        @click="toggleCard(job.id)">
      <div class="flex" :class="{ 'flex-col lg:flex-row': expandedCard === job.id }">
        <!-- Basic Card Info -->
        <div class="flex-1">
          <div class="flex items-center gap-x-4 border-b border-gray-900/5 p-6 mb-4">
            <div class="text-sm font-medium leading-6">
              {{ job.isCorso ? '📚 ' : '💼 ' }}{{ job.lavoro }}
            </div>
          </div>
          <dl class="-mt-8 px-6 py-4 text-sm leading-6">
            <div class="flex justify-between py-1">
              <p>📍 {{ job.luogo }}</p>
            </div>
            <div class="flex justify-between py-1">
              <p>{{ job.isCorso ? '🏫' : '💼' }} {{ job.azienda }}</p>
            </div>
            <div class="flex justify-between py-1 divide-y">
              <p>{{ job.isCorso ? '🆓' : '💶' }} {{ job.stipendio }}</p>
            </div>
            <p class="pt-4 pb-6" :class="{ 'line-clamp-3': expandedCard !== job.id }">
              {{ job.descrizione }}
            </p>
            <div class="flex justify-between items-center">
              <button @click.stop="openWhatsApp(job)" 
                :class="['btn btn-sm', job.isCorso ? 'btn-secondary' : 'btn-primary']">
                {{ job.isCorso ? 'Iscriviti' : 'Candidati' }}
              </button>
              <!--<p class="text-gray-500">Nuovo! <br/> 🆕</p>-->
            </div>
          </dl>
        </div>

        <!-- Extended Info (shown when expanded) 
        <div v-if="expandedCard === job.id" 
             class="flex-1 p-6 border-t lg:border-l lg:border-t-0">
          <div class="space-y-4">
            <div>
              <h4 class="font-semibold" :class="job.isCorso ? 'text-secondary' : 'text-primary'">
                Descrizione completa
              </h4>
              <p>{{ job.descrizione }}</p>
            </div>
          </div>
        </div>-->
      </div>
    </li>
  </ul>

</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Banner from '@/Components/Banner.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  jobs: Object
});

const activeTab = ref('all');
const expandedCard = ref(null);

const toggleCard = (jobId) => {
  expandedCard.value = expandedCard.value === jobId ? null : jobId;
};

const filteredJobs = computed(() => {
  if (activeTab.value === 'all') return props.jobs;
  if (activeTab.value === 'jobs') return props.jobs.filter(job => !job.isCorso);
  if (activeTab.value === 'courses') return props.jobs.filter(job => job.isCorso);
  return props.jobs;
});

const openWhatsApp = (job) => {
    const phoneNumber = "393773024349";
    const message = job.isCorso 
        ? `Ciao, sono interessato/a al corso "${job.lavoro}" organizzato da ${job.azienda} a ${job.luogo}.`
        : `Ciao, sono interessato/a alla posizione di ${job.lavoro} presso ${job.azienda} a ${job.luogo}.`;
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
};
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

  .transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
  }
</style>