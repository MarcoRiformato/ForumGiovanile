<template>
  <AppLayout title="ElbaJobz">
    <div class="flex justify-end items-center w-full py-4 pb-6">
      <div class="relative rounded-full px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
        Cerchi lavoro o formazione? <a @click="$inertia.visit(route('jobs.index'))" class="font-semibold text-secondary"><span class="absolute inset-0" aria-hidden="true" />Vai alle offerte di lavoro<span aria-hidden="true">&rarr;</span></a>
      </div>
    </div>

    <Banner 
      message="La piattaforma lavoro del Forum Giovanile dell'Elba nasce per aiutare la conoscenza reciproca di domanda/offerta nel mondo del lavoro ma soprattutto per far si che ciò avvenga nel rispetto dei principi di: trasparenza legalità rispetto dei diritti dei lavoratori reciproca buona fede che tutti gli utenti,aziende e lavoratori, si impegnano a rispettare - Il Forum Giovanile dell'Elba"
      class="m-4 rounded-xl"
    />
    
    <div v-if="workers.length === 0" class="text-center py-8">
      <p class="text-xl text-gray-600">Al momento non ci sono lavoratori disponibili, riprova più tardi 😕</p>
    </div>

    <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
      <li v-for="worker in workers" 
          :key="worker.id" 
          class="overflow-hidden rounded-xl border border-gray-200 cursor-pointer transition-all duration-300"
          :class="{ 'lg:col-span-3': expandedCard === worker.id }"
          @click="toggleCard(worker.id)">
        <div class="flex" :class="{ 'flex-col lg:flex-row': expandedCard === worker.id }">
          <!-- Basic Card Info -->
          <div class="flex-1">
            <div class="relative text-center p-1">
              <img 
                v-if="worker.media && worker.media.filepath"
                :src="`/storage/${worker.media.filepath}`"
                :alt="worker.name"
                class="w-full h-auto object-cover rounded-lg"
                :class="{ 'lg:max-w-xs': expandedCard === worker.id }"
              />
              <img 
                v-else
                src="/storage/media/blank_avatar.webp"
                :alt="worker.name"
                class="w-full h-auto object-cover rounded-lg"
                :class="{ 'lg:max-w-xs': expandedCard === worker.id }"
              />
              <div class="absolute top-2 left-2 flex">
                <p class="w-5 h-4 ml-2">🇮🇹</p>
              </div>
            </div>
            <div class="p-4 text-center">
              <h3 class="text-xl mb-2">{{ worker.name }}</h3>
              <p class="text-sm mb-2">{{ worker.work_experience }}</p>
              <div v-if="worker.job_titles" class="flex justify-center flex-wrap mb-4">
                <span v-for="(jobTitle, index) in worker.job_titles.split(',')" 
                      :key="index" 
                      class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm text-white">
                  {{ jobTitle.trim() }}
                </span>
              </div>
              <div class="flex justify-between text-sm mb-4">
                <span>📍{{ worker.residence }}</span>
                <span v-if="worker.availability_start && worker.availability_end">
                  📅{{ formatDateRange(worker.availability_start, worker.availability_end) }}
                </span>
                <span>{{ formatContractType(worker.contract_type) }}</span>
              </div>
              <button @click.stop="openWhatsApp(worker)" class="bg-primary text-primary-content py-2 px-4 rounded">
                Contatta ora
              </button>
            </div>
          </div>

          <!-- Extended Info (shown when expanded) -->
          <div v-if="expandedCard === worker.id" 
               class="flex-1 p-6 border-t lg:border-l lg:border-t-0">
            <div class="space-y-4">
              <div>
                <h4 class="font-semibold text-secondary">Descrizione</h4>
                <p>{{ worker.description || 'Nessuna descrizione disponibile' }}</p>
              </div>
              <div>
                <h4 class="font-semibold text-secondary">Istruzione</h4>
                <p>{{ worker.education || 'Non specificato' }}</p>
              </div>
              <div>
                <h4 class="font-semibold text-secondary">Lingue</h4>
                <p>{{ worker.languages ? JSON.parse(worker.languages).join(', ') : 'Non specificate' }}</p>
              </div>
              <div class="space-y-2">
                <div class="flex items-center">
                  <span class="mr-2 text-secondary">🚗 Auto/moto:</span>
                  <span>{{ worker.has_car ? '✅' : '❌' }}</span>
                </div>
                <div class="flex items-center text-secondary">
                  <span class="mr-2">📜 Certificato HACCP:</span>
                  <span>{{ worker.has_hccp_certificate ? '✅' : '❌' }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Banner from '@/Components/Banner.vue';
import { ref } from 'vue';

const props = defineProps({
  workers: Array
});

const expandedCard = ref(null);

const toggleCard = (workerId) => {
  expandedCard.value = expandedCard.value === workerId ? null : workerId;
};

const openWhatsApp = (worker) => {
  const phoneNumber = "393773024349";
  const message = `Ciao, sono interessato/a al profilo di ${worker.name}.`;
  const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
  window.open(url, '_blank');
};

const formatContractType = (contractType) => {
  if (!contractType) return 'Informazioni non disponibili';
  
  const contractEmoji = {
    'Tempo pieno': '🌕',
    'Tempo parziale': '🌗',
    'A chiamata': '📞',
    'Partita IVA': '🤝🏻',
  };
  return `${contractEmoji[contractType] || '🗂️'} ${contractType}`;
};

const formatDateRange = (start, end) => {
  if (!start || !end) return null;
  const startDate = new Date(start);
  const endDate = new Date(end);
  return `${startDate.getDate()}/${startDate.getMonth() + 1}-${endDate.getDate()}/${endDate.getMonth() + 1}`;
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

/* Add these new styles */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>

