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


    <div class="bg-gray-900">
    <div class="relative isolate overflow-hidden">
      <img src="vota.jpg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
      <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
      </div>
      <div class="mx-auto max-w-2xl mt-10 sm:mt-0 sm:py-48 lg:py-56">
            <div class="text-center" @click="$inertia.visit(route('elections.show', election.id))">
              <h1 class="text-2xl  sm:text-4xl font-bold tracking-tight text-white sm:text-6xl">{{ election.name }}</h1>
              <p class="mt-3 sm:mt-6 text-white text-sm sm:text-lg leading-8">{{ election.description }}</p>
              <!--<i class="mt-3 sm:mt-6 text-white text-sm sm:text-lg leading-8">Dal {{ formatDate(election.start_date) }} al {{ formatDate(election.end_date) }}</i>-->
              <div class="mt-5 sm:mt-10 flex items-center justify-center gap-x-6">
                <a as="button" href="#" class="btn btn-primary">Partecipa</a>
              </div>
        </div>
      </div>
      <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
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