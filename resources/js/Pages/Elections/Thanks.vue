<template>
  <AppLayout title="Grazie per il tuo voto">
    <div class="bg-slate-950 min-h-screen flex flex-col justify-center relative isolate">
      
      <!-- Deep Slate & Indigo Background Effects -->
      <div class="absolute inset-0 -z-10 pointer-events-none overflow-hidden">
          <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-indigo-900/10 blur-[130px] rounded-full"></div>
          <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-slate-800/20 blur-[130px] rounded-full"></div>
      </div>

      <div class="mx-auto w-full max-w-3xl px-6 py-20 lg:px-8 relative z-10">
        
        <div class="bg-slate-900/60 backdrop-blur-xl border border-white/10 shadow-2xl shadow-indigo-500/10 rounded-3xl p-12 text-center transition-all">
          
          <!-- Success Icon -->
          <div class="w-24 h-24 bg-indigo-500/10 rounded-full mx-auto mb-8 flex items-center justify-center border border-indigo-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          
          <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white mb-6">Grazie per il tuo voto!</h1>
          
          <p class="text-slate-400 text-lg sm:text-xl leading-relaxed max-w-xl mx-auto mb-10">
            La tua preferenza è stata registrata con successo nel sistema. Ti ringraziamo per aver partecipato all'elezione.
          </p>
          
          <a :href="route('home')" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold shadow-lg shadow-indigo-600/20 transition-all gap-3 group">
            Torna alla Home
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </a>
          
        </div>

      </div>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { onMounted } from 'vue';

onMounted(() => {
  window.history.pushState(null, null, window.location.href);
  window.addEventListener('popstate', onBackButtonEvent);
});

function onBackButtonEvent(e) {
  e.preventDefault();
  window.location.href = '/elections/thanks';
}

</script>