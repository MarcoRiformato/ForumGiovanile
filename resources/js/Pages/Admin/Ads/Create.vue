<template>
    <AppLayout title="Crea nuova pubblicità">
      <div class="bg-base-200">
        <h1 class="text-4xl p-4">Crea nuova pubblicità</h1>
        <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit" enctype="multipart/form-data">
          <div class="space-y-12">
            <div class="border-b border-white/10 pb-12">
              <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Title -->
                <div class="sm:col-span-4">
                  <label class="block text-sm font-medium leading-6 text-white">Titolo</label>
                  <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <input v-model="form.title" type="text" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6"/>
                  </div>
                </div>
                <!-- Link URL -->
                <div class="sm:col-span-4">
                  <label class="block text-sm font-medium leading-6 text-white">Link URL</label>
                  <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <input v-model="form.link_url" type="url" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6"/>
                  </div>
                </div>
                <!-- Start Date -->
                <div class="sm:col-span-4">
                  <label class="block text-sm font-medium leading-6 text-white">Data inizio</label>
                  <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <input v-model="form.start_date" type="date" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6"/>
                  </div>
                </div>
                <!-- End Date -->
                <div class="sm:col-span-4">
                  <label class="block text-sm font-medium leading-6 text-white">Data fine</label>
                  <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <input v-model="form.end_date" type="date" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6"/>
                  </div>
                </div>
                <!-- Priority -->
                <div class="sm:col-span-4">
                  <label class="block text-sm font-medium leading-6 text-white">Priorità</label>
                  <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <select v-model="form.priority" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-black focus:ring-0 sm:text-sm sm:leading-6">
                      <option value="0">Main nav</option>
                      <option value="1">Primo</option>
                      <option value="2">Secondo</option>
                      <option value="3">Terzo</option>
                      <option value="4">Quinto</option>
                      <option value="5">Quinto</option>
                      <option value="6">Sesto</option>
                      <option value="7">Settimo</option>
                      <option value="8">Ottavo</option>
                      <option value="9">Nono</option>
                      <option value="10">Decimo</option>
                    </select>
                  </div>
                </div>
                <!-- Image Upload -->
                <div class="col-span-full">
                  <label for="cover-photo" class="block text-sm font-medium leading-6 text-white">Immagine</label>
                  <div class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">
                    <div class="text-center">
                      <div class="mt-4 flex text-sm leading-6 text-gray-400">
                        <label for="image-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold text-white focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                          <span>Carica una foto</span>
                          <input id="image-upload" name="image" type="file" class="sr-only" @change="form.image = $event.target.files[0]" />
                        </label>
                        <p class="pl-1">oppure trascinala qui</p>
                      </div>
                      <p class="text-xs leading-5 text-gray-400">PNG, JPG, GIF up to 10MB</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-6 flex items-center justify-between gap-x-6">
              <button @click="$inertia.visit(route('admin.ads.index'))" type="button" class="btn btn-secondary">Annulla</button>
              <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary">Salva</button>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';
  
  let form = useForm({
    title: '',
    link_url: '',
    start_date: '',
    end_date: '',
    priority: '',
    image: null
  })

  const submit = () => {
  const formData = new FormData();
  formData.append('title', form.title);
  formData.append('link_url', form.link_url);
  formData.append('start_date', form.start_date);
  formData.append('end_date', form.end_date);
  formData.append('priority', form.priority);
  if (form.image) {
    formData.append('image', form.image);
  }

  form.post(route('admin.ads.store'), {
    body: formData,
    onSuccess: () => {
      form.reset();
    }
  });
}


  </script>
  