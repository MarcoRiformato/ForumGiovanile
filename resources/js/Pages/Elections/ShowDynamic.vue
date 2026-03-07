<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    election: Object,
});

const selected = ref([]);
const isShakingBar = ref(false);

const toggleCandidate = (candidateId) => {
    const index = selected.value.indexOf(candidateId);
    if (index > -1) {
        selected.value.splice(index, 1);
    } else {
        const limit = parseInt(props.election.max_votes);
        if (selected.value.length < limit) {
            selected.value.push(candidateId);
        } else {
            console.log('Selection limit reached:', limit);
            // Trigger shake effect on the action bar
            isShakingBar.value = true;
            setTimeout(() => {
                isShakingBar.value = false;
            }, 500);
        }
    }
};

const isSelected = (candidateId) => selected.value.includes(candidateId);

const isConfirming = ref(false);

const selectedCandidateNames = computed(() => {
    return props.election.questions.flatMap(q => q.candidates)
        .filter(c => selected.value.includes(c.id))
        .map(c => c.name);
});

const openConfirmation = () => {
    if (selected.value.length > 0) {
        isConfirming.value = true;
    }
};

const submitVote = () => {
    isConfirming.value = false;
    // Using Inertia POST
    router.post(route('election.vote', props.election.id), {
        votes: selected.value.map(id => ({
            questionId: props.election.questions.find(q => q.candidates.some(c => c.id === id)).id,
            type: 'candidate',
            selectedId: id
        }))
    });
};

const progress = computed(() => (selected.value.length / props.election.max_votes) * 100);
const circumference = 2 * Math.PI * 88;
const dashOffset = computed(() => circumference - (progress.value / 100) * circumference);

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

                <!-- Strategic Layout: Main Content vs Sticky Status -->
                <div class="max-w-6xl mx-auto">
                    <!-- Left: Questions & Grid -->
                    <div class="space-y-24">
                        <div v-for="question in election.questions.filter(q => q.candidates && q.candidates.length > 0)" :key="question.id" class="space-y-8">
                            <div class="flex items-center gap-4">
                                <span class="w-1 h-8 bg-indigo-500 rounded-full"></span>
                                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">{{ question.text }}</h2>
                            </div>
                            
                            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                                <div 
                                    v-for="candidate in question.candidates" 
                                    :key="candidate.id"
                                    @click="toggleCandidate(candidate.id)"
                                    class="group relative bg-slate-900/40 border transition-all duration-300 cursor-pointer overflow-hidden p-6 rounded-2xl"
                                    :class="[
                                        isSelected(candidate.id) 
                                            ? 'border-indigo-500 ring-1 ring-indigo-500 shadow-xl' 
                                            : 'border-white/5 hover:border-white/20'
                                    ]"
                                >
                                    <div class="flex items-center gap-6 relative z-10">
                                        <div class="relative w-20 h-20 shrink-0">
                                            <div 
                                                class="w-full h-full rounded-xl flex items-center justify-center text-3xl font-bold transition-all duration-300"
                                                :class="isSelected(candidate.id) ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400'"
                                            >
                                                {{ candidate.name.charAt(0) }}
                                            </div>
                                            
                                            <!-- Checkmark Badge -->
                                            <div 
                                                v-if="isSelected(candidate.id)"
                                                class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center border-2 border-slate-950"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg md:text-xl font-bold text-white leading-tight mb-1">
                                                {{ candidate.name }}
                                            </h3>
                                            <p class="text-sm text-slate-400 line-clamp-2 leading-snug">
                                                {{ candidate.description }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Sticky Action Bar -->
                    <div class="fixed bottom-0 left-0 right-0 p-6 md:p-8 z-40 pointer-events-none">
                        <div 
                            class="max-w-4xl mx-auto glass-clear rounded-2xl border border-white/20 shadow-2xl p-4 md:p-6 flex items-center justify-between gap-6 pointer-events-auto transform transition-all duration-500" 
                            :class="[
                                selected.length > 0 ? 'translate-y-0 opacity-100' : 'translate-y-32 opacity-0',
                                isShakingBar ? 'animate-shake' : ''
                            ]"
                        >
                            
                            <div class="flex-1 space-y-1">
                                <div class="text-sm font-bold text-white">
                                    {{ selected.length }} {{ selected.length === 1 ? 'candidato selezionato' : 'candidati selezionati' }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    Preferenze espresse: {{ selected.length }} di {{ election.max_votes }}
                                </div>
                            </div>
                            
                            <button 
                                @click="openConfirmation"
                                :disabled="selected.length === 0"
                                class="bg-indigo-600 hover:bg-indigo-500 disabled:bg-slate-800 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg active:scale-95 disabled:opacity-50"
                            >
                                Invia Voto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <teleport to="body">
                    <div v-if="isConfirming" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-950/80 backdrop-blur-sm">
                        <div class="bg-slate-900 border border-white/10 p-8 rounded-3xl max-w-md w-full shadow-2xl animate-fade-in-up">
                            <h3 class="text-2xl font-bold text-white mb-6 text-center">Conferma il tuo voto</h3>
                            
                            <div class="space-y-4 mb-8">
                                <p class="text-slate-400 text-sm mb-4">Stai votando per i seguenti candidati:</p>
                                <div class="bg-slate-800/50 rounded-2xl p-4 border border-white/5">
                                    <ul class="space-y-2">
                                        <li v-for="name in selectedCandidateNames" :key="name" class="flex items-center gap-3 text-white font-medium">
                                            <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                            {{ name }}
                                        </li>
                                    </ul>
                                </div>
                                <p class="text-xs text-slate-500 text-center italic">Una volta confermato, il tuo voto non potrà essere modificato.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <button 
                                    @click="isConfirming = false"
                                    class="px-6 py-3 rounded-xl border border-white/10 text-slate-300 font-bold hover:bg-white/5 transition-all"
                                >
                                    Annulla
                                </button>
                                <button 
                                    @click="submitVote"
                                    class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-all shadow-lg shadow-indigo-600/20"
                                >
                                    Conferma
                                </button>
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

:deep(body) {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}

.glass-card {
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
}

.glass-clear {
    background: rgba(255, 255, 255, 0.03); /* Crystal clear glass tint */
    backdrop-filter: blur(40px) saturate(200%);
    -webkit-backdrop-filter: blur(40px) saturate(200%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
}

/* Remove unused ambient animations since we now use gradient blobs */

@keyframes title {
    from { opacity: 0; transform: translateY(40px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes shimmer {
    0% { background-position: 100% 0%; }
    100% { background-position: -100% 0%; }
}


.animate-title { animation: title 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
.animate-shimmer { animation: shimmer 3s linear infinite; }

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
    box-shadow: 0 0 30px rgba(239, 68, 68, 0.2) !important;
    transition: none !important;
}

/* Custom scrollbar for premium feel */
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>