<template>
<div>
<AppLayout title="Dashboard">
<div class="bg-base-200">
    <form class="mx-6 mb-3" @submit.prevent="submit">
        <div class="form-control grid md:grid-cols-4 gap-4">
  <!-- Titolo -->
  <div class="md:col-span-2">
    <label class="label">
      <span class="label-text">Titolo</span>
    </label>
    <input
      type="text" 
      v-model="form.title"
      placeholder="Inserisci il nome della campagna" 
      class="input input-bordered w-full input-primary" 
    />
  </div>

  <!-- Toggle buttons -->
  <div class="md:col-span-1 mt-9">
    <label class="cursor-pointer label">
      <span class="label-text">Campagna di prova</span>
      <input
      v-model="form.testingCampaign"
        type="checkbox"
        class="toggle toggle-primary toggle-lg"
      />
    </label>
  </div>

  <div class="md:col-span-1 mt-9">
    <label class="cursor-pointer label">
      <span class="label-text">Status</span>
      <input
      v-model="form.status"
        type="checkbox"
        class="toggle toggle-primary toggle-lg"
      />
    </label>
  </div>
</div>


    <!-- Descrizione -->
    <div class="form-control">
      <label class="label">
        <span class="label-text">Descrizione</span>
      </label>
      <textarea
      v-model="form.description"
        class="textarea textarea-md textarea-primary w-full h-32" contenteditable
        placeholder="Descrivi l'campaign">
      </textarea>
    </div>

<!-- Link, Date Pickers, and Image Upload -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mt-4">
  <div class="form-control">
    <label class="label">
      <span class="label-text">Start Date</span>
    </label>
    <input
    v-model="form.startingDate"
      type="date"
      class="input input-bordered input-primary w-full"
    />
  </div>

  <div class="form-control">
    <label class="label">
      <span class="label-text">End Date</span>
    </label>
    <input
    v-model="form.endDate"
      type="date"
      class="input input-bordered input-primary w-full"
    />
  </div>

  <div class="flex items-center justify-center mt-8">
    <button type="button" class="btn" onclick="my_modal_1.showModal()">Scegli immagine</button>
    <dialog id="my_modal_1" class="modal">
      <form method="dialog" class="modal-box">
        <ImageUpload/>
        <div class="modal-action">
          <button class="btn">Close</button>
        </div>
      </form>
    </dialog>
  </div>
</div>

<div class="flex justify-center items-center mt-8 space-x-4">
  <a href="/campaigns" type="button" class="btn btn-secondary w-1/4">Annulla</a>
  <button type="submit" :disabled="form.processing" class="btn btn-primary w-1/4">Salva</button>
</div>


</form>
</div>
</AppLayout>
</div>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    testingCampaign: '',
    status: '',
    startingDate: '',
    startingDate: ''
})

const submit = () =>{
    form.post(route('campaigns.store'));
}

</script>
    