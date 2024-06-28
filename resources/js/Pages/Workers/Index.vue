<template>
    <AppLayout title="LavorElba">
      <div class="flex justify-end items-center w-full py-4 pb-6">
        <div class="relative rounded-full px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
          Cerchi lavoro? <a @click="$inertia.visit(route('jobs.index'))" class="font-semibold text-secondary"><span class="absolute inset-0" aria-hidden="true" />Vai alle offerte<span aria-hidden="true">&rarr;</span></a>
        </div>
      </div>
  
      <!--
            <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
        <li class="overflow-hidden rounded-xl border border-gray-200">
          <div class="relative text-center p-1">
            <img src="https://picsum.photos/100" alt="Maria Rossi" class="w-full h-auto object-cover rounded-lg" />
            <div class="absolute top-2 left-2 flex">
              <p class="w-5 h-4 ml-2">🇮🇹</p>
            </div>
            <div class="absolute bottom-2 left-2 bg-green-600 text-white py-1 px-2 rounded">
              Disponibile da subito
            </div>
          </div>
          <div class="p-4 text-center">
            <h3 class="text-xl mb-2">Maria Rossi</h3>
            <p class="text-sm mb-2">Esperienza in ristorazione</p>
            <div class="flex justify-center flex-wrap mb-4">
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Barista</span>
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Cuoca</span>
            </div>
            <div class="flex justify-between text-sm mb-4">
              <span>📍Portoferraio</span>
              <span>📅15/06-14/09</span>
            </div>
            <button @click="openWhatsApp('Maria Rossi', 'Esperienza in ristorazione')" class="bg-blue-500 text-white py-2 px-4 rounded">Contatta ora</button>
          </div>
        </li>
  
        <li class="overflow-hidden rounded-xl border border-gray-200">
          <div class="relative text-center p-1">
            <img src="https://picsum.photos/100" alt="Giovanni Bonomelli" class="w-full h-auto object-cover rounded-lg" />
            <div class="absolute top-2 left-2 flex">
              <p class="w-5 h-4 ml-2">🇮🇹</p>
            </div>
            <div class="absolute bottom-2 left-2 bg-green-600 text-white py-1 px-2 rounded">
              Disponibile da subito
            </div>
          </div>
          <div class="p-4 text-center">
            <h3 class="text-xl mb-2">Giovanni Bonomelli</h3>
            <p class="text-sm mb-2">Esperienza in alberghi</p>
            <div class="flex justify-center flex-wrap mb-4">
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Cameriera ai piani</span>
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Front Desk</span>
            </div>
            <div class="flex justify-between text-sm mb-4">
              <span>📍Porto azzurro</span>
              <span>📅11/06-14/08</span>
            </div>
            <button @click="openWhatsApp('Giovanni Bonomelli', 'Esperienza in alberghi')" class="bg-blue-500 text-white py-2 px-4 rounded">Contatta ora</button>
          </div>
        </li>
  
        <li class="overflow-hidden rounded-xl border border-gray-200">
          <div class="relative text-center p-1">
            <img src="https://picsum.photos/100" alt="Luca Gori" class="w-full h-auto object-cover rounded-lg" />
            <div class="absolute top-2 left-2 flex">
              <p class="w-5 h-4 ml-2">🇮🇹</p>
            </div>
            <div class="absolute bottom-2 left-2 bg-green-600 text-white py-1 px-2 rounded">
              Disponibile da subito
            </div>
          </div>
          <div class="p-4 text-center">
            <h3 class="text-xl mb-2">Luca Gori</h3>
            <p class="text-sm mb-2">Diplomato in ragioneria</p>
            <div class="flex justify-center flex-wrap mb-4">
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Contabilità</span>
              <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Ufficio paghe</span>
            </div>
            <div class="flex justify-between text-sm mb-4">
              <span>📍Capoliveri</span>
              <span>📅15/05-14/12</span>
            </div>
            <button @click="openWhatsApp('Luca Gori', 'Diplomato in ragioneria')" class="bg-blue-500 text-white py-2 px-4 rounded">Contatta ora</button>
          </div>
        </li>
      </ul>
      -->

    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  
  const openWhatsApp = (name, experience) => {
    const phoneNumber = "393773024349";
    const message = `Ciao, sono interessato/a al profilo di ${name} con esperienza in ${experience}.`;
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
  </style>
  