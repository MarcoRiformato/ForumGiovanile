<template>
    <AppLayout title="Modifica elezione step 2">
    <div class="bg-base-200 p-4">
        <h1 class="text-4xl mb-4">Modifica Domande</h1>
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
                <button @click="$inertia.visit(route('admin.elections.step1', {id: form.id}))" type="button" class="btn btn-secondary">Indietro</button>
                <button @click="saveChangesStep2" type="button" class="btn btn-success" v-if="isChanged">Salva</button>
                <button @click="$inertia.visit(route('admin.elections.index'))" type="button" class="btn btn-primary">Annulla</button>
            </div>
        </form>
    </div>
    </AppLayout>
    </template>
    
    <script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { useForm } from '@inertiajs/vue3';
    import { ref, watchEffect } from 'vue';
    
    const props = defineProps({
        election: Object
    });
    
    // Original questions for comparison
    const originalQuestions = JSON.parse(JSON.stringify(props.election.questions));
    
    const electionId = ref(props.election.id);
    
    let form = useForm({
        id: props.election.id,
        questions: props.election.questions
    });
    
    const isChanged = ref(false); // Track changes
    
    // Watch for changes in the form
    watchEffect(() => {
        isChanged.value = JSON.stringify(originalQuestions) !== JSON.stringify(form.questions);
    });
    
    const addQuestion = () => {
        form.questions.push({
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
    
    const saveChangesStep2 = () => {
    form.put(route('admin.elections.updateStep2', { id: electionId.value }), {
        onSuccess: () => {
            isChanged.value = false; // Reset the change tracker
            console.log('Questions updated successfully');
        },
        onError: (errors) => {
            console.log('Failed to update questions:', errors);
        }
    });
};

    </script>
    
    