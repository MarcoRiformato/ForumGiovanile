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
                                    <input v-model="form.name" type="text" class="input input-bordered input-primary w-full max-w-xs" />
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
                            </div>

                            <!-- Contract Type -->
                            <div class="sm:col-span-3">
                                <label for="contract_type" class="block text-sm font-medium leading-6">Tipo di contratto</label>
                                <div class="mt-2">
                                    <input v-model="form.contract_type" type="text" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Job Titles -->
                            <div class="sm:col-span-3">
                                <label for="job_titles" class="block text-sm font-medium leading-6">Titoli di lavoro</label>
                                <div class="mt-2">
                                    <input v-model="form.job_titles" type="text" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium leading-6">Descrizione</label>
                                <div class="mt-2">
                                    <textarea v-model="form.description" class="textarea textarea-primary w-full" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Residence -->
                            <div class="sm:col-span-3">
                                <label for="residence" class="block text-sm font-medium leading-6">Residenza</label>
                                <div class="mt-2">
                                    <input v-model="form.residence" type="text" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="sm:col-span-3">
                                <label for="availability" class="block text-sm font-medium leading-6">Disponibilità</label>
                                <div class="mt-2">
                                    <input v-model="form.availability" type="date" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Has Car -->
                            <div class="sm:col-span-3">
                                <label for="has_car" class="block text-sm font-medium leading-6">Ha un'auto</label>
                                <div class="mt-2">
                                    <input v-model="form.has_car" type="checkbox" class="checkbox checkbox-primary" />
                                </div>
                            </div>

                            <!-- Work Experience -->
                            <div class="col-span-full">
                                <label for="work_experience" class="block text-sm font-medium leading-6">Esperienza lavorativa</label>
                                <div class="mt-2">
                                    <textarea v-model="form.work_experience" class="textarea textarea-primary w-full" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Languages -->
                            <div class="sm:col-span-3">
                                <label for="languages" class="block text-sm font-medium leading-6">Lingue</label>
                                <div class="mt-2">
                                    <input v-model="form.languages" type="text" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Has HCCP Certificate -->
                            <div class="sm:col-span-3">
                                <label for="has_hccp_certificate" class="block text-sm font-medium leading-6">Ha certificato HCCP</label>
                                <div class="mt-2">
                                    <input v-model="form.has_hccp_certificate" type="checkbox" class="checkbox checkbox-primary" />
                                </div>
                            </div>

                            <!-- Education -->
                            <div class="sm:col-span-3">
                                <label for="education" class="block text-sm font-medium leading-6">Istruzione</label>
                                <div class="mt-2">
                                    <input v-model="form.education" type="text" class="input input-bordered input-primary w-full max-w-xs" />
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
    languages: '',
    has_hccp_certificate: false,
    education: '',
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

    form.post(route('admin.workers.store'), {
        body: formData,
        onSuccess: () => {
            form.reset();
            $inertia.visit(route('admin.workers.index'));
        }
    });
};
</script>