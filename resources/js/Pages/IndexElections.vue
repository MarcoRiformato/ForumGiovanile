<template>
<AppLayout title="Elezioni">
<div class="bg-slate-950 min-h-screen">

  <div v-if="!isAccepted" class="fixed z-50 inset-0 overflow-y-auto bg-slate-950/90 backdrop-filter backdrop-blur-lg flex items-center justify-center max-w-6xl mx-auto p-4 rounded-lg shadow-lg text-slate-200">
    <div class="flex flex-col items-center justify-between w-full max-w-md mx-auto">
      <p class="text-xl font-bold mb-4 text-indigo-400">Utilizziamo cookie per migliorare la tua esperienza sul nostro sito web.</p>
      <p class="mb-4">Continuando a navigare sul sito accetti l'utilizzo dei cookie.<br/> Per maggiori informazioni, consulta la nostra <a href="#" class="underline text-white">Informativa sulla privacy</a>.</p>
      <div class="flex items-center justify-between w-full">
        <p @click="declineCookies" class="text-slate-400 hover:text-white cursor-pointer transition-colors">Non accetto</p>
        <button @click="acceptCookies" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold transition-all">Accetta</button>
      </div>
    </div>
  </div>

  <div class="relative isolate flex flex-col justify-center min-h-[80vh]">
    <!-- Deep Slate & Indigo Serious Background -->
    <div class="absolute inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-indigo-900/10 blur-[130px] rounded-full"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-slate-800/20 blur-[130px] rounded-full"></div>
    </div>

    <div class="mx-auto w-full max-w-4xl px-6 py-20 sm:py-32 lg:px-8 relative z-10">
        
        <!-- Active Election Card -->
        <div v-if="election" 
             class="group relative bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-2xl rounded-3xl w-full transition-all hover:border-indigo-500/50 duration-500 cursor-pointer overflow-hidden" 
             @click="$inertia.visit(route('elections.showDynamic', election.id))">
            
          <div class="p-8 sm:p-16 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 font-semibold mb-8 text-sm tracking-wide">
              <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
              </span>
              Elezione Attiva
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white mb-6 leading-tight">{{ election.name }}</h1>
            
            <p class="text-slate-400 text-lg sm:text-xl leading-relaxed max-w-2xl mx-auto font-normal">{{ election.description }}</p>
            
            <div class="mt-12 flex justify-center">
              <button class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-3 group-hover:px-10">
                Partecipa Ora
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
              </button>
            </div>
          </div>
          
          <!-- Bottom decorative line -->
          <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50"></div>
        </div>
        
        <!-- Empty State Card -->
        <div v-else class="bg-slate-900/60 backdrop-blur-xl border border-white/5 rounded-3xl shadow-xl p-12 text-center max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-slate-800 rounded-2xl mx-auto mb-8 flex items-center justify-center border border-white/5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-4">Nessuna elezione aperta</h1>
            <p class="text-slate-400 text-lg mb-8">Al momento non ci sono elezioni aperte alla partecipazione.</p>
            <a :href="route('home')" class="inline-flex px-6 py-3 border border-slate-700 hover:border-slate-500 hover:bg-slate-800 text-slate-300 rounded-xl font-medium transition-all">Torna alla Home</a>
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