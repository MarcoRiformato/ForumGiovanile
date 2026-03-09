<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    election: Object,
});

// State for responses: { [questionId]: value }
// Candidates: Array of IDs
// Options: Single ID
// Writing: String
const responses = ref({});

onMounted(() => {
    props.election.questions.forEach(q => {
        if (q.type === 'candidates') {
            responses.value[q.id] = [];
        } else if (q.type === 'options') {
            responses.value[q.id] = null;
        } else if (q.type === 'writing') {
            responses.value[q.id] = '';
        }
    });
});

const isShakingBar = ref(false);

const toggleCandidate = (questionId, candidateId) => {
    const selected = responses.value[questionId] || [];
    const index = selected.indexOf(candidateId);
    
    if (index > -1) {
        selected.splice(index, 1);
    } else {
        const limit = parseInt(props.election.max_votes) || 1;
        // Check total candidates across all questions
        const totalSelected = Object.values(responses.value)
            .filter((val, idx) => props.election.questions[idx]?.type === 'candidates')
            .flat().length;

        if (selected.length < limit) {
             selected.push(candidateId);
        } else {
            isShakingBar.value = true;
            setTimeout(() => isShakingBar.value = false, 500);
        }
    }
};

const isSelected = (questionId, candidateId) => {
    return responses.value[questionId]?.includes(candidateId);
};

const isConfirming = ref(false);

const selectedItems = computed(() => {
    const list = [];
    props.election.questions.forEach(q => {
        const val = responses.value[q.id];
        if (!val) return;

        if (q.type === 'candidates') {
            q.candidates.filter(c => val.includes(c.id)).forEach(c => {
                list.push({ type: 'Candidato', text: c.name });
            });
        } else if (q.type === 'options' && val) {
            const opt = q.options.find(o => o.id === val);
            if (opt) list.push({ type: 'Opzione', text: opt.text });
        } else if (q.type === 'writing' && val.trim()) {
            list.push({ type: q.text, text: val });
        }
    });
    return list;
});

const isFormValid = computed(() => {
    // Check if all questions are answered
    return props.election.questions.every(q => {
        const val = responses.value[q.id];
        if (q.type === 'candidates') return val && val.length > 0;
        if (q.type === 'options') return !!val;
        if (q.type === 'writing') return val && val.trim().length > 0;
        return true;
    });
});

const openConfirmation = () => {
    if (isFormValid.value) {
        isConfirming.value = true;
    } else {
        isShakingBar.value = true;
        setTimeout(() => isShakingBar.value = false, 500);
    }
};

const submitVote = () => {
    isConfirming.value = false;
    
    const votes = [];
    props.election.questions.forEach(q => {
        const val = responses.value[q.id];
        if (q.type === 'candidates') {
            val.forEach(id => {
                votes.push({ questionId: q.id, type: 'candidate', selectedId: id });
            });
        } else if (q.type === 'options') {
            votes.push({ questionId: q.id, type: 'option', selectedId: val });
        } else if (q.type === 'writing') {
            votes.push({ questionId: q.id, type: 'writing', selectedId: val });
        }
    });

    router.post(route('election.vote', props.election.id), { votes });
};

</script>

<template>
    <AppLayout :title="election.name">
        <div class="min-h-screen relative overflow-hidden bg-slate-950 font-sans antialiased text-slate-200">
            <!-- Serious Ambient Background -->
            <div class="fixed inset-0 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-indigo-900/10 blur-[120px] rounded-full"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-slate-900/10 blur-[120px] rounded-full"></div>
            </div>

            <div class="relative z-10 py-12 md:py-24 px-6 max-w-[1400px] mx-auto">
                <!-- Advanced Header Section -->
                <div class="text-center mb-16 md:mb-24 space-y-6">
                    <h1 class="text-5xl md:text-8xl font-black tracking-tighter leading-tight text-white animate-title">
                        {{ election.name }}
                    </h1>
                    
                    <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto font-normal opacity-90 animate-fade-in">
                        {{ election.description }}
                    </p>
                </div>

                <!-- Main Content -->
                <div class="max-w-4xl mx-auto space-y-24 pb-32">
                    <div v-for="question in election.questions" :key="question.id" class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span class="w-1 h-8 bg-indigo-500 rounded-full"></span>
                            <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">{{ question.text }}</h2>
                        </div>
                        
                        <!-- CANDIDATES TYPE -->
                        <div v-if="question.type === 'candidates'" class="grid md:grid-cols-2 lg:grid-cols-2 gap-6">
                            <div 
                                v-for="candidate in question.candidates" 
                                :key="candidate.id"
                                @click="toggleCandidate(question.id, candidate.id)"
                                class="group relative bg-slate-900/40 border transition-all duration-300 cursor-pointer overflow-hidden p-6 rounded-2xl"
                                :class="[
                                    isSelected(question.id, candidate.id) 
                                        ? 'border-indigo-500 ring-1 ring-indigo-500 shadow-xl' 
                                        : 'border-white/5 hover:border-white/20'
                                ]"
                            >
                                <div class="flex items-center gap-6 relative z-10">
                                    <div class="relative w-16 h-16 shrink-0">
                                        <div 
                                            class="w-full h-full rounded-xl flex items-center justify-center text-2xl font-bold transition-all duration-300"
                                            :class="isSelected(question.id, candidate.id) ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400'"
                                        >
                                            {{ candidate.name.charAt(0) }}
                                        </div>
                                        <div v-if="isSelected(question.id, candidate.id)" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center border-2 border-slate-950">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-white mb-1">{{ candidate.name }}</h3>
                                        <p class="text-sm text-slate-400 line-clamp-2">{{ candidate.description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OPTIONS TYPE -->
                        <div v-else-if="question.type === 'options'" class="grid gap-4">
                            <label 
                                v-for="option in question.options" 
                                :key="option.id"
                                class="group flex items-center gap-4 p-4 rounded-xl border transition-all cursor-pointer"
                                :class="[
                                    responses[question.id] === option.id 
                                        ? 'bg-indigo-600/10 border-indigo-500' 
                                        : 'bg-slate-900/40 border-white/5 hover:border-white/20'
                                ]"
                            >
                                <input 
                                    type="radio" 
                                    :name="'q-' + question.id" 
                                    :value="option.id" 
                                    v-model="responses[question.id]"
                                    class="w-5 h-5 text-indigo-600 bg-slate-800 border-white/10 focus:ring-indigo-500"
                                />
                                <span class="text-lg text-white font-medium">{{ option.text }}</span>
                            </label>
                        </div>

                        <!-- WRITING TYPE -->
                        <div v-else-if="question.type === 'writing'" class="max-w-xl">
                            <input 
                                type="text" 
                                v-model="responses[question.id]"
                                placeholder="Inserisci la tua risposta..."
                                class="w-full bg-slate-900/40 border border-white/5 rounded-xl px-6 py-4 text-lg text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"
                            />
                        </div>
                    </div>
                </div>

                <!-- Bottom Sticky Action Bar -->
                <div class="fixed bottom-0 left-0 right-0 p-6 md:p-8 z-40 pointer-events-none">
                    <div 
                        class="max-w-4xl mx-auto glass-clear rounded-2xl border border-white/20 shadow-2xl p-4 md:p-6 flex items-center justify-between gap-6 pointer-events-auto transform transition-all duration-500" 
                        :class="[
                            isFormValid ? 'translate-y-0 opacity-100' : 'translate-y-32 opacity-0',
                            isShakingBar ? 'animate-shake' : ''
                        ]"
                    >
                        <div class="flex-1 space-y-1">
                            <div class="text-sm font-bold text-white tracking-wide uppercase">Tutto pronto!</div>
                            <div class="text-xs text-slate-400">Verifica i tuoi dati prima di procedere.</div>
                        </div>
                        
                        <button 
                            @click="openConfirmation"
                            class="bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-3 rounded-xl font-bold transition-all shadow-lg active:scale-95"
                        >
                            Invia Voto
                        </button>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <teleport to="body">
                    <div v-if="isConfirming" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-950/90 backdrop-blur-sm">
                        <div class="bg-slate-900 border border-white/10 p-8 rounded-3xl max-w-lg w-full shadow-2xl animate-fade-in-up">
                            <h3 class="text-3xl font-bold text-white mb-6 text-center">Conferma riepilogo</h3>
                            
                            <div class="space-y-4 mb-8 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                                <div v-for="(item, idx) in selectedItems" :key="idx" class="bg-slate-800/50 rounded-xl p-4 border border-white/5">
                                    <div class="text-[10px] uppercase tracking-widest text-indigo-400 font-bold mb-1">{{ item.type }}</div>
                                    <div class="text-white font-medium">{{ item.text }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button @click="isConfirming = false" class="px-6 py-4 rounded-xl border border-white/10 text-slate-300 font-bold hover:bg-white/5 transition-all">Annulla</button>
                                <button @click="submitVote" class="px-6 py-4 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg">Invia Ora</button>
                            </div>
                        </div>
                    </div>
                </teleport>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;400;700;800;900&display=swap');

:deep(body) { font-family: 'Plus Jakarta Sans', sans-serif !important; }

.glass-clear {
    background: rgba(255, 255, 255, 0.03); 
    backdrop-filter: blur(40px) saturate(200%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
}

@keyframes title {
    from { opacity: 0; transform: translateY(40px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.animate-title { animation: title 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 1.5s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 0.8; }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-4px); }
    40% { transform: translateX(4px); }
    60% { transform: translateX(-4px); }
    80% { transform: translateX(4px); }
}

.animate-shake {
    animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both;
    border-color: rgba(239, 68, 68, 0.5) !important;
}

.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
</style>