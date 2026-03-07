<template>
<AppLayout title="I sondaggi">
<div class="bg-base-200">

  <div v-if="!isAccepted" class="fixed z-50 inset-0 overflow-y-auto bg-gray-900 bg-opacity-90 backdrop-filter backdrop-blur-lg flex items-center justify-center max-w-6xl mx-auto p-4 rounded-lg shadow-lg text-white">
    <div class="flex flex-col items-center justify-between w-full max-w-md mx-auto">
      <p class="text-xl font-bold mb-4 text-primary">Utilizziamo cookie per migliorare la tua esperienza sul nostro sito web.</p>
      <p class="mb-4">Continuando a navigare sul sito accetti l'utilizzo dei cookie.<br/> Per maggiori informazioni, consulta la nostra <a href="#" class="underline">Informativa sulla privacy</a>.</p>
      <div class="flex items-center justify-between w-full">
        <p @click="declineCookies" class="text-accent">Non accetto</p>
        <button @click="acceptCookies" class="btn btn-primary">Accetta</button>
      </div>
    </div>
  </div>


    <div class="bg-gray-900 min-h-screen flex flex-col">
    <div class="relative isolate overflow-hidden flex-1 flex flex-col justify-center">
      <!-- Background Image with Overlay for better contrast -->
      <img src="vota.jpg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-40 mix-blend-overlay" />
      <div class="absolute inset-0 bg-gray-900/70 -z-10"></div>
      
      <!-- Decorative gradient blobs -->
      <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
      </div>

      <div class="mx-auto w-full max-w-4xl px-6 py-20 sm:py-32 lg:px-8">
          
          <!-- Active Election Card -->
          <div v-if="election" 
               class="card glass backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl w-full transition-all hover:scale-[1.01] hover:bg-white/10 duration-300 cursor-pointer overflow-hidden group" 
               @click="$inertia.visit(route('elections.showDynamic', election.id))">
            
            <div class="card-body text-center p-8 sm:p-16">
              <div class="badge badge-primary badge-outline mx-auto mb-6 p-4 gap-2 font-semibold shadow-lg shadow-primary/20">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                </span>
                Sondaggio Attivo
              </div>
              
              <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-br from-primary via-white to-secondary pb-2 mb-4 drop-shadow-sm">{{ election.name }}</h1>
              
              <p class="mt-4 text-gray-200 text-lg sm:text-xl leading-relaxed max-w-2xl mx-auto font-medium">{{ election.description }}</p>
              
              <div class="mt-10 sm:mt-14 flex flex-col sm:flex-row items-center justify-center gap-4">
                <button class="btn btn-primary btn-lg w-full sm:w-auto shadow-xl shadow-primary/30 rounded-full group-hover:scale-105 transition-all outline-none border-none">
                  Partecipa Ora
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
              </div>
            </div>
            
            <!-- Bottom decorative line -->
            <div class="h-1.5 w-full bg-gradient-to-r from-primary via-secondary to-primary opacity-80"></div>
          </div>
          
          <!-- Empty State Card -->
          <div v-else class="card glass backdrop-blur-xl bg-white/5 border border-white/10 shadow-2xl w-full max-w-2xl mx-auto">
              <div class="card-body text-center p-10 sm:p-16 flex flex-col items-center">
                 <div class="bg-gray-800/50 p-6 rounded-full mb-8 shadow-inner border border-white/5">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                 </div>
                 <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white mb-4">Nessun sondaggio aperto</h1>
                 <p class="text-gray-300 text-lg leading-relaxed max-w-md mx-auto">Al momento non ci sono votazioni o sondaggi aperti alla partecipazione. Torna a trovarci presto!</p>
                 <div class="mt-10 w-full sm:w-auto">
                   <a :href="route('home')" class="btn btn-outline btn-primary rounded-full px-8 w-full sm:w-auto">Torna alla Home</a>
                 </div>
              </div>
          </div>
          
      </div>
      
      <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)] pointer-events-none" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
      </div>
    </div>
  </div>
</div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';

const isAccepted = ref(false);

onMounted(() => {
  isAccepted.value = localStorage.getItem('cookiesAccepted') === 'true';
});

function acceptCookies() {
  localStorage.setItem('cookiesAccepted', 'true');
  isAccepted.value = true;
}

function declineCookies() {
  window.location.href = 'https://www.google.com';
}

defineProps({
  election: Object
});

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('it-IT', options); // Italian format
};

</script>