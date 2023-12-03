<template>
<AppLayout title="Mostra elezione">
<div class="bg-base-200">
  <div class="ps-16">
    <div class="px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
      <dt class="text-sm font-medium leading-6 ">Nome</dt>
      <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.name }}</dd>
      <div class="flex justify-end -mt-4 sm:col-span-1 sm:flex-none">
        <button @click="$inertia.visit(route('admin.elections.step1', election.id))" class="btn btn-primary">
          Modifica
        </button>
      </div>
    </div>
    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
      <dt class="text-sm font-medium leading-6 ">Descrizione</dt>
      <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.description }}</dd>
    </div>
    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
      <dt class="text-sm font-medium leading-6 ">Inizio elezioni</dt>
      <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.start_date }}</dd>
    </div>
    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
      <dt class="text-sm font-medium leading-6 ">Fine elezioni</dt>
      <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.end_date }}</dd>
    </div>
    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
      <dt class="text-sm font-medium leading-6 ">Stato</dt>
      <dd class="mt-1 text-sm leading-6 sm:col-span-2 sm:mt-0">{{ election.status }}</dd>
    </div>
    <div v-for="question in election.questions" :key="question.id" class="border-b border-gray-200">
      <div>
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
<div class="bg-base-100">
<div class="mx-auto max-w-7xl">
  <div class="bg-base-100 py-10">
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
          <h1 class="text-base font-semibold leading-6">{{ question.text }}</h1>
        </div>
      </div>
      <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table
            v-if="question.type !== 'writing'"
            class="min-w-full divide-y">
              <thead>
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">Opzione / Candidato</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Voti</th>
                  <!--<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Percentuale</th>-->
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-500">
                <template v-if="question.type === 'options'">
                <tr v-for="option in question.options.sort((a, b) => b.votes_count - a.votes_count)" :key="option.id">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">{{ option.text }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm">{{ option.votes_count }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm">
                    {{ ((option.votes_count / totalVotes(question)) * 100).toFixed(2) }}%
                  </td>
                  <td>
                    <div :style="{width: `${option.votes_count * 10}px`}" class="bg-green-500 h-4 ml-2"></div>
                  </td>
                </tr>
              </template>
              <!-- Snippet for 'candidates' type questions -->
                              <template v-if="question.type === 'candidates'">
                                <tr v-for="candidate in question.candidates.sort((a, b) => b.votes_count - a.votes_count)" :key="candidate.id">
                                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">{{ candidate.name }}</td>
                                  <td class="whitespace-nowrap px-3 py-4 text-sm">Voti: {{ candidate.votes_count }}</td>
                                  <!--<td class="whitespace-nowrap px-3 py-4 text-sm">
                                    {{ ((candidate.votes_count / totalVotes(question, 'candidates')) * 100).toFixed(2) }}%
                                  </td>-->
                                  <td>
                                    <div :style="{width: `${candidate.votes_count * 10}px`}" class="bg-blue-500 h-4 ml-2"></div>
                                  </td>
                                </tr>
                              </template>
                                </tbody>
                              </table>
                              <table
                              v-if="question.type === 'writing'"
                              class="min-w-full divide-y"
                            >
                              <tbody class="divide-y divide-gray-800">
                                <tr
                                  v-for="vote in question.votes"
                                  :key="vote.id"
                                >
                                  <td
                                    class="whitespace-nowrap px-3 py-4 text-sm flex items-center"
                                  >
                                    {{ vote.written_text }}
                                  </td>
                                </tr>
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

const totalVotes = (question) => {
  return question.options.reduce((acc, curr) => acc + curr.votes_count, 0);
}
</script>
