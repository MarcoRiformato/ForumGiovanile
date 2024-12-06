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
          </div>

          <div class="form-control mb-20">
            <label class="label">
              <span class="label-text">Data di Nascita</span>
            </label>
            <input type="text" class="input input-bordered" placeholder="gg/mm/aa" v-model="voter.dateOfBirth" />
          </div>

          <div v-if="errors.length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
              <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
          </div>

          <h2 class="text-lg pb-4">Seleziona fino a 3 candidati</h2>
          <div class="form-control mb-2" v-for="candidate in candidates" :key="candidate.id">
            <label class="label cursor-pointer">
              <span class="label-text">{{ candidate.name }}</span>
              <input 
                type="checkbox" 
                v-model="selectedCandidates" 
                :value="candidate.id" 
                class="checkbox checkbox-secondary"
                :disabled="selectedCandidates.length >= 3 && !selectedCandidates.includes(candidate.id)" 
              />
            </label>
          </div>
        </div>

        <div class="text-sm text-gray-600 mb-4">
          Hai selezionato {{ selectedCandidates.length }} preferenze delle 3 disponibili
        </div>

        <button 
          type="submit" 
          class="btn btn-primary" 
          :disabled="!isFormValid"
        >
          Vota
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, reactive, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const errors = ref([]);

const props = defineProps({
  election: Object,
  candidates: {
    type: Array,
    required: true
  }
});

const selectedCandidates = ref([]);

const voter = reactive({
  full_name: '',
  dateOfBirth: ''
});

const form = useForm({
  votes: []
});

const isFormValid = computed(() => {
  return voter.full_name.trim() !== '' && 
         voter.dateOfBirth.trim() !== '' && 
         selectedCandidates.value.length > 0 && 
         selectedCandidates.value.length <= 3;
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
  errors.value = [];

  if (!voter.full_name.trim()) {
    errors.value.push('Per favore, inserisci il tuo nome e cognome.');
  }

  if (!voter.dateOfBirth.trim()) {
    errors.value.push('Per favore, inserisci la tua data di nascita.');
  }

  if (selectedCandidates.value.length === 0) {
    errors.value.push('Per favore, seleziona almeno un candidato.');
  }

  if (errors.value.length > 0) {
    return;
  }

  // Create votes array
  const votesToSend = [];

  // Add candidate votes
  selectedCandidates.value.forEach(candidateId => {
    votesToSend.push({
      election_id: props.election.id,
      type: 'candidate',
      questionId: props.election.questions[0].id,
      selectedId: candidateId,
      written_text: props.candidates.find(c => c.id === candidateId)?.name || ''  // Store candidate name as text
    });
  });

  // Add voter information
  votesToSend.push({
    election_id: props.election.id,
    questionId: props.election.questions[1].id,
    type: 'writing',
    written_text: voter.full_name,
    selectedId: voter.full_name
  });

  votesToSend.push({
    election_id: props.election.id,
    questionId: props.election.questions[2].id,
    type: 'writing',
    written_text: voter.dateOfBirth,
    selectedId: voter.dateOfBirth
  });

  form.votes = votesToSend;
  form.post(route('election.vote', { election: props.election.id }));
};
</script>
