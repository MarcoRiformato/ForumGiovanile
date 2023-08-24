<template>
    <AppLayout title="Crea elezione - domande">
        <div class="bg-base-200 p-4">
            <h1 class="text-4xl mb-4">Crea Domande</h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
                <div v-for="(question, index) in form.questions" :key="index" class="border-b border-gray-300 pb-12 mb-12">
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="relative">
                            <label for="question" class="block text-sm font-medium leading-6 text-gray-400">Domanda</label>
                            <div class="mt-2">
                                <input v-model="question.text" type="text" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                            </div>
                            <button @click="deleteQuestion(index)" type="button" class="absolute right-0 top-0 p-2 text-red-600">❌</button>
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium leading-6 text-gray-400">Tipo</label>
                            <div class="mt-2 pb-6">
                                <select v-model="question.type" class="block w-full rounded-md py-1.5 text-gray-500 shadow-sm sm:text-sm sm:leading-6">
                                    <option value="options">Options</option>
                                    <option value="candidates">Candidates</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Options -->
                    <div v-if="question.type === 'options'">
                        <div v-for="(option, optIndex) in question.options" :key="optIndex" class="relative">
                            <div class="mt-2">
                                <input v-model="option.text" type="text" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                            </div>
                            <button @click="deleteOption(index, optIndex)" type="button" class="absolute right-0 top-0 p-2 text-red-600">❌</button>
                        </div>
                        <button @click="addOption(index)" type="button" class="btn btn-secondary mt-4">Aggiungi Opzione</button>
                    </div>

                    <!-- Candidates -->
                    <div v-if="question.type === 'candidates'">
                        <div v-for="(candidate, candIndex) in question.candidates" :key="candIndex" class="relative pb-20">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-400">Nome</label>
                            <div class="mt-2">
                                <input v-model="candidate.name" type="text" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                            </div>
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-400">Descrizione</label>
                            <div class="mt-2">
                                <textarea v-model="candidate.description" rows="3" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            <button @click="deleteCandidate(index, candIndex)" type="button" class="absolute right-0 top-0 p-2 text-red-600">❌</button>
                        </div>
                        <button @click="addCandidate(index)" type="button" class="btn btn-secondary mt-4">Aggiungi Candidato</button>
                    </div>
                    <hr class="my-8">
                </div>
                <button @click="addQuestion" type="button" class="btn btn-secondary mb-6">Aggiungi Domanda</button>
            <div class="mt-6 flex items-center justify-between gap-x-6">
                <button @click="$inertia.visit(route('admin.elections.create'))" type="button" class="btn btn-secondary">Indietro</button>
                <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary">Salva</button>
            </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'; // Import reactive

let election = JSON.parse(sessionStorage.getItem('election')) || {};
let form = reactive({ // Make form reactive
    ...election,
    questions: election.questions || []
});

const submit = () => {
    console.log('Saving: ', form);
    sessionStorage.setItem('election', JSON.stringify(form));
    window.location.href = route('admin.elections.review');
};

const addQuestion = () => {
    form.questions.push({ // Access questions directly without value
        text: '',
        type: 'options',
        options: [{ text: '' }],
        candidates: [{ name: '', description: '' }]
    });
};

const addOption = (questionIndex) => {
    form.questions[questionIndex].options.push({ text: '' });
};

const addCandidate = (questionIndex) => {
    form.questions[questionIndex].candidates.push({ name: '', description: '' });
};

const deleteOption = (questionIndex, optionIndex) => {
    form.questions[questionIndex].options.splice(optionIndex, 1);
};

const deleteCandidate = (questionIndex, candidateIndex) => {
    form.questions[questionIndex].candidates.splice(candidateIndex, 1);
};

const deleteQuestion = (questionIndex) => {
    form.questions.splice(questionIndex, 1);
};


</script>
