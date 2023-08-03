
<template>
<AppLayout title="Dashboard">
  <form class="px-8 py-6 bg-base-200"  @submit.prevent="submit">
    <div class="space-y-12">
      <div class="border-b border-white/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-white">Modifica campagna</h2>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
            <div class="sm:col-span-3">
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
            
            <div class="sm:col-span-1 flex items-center">
              <span class="text-sm font-medium leading-6 text-white mr-2">Stato della campagna:</span>
              <input v-model="form.status" type="checkbox" class="toggle toggle-info" />
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


      <div class="border-b border-white/10">
        
        <h2 class="text-base font-semibold text-white">Audience</h2>
        <p class="mt-1 text-sm leading-6 text-gray-400">Assegna le audiences (pubblico) per questa campagna</p>
        <div class="mt-10 space-y-10 mb-5">
          <fieldset>
            <div class=" space-y-6">
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input type="checkbox" class="checkbox checkbox-primary h-4 w-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-600 focus:ring-offset-gray-900" />
                </div>
                <div class="text-sm leading-6">
                  <label for="comments" class="font-medium text-white">Giovani - studenti</label>
                  <p class="text-gray-400">Include tutti i residenti nel periodo delle medie e superiori a Firenze</p>
                </div>
              </div>
              <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                  <input type="checkbox" class="checkbox checkbox-primary h-4 w-4 rounded border-white/10 bg-white/5 text-indigo-600 focus:ring-indigo-600 focus:ring-offset-gray-900" />
                </div>
                <div class="text-sm leading-6">
                  <label class="font-medium text-white">Lavoratori - pendolari</label>
                  <p class="text-gray-400">Adulti residenti e non che si spostano quotidianamente per lavoro</p>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-between gap-x-6">
      <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
      <button @click="$inertia.visit(route('campaigns.show', campaign.id))" type="button" class="btn btn-secondary">Annulla</button>
      <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary ">Salva</button>
    </div>
  </form>
</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    campaign: Object
})

let form = useForm({
    id: props.campaign.id,
    title: props.campaign.title,
    description: props.campaign.description,
    testingCampaign: props.campaign.testingCampaign,
    status: props.campaign.status,
    startingDate: props.campaign.startingDate,
    endDate: props.campaign.endDate
})

const submit = () =>{
    form.put(route('campaigns.update', {id: props.campaign.id}));
}

const destroy = () =>{
    form.delete(route('campaigns.destroy', {id: props.campaign.id}));
}

</script>
