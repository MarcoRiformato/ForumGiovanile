<template>
  <AppLayout title="Vota al sondaggio">
    <div class="bg-base-200 p-6">
      <!-- Election Details -->
      <div class="border-b-2 border-gray-300 pb-4 mb-6">
        <h1 class="text-xl font-bold">{{ election.name }}</h1>
        <p class="text-md"><strong>Descrizione:</strong> {{ election.description }}</p>
        <p><strong>Data inizio:</strong> {{ formatDate(election.start_date) }}</p>
        <p><strong>Data fine:</strong> {{ formatDate(election.end_date) }}</p>
      </div>

      <!-- Voting Form -->
      <form @submit.prevent="submitVote">
        <div class="mb-10">

          <div class="form-control mb-4">
          <label class="label">
            <span class="label-text">Scrivi il tuo nome e cognome</span>
          </label>
          <input type="text" placeholder="Nome e cognome" class="input input-bordered" v-model="voter.full_name" />

          <div class="form-control mb-20">
            <label class="label">
              <span class="label-text">Data di Nascita</span>
            </label>
            <input type="text" class="input input-bordered" placeholder="gg/mm/aa" v-model="voter.dateOfBirth" />
          </div>

          <h2 class="text-lg pb-4">Seleziona fino a 3 candidati</h2>
          <div class="form-control mb-2" v-for="candidate in candidates" :key="candidate.id">
            <label class="label cursor-pointer">
              <span class="label-text">{{ candidate.name }}</span>
              <input type="checkbox" v-model="selectedCandidates" :value="candidate.id" class="checkbox checkbox-secondary" />
            </label>
          </div>

        </div>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="selectedCandidates.length > 3">Vota</button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, reactive, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const { election } = defineProps({
  election: Object,
});

const reactiveElection = reactive({ ...election });
const selectedCandidates = ref([]);

const voter = reactive({
  full_name: '',
  dateOfBirth: ''
});

const candidates = computed(() => [
  { id: 34, name: 'Antonio Ferrini', description: '...' },
  { id: 35, name: 'Mario Scelza', description: '...' },
  { id: 36, name: 'Ilaria De Palma', description: '...' },
  { id: 37, name: 'Giuditta Sgherri', description: '...' },
]);

const form = useForm({
  votes: []
});

watch(selectedCandidates, (newVal, oldVal) => {
  if (newVal.length > 3) {
    selectedCandidates.value = oldVal;
  }
});

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('it-IT', options);
};

const submitVote = () => {
  const votesToSend = selectedCandidates.value.map(candidateId => ({
    election_id: election.id,
    type: 'candidate',
    questionId: 13,
    candidate_id: candidateId,
    written_text: '',
    selectedId: candidateId
  }));

  votesToSend.push({
    election_id: election.id,
    questionId: 14,
    candidate_id: null,
    type: 'writing',
    written_text: voter.full_name,
    selectedId: voter.full_name
  });

  votesToSend.push({
    election_id: election.id,
    questionId: 15,
    candidate_id: null,
    type: 'writing',
    written_text: voter.dateOfBirth,
    selectedId: voter.dateOfBirth
  });

  form.votes = votesToSend;
  console.log(votesToSend)
  form.post(route('election.vote', { election: election.id }));
};
</script>
