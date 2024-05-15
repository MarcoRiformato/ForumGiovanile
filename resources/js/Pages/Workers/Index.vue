<template>
<AppLayout title="LavorElba">
<div class="flex justify-end items-center w-full py-4 pb-6">
    <div class="relative rounded-full px-3 text-sm leading-6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
    Sei un azienda? <a href="#" class="font-semibold text-secondary"><span class="absolute inset-0" aria-hidden="true" />Trova dipendenti<span aria-hidden="true">&rarr;</span></a>
    </div>
</div>

<ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
<div class="w-72 border border-gray-300 rounded-lg overflow-hidden shadow-md mb-4 font-sans">
    <div class="relative text-center p-1 ">
        <img src="https://picsum.photos/100" alt="Profile Picture" class="w-full h-auto object-cover rounded-lg">
        <div class="absolute top-2 left-2 flex">
            <p class="w-5 h-4 ml-2">🇮🇹</p>
            <img src="english_flag_url" alt="English" class="w-5 h-4 ml-2">
        </div>
        <div class="absolute bottom-2 left-2 bg-green-600 text-white py-1 px-2 rounded">
            Disponibile da subito
        </div>
    </div>
    <div class="p-4 text-center">
        <h3 class="text-xl mb-2">Maria Rossi</h3>
        <p class="text-sm mb-2">Experienced in high-volume restaurants, providing excellent customer service...</p>
        <div class="flex justify-center flex-wrap mb-4">
            <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Waitress</span>
            <span class="bg-violet-800 rounded-full px-3 py-1 m-1 text-sm">Barista</span>
        </div>
        <div class="flex justify-between text-sm mb-4">
            <span>📍Portoferraio</span>
            <span>📅15/06-14/09</span>
        </div>
        <button class="bg-blue-500 text-white py-2 px-4 rounded">Contatta ora</button>
    </div>
</div>

</ul>

</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    workers: Object
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