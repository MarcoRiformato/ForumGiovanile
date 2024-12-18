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
            <h2 class="text-lg font-semibold pb-4">{{ question.text }}</h2>
            
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
                  :value="option.id" 
                  class="radio radio-secondary"
                  @change="clearValidationError(question.id)" />
                </label>
              </div>
            </div>

            <div v-if="question.type === 'candidates'" class="grid gap-6">
              <div v-for="candidate in randomizedCandidates[question.id]" 
                   :key="candidate.id" 
                   class="relative flex flex-col bg-base-100 shadow-xl hover:shadow-2xl transition-shadow rounded-lg overflow-hidden">
                <div class="flex">
                  <!-- Image container -->
                  <div class="w-1/3 max-w-[200px] min-w-[150px] h-[200px] flex-shrink-0 bg-gray-100">
                    <img 
                      v-if="candidate.image_path"
                      :src="`${candidate.image_path}`"
                      :alt="candidate.name"
                      class="w-full h-full object-cover"
                    />
                    <div 
                      v-else
                      class="w-full h-full flex items-center justify-center bg-gray-200"
                    >
                      <svg 
                        class="w-24 h-24 text-gray-400" 
                        fill="currentColor" 
                        viewBox="0 0 24 24"
                      >
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8c0 2.208-1.79 4-3.998 4-2.208 0-3.998-1.792-3.998-4s1.79-4 3.998-4c2.208 0 3.998 1.792 3.998 4z" />
                      </svg>
                    </div>
                  </div>
                  <!-- Content container -->
                  <div class="flex-1 p-4 flex flex-col h-[200px]">
                    <h3 class="text-lg font-bold mb-2">{{ candidate.name }}</h3>
                    <p class="text-gray-300 flex-1 overflow-y-auto">
                      {{ candidate.description }}
                    </p>
                  </div>
                </div>
                
                <!-- Selection controls in a separate row -->
                <div class="flex items-center justify-end gap-2 p-4 bg-blue-900 mt-auto">
                  <span class="text-sm">Seleziona candidato</span>
                  <label class="cursor-pointer">
                    <input 
                      type="checkbox"
                      :name="'candidate_' + candidate.id"
                      :value="candidate.id"
                      :checked="isSelected(question.id, candidate.id)"
                      @change="handleCandidateSelection($event, question.id, candidate.id)"
                      :disabled="isMaxVotesReached(question.id) && !isSelected(question.id, candidate.id)"
                      class="checkbox checkbox-primary"
                    />
                  </label>
                </div>
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
  import { ref, reactive, onMounted } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  
  const { election } = defineProps({
    election: Object,
  });
  
  const selectedVotes = reactive({});
  const validationErrors = reactive({});
  const randomizedCandidates = reactive({});
  
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
  
  const shuffleArray = (array) => {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
  };
  
  onMounted(() => {
    election.questions.forEach(question => {
      if (question.type === 'candidates') {
        randomizedCandidates[question.id] = shuffleArray([...question.candidates]);
      }
    });
  });
  
  </script>
  
  <style>
  .line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  </style>
  
  
  