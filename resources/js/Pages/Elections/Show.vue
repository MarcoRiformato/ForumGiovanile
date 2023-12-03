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

      <!-- Questions -->
      <form @submit.prevent="submitVote">
        <div v-for="question in election.questions" :key="question.id" class="mb-10">
          
          <h2 class="text-lg pb-4">{{ question.text }}</h2>
          <div v-if="question.type === 'options'">
            <div class="form-control mb-2" v-for="option in question.options" :key="option.id">
              <label class="label cursor-pointer">
                <span class="label-text">{{ option.text }}</span>
                <input type="radio"
                v-model="selectedVotes[question.id]"
                :value="option.id" class="radio radio-secondary" />
              </label>
            </div>
          </div>
          <div v-if="question.type === 'candidates'">
            <div class="form-control mb-2" v-for="candidate in question.candidates" :key="candidate.id">
              <label class="label cursor-pointer">
                <span class="label-text">{{ candidate.name }} {{ candidate.description }}</span>
                <input type="radio" 
                v-model="selectedVotes[question.id]"
                :value="candidate.id" class="radio radio-secondary" />
              </label>
            </div>
          </div>
          <div v-if="question.type === 'writing'">
            <textarea
            class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
            rows="3"
            v-model="selectedVotes[question.id]"
            placeholder="Scrivi qui"
            ></textarea>
          </div>
          <br/><hr/>
        </div>
        <button type="submit" class="btn btn-primary">Vota</button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';

const { election } = defineProps({
  election: Object,
});

const reactiveElection = reactive({ ...election });
const selectedVotes = reactive({});
const form = useForm({
  votes: []
});

const submitVote = () => {
  const votesArray = [];
  for (const [questionId, selectedId] of Object.entries(selectedVotes)) {
    const question = reactiveElection.questions.find(q => q.id === parseInt(questionId));
    if (question) {
      let type;
      if (question.type === 'options') type = 'option';
      else if (question.type === 'candidates') type = 'candidate';
      else type = 'writing';
      
      votesArray.push({
        questionId: question.id,
        type,
        selectedId
      });
    }
  }

  form.votes = votesArray;
  form.post(route('election.vote', { election: election.id }));
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('it-IT', options); // Italian format
};

</script>


