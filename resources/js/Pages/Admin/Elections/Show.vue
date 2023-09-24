<template>
  <AppLayout title="Mostra elezione">
    <div class="bg-base-200">
      <div class="ps-16">
        <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-400">Nome</dt>
          <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.name }}</dd>
          <div class="flex justify-end -mt-4 sm:col-span-1 sm:flex-none">
            <button @click="$inertia.visit(route('admin.elections.step1', election.id))" class="btn btn-primary">
              Modifica
            </button>
          </div>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-400">Descrizione</dt>
          <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.description }}</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-400">Inizio elezioni</dt>
          <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.start_date }}</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-400">Fine elezioni</dt>
          <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.end_date }}</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-400">Stato</dt>
          <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.status }}</dd>
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
                          <th scope="col" class="px-3 py-3.5 text-violet-400 text-center text-sm font-semibold">
                            {{ question.text }}
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="question.type === 'options'">
                          <tr v-for="option in question.options.sort((a, b) => b.votes_count - a.votes_count)" :key="option.id" class="border-t border-gray-200">
                            <td class="whitespace-nowrap px-3 py-4 text-sm flex items-center">
                              {{ option.text }} - Voti: {{ option.votes_count }}
                              <div :style="{width: `${option.votes_count * 10}px`}" class="bg-blue-500 h-4 ml-2"></div>
                            </td>
                          </tr>
                        </template>
                        <template v-if="question.type === 'candidates'">
                          <tr v-for="candidate in question.candidates.sort((a, b) => b.votes_count - a.votes_count)" :key="candidate.id" class="border-t border-gray-200">
                            <td class="whitespace-nowrap px-3 py-4 text-sm flex items-center">
                              {{ candidate.name }} - {{ candidate.description }} - Voti: {{ candidate.votes_count }}
                              <div :style="{width: `${candidate.votes_count * 10}px`}" class="bg-green-500 h-4 ml-2"></div>
                            </td>
                          </tr>
                        </template>
                        <template v-if="question.votes.length">
                          <tr v-for="vote in question.votes" :key="vote.id" class="border-t border-gray-200">
                            <td class="whitespace-nowrap px-3 py-4 text-sm flex items-center">
                              {{ vote.written_text }} <!-- Here's your written text -->
                            </td>
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
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  election: Object
})
</script>
