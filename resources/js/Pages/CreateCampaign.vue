<template>
  <AppLayout title="Dashboard">
    <form class="px-8 py-6 bg-base-200"  @submit.prevent="submit">
      <div class="space-y-12">
        <div class="border-b border-white/10 pb-12">
          <h2 class="text-base font-semibold leading-7 text-white">Crea campagna</h2>
  
          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
              <label for="username" class="block text-sm font-medium leading-6 text-white">Titolo</label>
              <div class="mt-2">
                <div class="flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                  <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm"> </span>
                  <input
                  v-model="form.title"
                   type="text" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" placeholder="Campagna che salverà il mondo" />
                </div>
              </div>
            </div>
  
            <div class="col-span-full">
              <label for="about" class="block text-sm font-medium leading-6 text-white">Descrizione</label>
              <div class="mt-2">
                <textarea
                v-model="form.description"
                 rows="3" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
              </div>
              <p class="mt-3 text-sm leading-6 text-gray-400">Descrivi la campagna. Questo testo è solo per uso interno, non verrà visualizzato dagli utenti</p>
            </div>
  
            <div class="col-span-full">
              <label for="cover-photo" class="block text-sm font-medium leading-6 text-white">Foto</label>
              <div class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">
                <div class="text-center">
                  <div class="mt-4 flex text-sm leading-6 text-gray-400">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold text-white focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                      <span>Carica una foto</span>
                      <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                    </label>
                    <p class="pl-1">oppure trascinala qui</p>
                  </div>
                  <p class="text-xs leading-5 text-gray-400">PNG, JPG, GIF up to 10MB</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="border-b border-white/10 pb-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8 justify-items-center items-center sm:justify-items-start">
      <div class="form-control w-full sm:w-3/4">
        <label class="label">
          <span class="label-text">Data di inizio</span>
        </label>
        <input
          v-model="form.startingDate"
          type="date"
          class="input input-bordered input-primary w-full"
        />
      </div>
  
      <div class="form-control w-full sm:w-3/4">
        <label class="label">
          <span class="label-text">Data di fine</span>
        </label>
        <input
          v-model="form.endDate"
          type="date"
          class="input input-bordered input-primary w-full"
        />
      </div>
    </div>
  </div>
  
      <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="/campaigns" type="button" class="btn btn-secondary">Annulla</a>
        <button type="submit" :disabled="form.processing" class="btn btn-primary ">Salva</button>
      </div>
    </form>
  </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';
  
  const form = useForm({
      title: '',
      description: '',
      startingDate: '',
      endDate: ''
  })
  
  const submit = () =>{
      form.post(route('campaigns.store'));
  }
  
  </script>
  