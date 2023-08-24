<template>
    <AppLayout title="Mostra elezione">
      <div class="bg-base-200">
        <div class="ps-16">
          <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-400">Nome</dt>
            <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.name }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-400">Descrizione</dt>
            <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.description }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-400">Inizio elezioni</dt>
            <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0"> {{ election.start_date }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-400">Fine elezioni</dt>
            <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.end_date }}</dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm font-medium leading-6 text-gray-400">Stato</dt>
            <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0"> {{ election.status }}</dd>
          </div>
        </div>
        <div v-for="question in election.questions" :key="question.id" class="border-b border-gray-200">
          <div>
            <div class="px-4 sm:px-6 lg:px-8">
              <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full">
                      <thead>
                        <tr>
                          <th scope="col" class="px-3 py-3.5 text-violet-400 text-center text-sm font-semibold ">{{ question.text }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="question.type === 'options'">
                          <tr v-for="option in question.options" :key="option.id" class="border-t border-gray-200">
                            <td class="whitespace-nowrap px-3 py-4 text-sm">{{ option.text }}</td>
                          </tr>
                        </template>
                        <template v-if="question.type === 'candidates'">
                          <tr v-for="candidate in question.candidates" :key="candidate.id" class="border-t border-gray-200">
                            <td class="whitespace-nowrap px-3 py-4 text-sm">{{ candidate.name }} - {{ candidate.description }}</td>
                          </tr>
                        </template>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-6 flex items-center justify-between gap-x-6">
            <button @click="$inertia.visit(route('admin.elections.index'))" type="button" class="btn btn-secondary">Annulla</button>
            <button @click="submit" type="button"  class="btn btn-primary">Salva</button>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';

  const election = JSON.parse(sessionStorage.getItem('election'));

const form = useForm({
    name: election.name,
    description: election.description,
    start_date: election.start_date,
    end_date: election.end_date,
    status: election.status,
    questions: JSON.stringify(election.questions),
    // Additional fields, if any
    media_file: election.media_file,
});

const submit = () => {
    form.post(route('admin.elections.store'));
};

  
  </script>
  