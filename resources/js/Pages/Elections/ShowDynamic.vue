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
        <p>{{ candidates }}</p>
        <!-- Questions -->
        <form @submit.prevent="submitVote">
          <div v-for="question in election.questions" :key="question.id" class="mb-10">
            
            <h2 class="text-lg pb-4">{{ question.text }}</h2>
            
            <!-- Error message for each question -->
            <div v-if="validationErrors[question.id]" class="text-error mb-2">
              {{ validationErrors[question.id] }}
            </div>

            <div v-if="question.type === 'options'">
              <div class="form-control mb-2" v-for="option in question.options" :key="option.id">
                <label class="label cursor-pointer">
                  <span class="label-text">{{ option.text }}</span>
                  <input type="radio"
                  v-model="selectedVotes[question.id]"
                  :value="option.id" class="radio radio-secondary"
                  @change="clearValidationError(question.id)" />
                </label>
              </div>
            </div>
            <div v-if="question.type === 'candidates'">
              <div class="form-control mb-2" v-for="candidate in question.candidates" :key="candidate.id">
                <label class="label cursor-pointer">
                  <span class="label-text">{{ candidate.name }} {{ candidate.description }}</span>
                  <input 
                    type="checkbox"
                    :name="'candidate_' + candidate.id"
                    :value="candidate.id"
                    :checked="isSelected(question.id, candidate.id)"
                    @change="handleCandidateSelection($event, question.id, candidate.id)"
                    :disabled="isMaxVotesReached(question.id) && !isSelected(question.id, candidate.id)"
                  />
                </label>
              </div>
              <div class="text-sm text-info mt-2">
                Hai selezionato {{ getSelectedCount(question.id) }} candidati su {{ election.max_votes }} disponibili
              </div>
            </div>
            <div v-if="question.type === 'writing'">
              <textarea
              class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"
              rows="3"
              v-model="selectedVotes[question.id]"
              placeholder="Scrivi qui"
              @input="clearValidationError(question.id)"
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
  
  const selectedVotes = reactive({});
  const validationErrors = reactive({});
  
  const form = useForm({
    votes: []
  });
  
  const getSelectedCount = (questionId) => {
    return selectedVotes[questionId]?.length || 0;
  };
  
  const isSelected = (questionId, candidateId) => {
    return selectedVotes[questionId]?.includes(candidateId) || false;
  };
  
  const handleCandidateSelection = (event, questionId, candidateId) => {
    if (!selectedVotes[questionId]) {
      selectedVotes[questionId] = [];
    }

    if (event.target.checked) {
      if (selectedVotes[questionId].length < election.max_votes) {
        selectedVotes[questionId].push(candidateId);
      } else {
        event.target.checked = false;
      }
    } else {
      selectedVotes[questionId] = selectedVotes[questionId].filter(id => id !== candidateId);
    }
    clearValidationError(questionId);
  };
  
  const isMaxVotesReached = (questionId) => {
    return (selectedVotes[questionId]?.length || 0) >= election.max_votes;
  };
  
  const validateForm = () => {
    let isValid = true;
    
    // Clear all previous validation errors
    Object.keys(validationErrors).forEach(key => delete validationErrors[key]);
    
    // Validate each question
    election.questions.forEach(question => {
      if (!selectedVotes[question.id] || 
          (question.type === 'candidates' && selectedVotes[question.id].length === 0)) {
        validationErrors[question.id] = 'Per favore seleziona almeno un\'opzione';
        isValid = false;
      }
    });
    
    return isValid;
  };
  
  const submitVote = () => {
    if (!validateForm()) {
      return;
    }

    const votesArray = [];
    for (const [questionId, selectedIds] of Object.entries(selectedVotes)) {
      const question = election.questions.find(q => q.id === parseInt(questionId));
      if (question) {
        if (question.type === 'candidates' && Array.isArray(selectedIds)) {
          // Handle multiple candidate selections
          selectedIds.forEach(candidateId => {
            votesArray.push({
              questionId: question.id,
              type: 'candidate',
              selectedId: candidateId
            });
          });
        } else {
          // Handle other question types
          votesArray.push({
            questionId: question.id,
            type: question.type === 'options' ? 'option' : 'writing',
            selectedId: selectedIds
          });
        }
      }
    }

    form.votes = votesArray;
    form.post(route('election.vote', { election: election.id }));
  };
  
  const clearValidationError = (questionId) => {
    delete validationErrors[questionId];
  };
  
  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('it-IT', options);
  };
  
  </script>
  
  
  