<template>
    <AppLayout title="Crea nuovo collaboratore">
        <div class="bg-base-200">
            <h1 class="text-4xl p-4">Crea nuovo collaboratore</h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit" enctype="multipart/form-data">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Name -->
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-6">Nome</label>
                                <div class="mt-2">
                                    <input v-model="form.name" type="text" placeholder="Nome completo del collaboratore" class="input input-bordered input-primary w-full max-w-xs" />
                                    <div v-if="form.errors.name" class="text-error text-sm mt-1">{{ form.errors.name }}</div>
                                </div>
                            </div>

                            <!-- Profile Picture -->
                            <div class="sm:col-span-3">
                                <label for="cover-photo" class="block text-sm font-medium leading-6">Foto profilo</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">
                                    <div class="text-center">
                                        <div class="mt-4 flex text-sm leading-6 text-gray-400">
                                            <label for="image-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                                                <span>Carica una foto</span>
                                                <input id="image-upload" name="image" type="file" class="sr-only" @change="form.profile_picture = $event.target.files[0]" />
                                            </label>
                                            <p class="pl-1">oppure trascinala qui</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-400">PNG o JPG fino a 10MB</p>
                                    </div>
                                </div>
                                <div v-if="form.errors.profile_picture" class="text-error text-sm mt-1">{{ form.errors.profile_picture }}</div>
                            </div>

                            <!-- Contract Type -->
                            <div class="sm:col-span-3">
                                <label for="contract_type" class="block text-sm font-medium leading-6">Tipo di contratto</label>
                                <div class="mt-2">
                                    <select v-model="form.contract_type" class="select select-primary w-full max-w-xs">
                                        <option disabled selected>Seleziona il tipo di contratto</option>
                                        <option>Tempo pieno</option>
                                        <option>Tempo parziale</option>
                                        <option>A chiamata</option>
                                        <option>Partita IVA</option>
                                        <option>Altro</option>
                                    </select>
                                    <div v-if="form.errors.contract_type" class="text-error text-sm mt-1">{{ form.errors.contract_type }}</div>
                                </div>
                            </div>

                            <!-- Job Titles -->
                            <div class="sm:col-span-3">
                                <label for="job_titles" class="block text-sm font-medium leading-6">Titoli di lavoro</label>
                                <div class="mt-2">
                                    <input v-model="form.job_titles" type="text" placeholder="es: Cameriere, Bagnino, Barista, etc." class="input input-bordered input-primary w-full max-w-xs" />
                                    <div v-if="form.errors.job_titles" class="text-error text-sm mt-1">{{ form.errors.job_titles }}</div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium leading-6">Descrizione</label>
                                <div class="mt-2">
                                    <textarea v-model="form.description" placeholder="Breve descrizione del lavoratore e delle sue esperienze lavorative" class="textarea textarea-primary w-full" rows="3"></textarea>
                                    <div v-if="form.errors.description" class="text-error text-sm mt-1">{{ form.errors.description }}</div>
                                </div>
                            </div>

                            <!-- Residence -->
                            <div class="sm:col-span-3">
                                <label for="residence" class="block text-sm font-medium leading-6">Residenza</label>
                                <div class="mt-2">
                                    <input v-model="form.residence" type="text" placeholder="es: Portoferraio, Porto Azzurro, Schiopparello etc" class="input input-bordered input-primary w-full max-w-xs" />
                                    <div v-if="form.errors.residence" class="text-error text-sm mt-1">{{ form.errors.residence }}</div>
                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="sm:col-span-3">
                                <label for="availability" class="block text-sm font-medium leading-6">Periodo di disponibilità</label>
                                <div class="mt-2 flex space-x-2">
                                    <div>
                                        <input v-model="form.availability_start" type="date" placeholder="Data inizio" class="input input-bordered input-primary w-full max-w-xs" />
                                        <div v-if="form.errors.availability_start" class="text-error text-sm mt-1">{{ form.errors.availability_start }}</div>
                                    </div>
                                    <div>
                                        <input v-model="form.availability_end" type="date" placeholder="Data fine" class="input input-bordered input-primary w-full max-w-xs" />
                                        <div v-if="form.errors.availability_end" class="text-error text-sm mt-1">{{ form.errors.availability_end }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Has Car -->
                            <div class="sm:col-span-3">
                                <label for="has_car" class="block text-sm font-medium leading-6">Ha un'auto</label>
                                <div class="mt-2">
                                    <input v-model="form.has_car" type="checkbox" class="checkbox checkbox-primary" />
                                    <div v-if="form.errors.has_car" class="text-error text-sm mt-1">{{ form.errors.has_car }}</div>
                                </div>
                            </div>

                            <!-- Languages -->
                            <div class="sm:col-span-full">
                                <label class="block text-sm font-medium leading-6 mb-2">Lingue</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div v-for="language in languages" :key="language.id" class="flex items-center space-x-2">
                                        <span class="w-24">{{ language.flag }} {{ language.name }}</span>
                                        <div class="rating rating-md">
                                            <div class="rating">
                                                <input type="radio" :name="`rating-${language.id}`" class="mask mask-star" :value="1" v-model="form.language_ratings[language.id]" />
                                                <input type="radio" :name="`rating-${language.id}`" class="mask mask-star" :value="2" v-model="form.language_ratings[language.id]" />
                                                <input type="radio" :name="`rating-${language.id}`" class="mask mask-star" :value="3" v-model="form.language_ratings[language.id]" />
                                                <input type="radio" :name="`rating-${language.id}`" class="mask mask-star" :value="4" v-model="form.language_ratings[language.id]" />
                                                <input type="radio" :name="`rating-${language.id}`" class="mask mask-star" :value="5" v-model="form.language_ratings[language.id]" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.errors.language_ratings" class="text-error text-sm mt-1">{{ form.errors.language_ratings }}</div>
                            </div>

                            <!-- Has HCCP Certificate -->
                            <div class="sm:col-span-3">
                                <label for="has_hccp_certificate" class="block text-sm font-medium leading-6">Ha certificato HCCP</label>
                                <div class="mt-2">
                                    <input v-model="form.has_hccp_certificate" type="checkbox" class="checkbox checkbox-primary" />
                                    <div v-if="form.errors.has_hccp_certificate" class="text-error text-sm mt-1">{{ form.errors.has_hccp_certificate }}</div>
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="sm:col-span-3">
                                <label for="education" class="block text-sm font-medium leading-6">Istruzione</label>
                                <div class="mt-2">
                                    <input v-model="form.education" type="text" placeholder="es: Laurea, Diploma, etc." class="input input-bordered input-primary w-full max-w-xs" />
                                    <div v-if="form.errors.education" class="text-error text-sm mt-1">{{ form.errors.education }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between gap-x-6">
                    <button @click="$inertia.visit(route('admin.workers.index'))" type="button" class="btn btn-secondary">Annulla</button>
                    <button type="submit" :disabled="form.processing" class="btn btn-primary">Salva</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const languages = [
    { id: 1, name: 'Italiano', flag: '🇮🇹' },
    { id: 2, name: 'English', flag: '🇬🇧' },
    { id: 3, name: 'Deutsch', flag: '🇩🇪' },
    { id: 4, name: 'Français', flag: '🇫🇷' },
    { id: 5, name: 'Nederlands', flag: '🇳🇱' },
    { id: 6, name: 'Español', flag: '🇪🇸' },
    { id: 7, name: 'Русский', flag: '🇷🇺' },
    { id: 8, name: 'Svenska', flag: '🇸🇪' },
    { id: 9, name: 'Dansk', flag: '🇩🇰' },
    { id: 10, name: 'Polski', flag: '🇵🇱' },
];

const form = useForm({
    name: '',
    profile_picture: null,
    contract_type: '',
    job_titles: '',
    description: '',
    residence: '',
    availability: '',
    has_car: false,
    work_experience: '',
    language_ratings: {},
    has_hccp_certificate: false,
    education: '',
});

// Initialize language ratings to 0
languages.forEach(lang => {
    form.language_ratings[lang.id] = 0;
});

const submit = () => {
    const formData = new FormData();
    for (const key in form) {
        if (key === 'profile_picture' && form[key]) {
            formData.append(key, form[key]);
        } else {
            formData.append(key, form[key]);
        }
    }

    // Convert language ratings to the desired format before submitting
    const formattedLanguageRatings = Object.entries(form.language_ratings).map(([id, rating]) => ({
        language_id: parseInt(id),
        proficiency: rating
    }));

    form.post(route('admin.workers.store'), {
        body: formData,
        data: {
            language_ratings: formattedLanguageRatings,
        },
        onSuccess: () => {
            form.reset();
            $inertia.visit(route('admin.workers.index'));
        },
        onError: (errors) => {
            console.error('Form submission errors:', errors);
        }
    });
};
</script>