<template>
    <AppLayout title="Modifica lavoratore">
        <div class="bg-base-200">
            <h1 class="text-4xl p-4">Modifica lavoratore</h1>
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
                                        <div v-if="imagePreview && !form.remove_existing_image" class="mb-4">
                                            <img 
                                                :src="imagePreview" 
                                                :alt="worker.name"
                                                class="mx-auto h-32 w-32 object-cover rounded-full"
                                            />
                                            <button @click="removeImage" type="button" class="mt-2 text-sm text-red-500 hover:text-red-700">Rimuovi immagine</button>
                                        </div>
                                        <div v-else class="mt-4 flex text-sm leading-6 text-gray-400">
                                            <label for="image-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                                                <span>Carica una foto</span>
                                                <input id="image-upload" name="image" type="file" class="sr-only" @change="handleImageUpload" accept="image/*" />
                                            </label>
                                            <p class="pl-1">oppure trascinala qui</p>
                                        </div>
                                        <p class="text-xs leading-5 text-gray-400">PNG o JPG fino a 10MB</p>
                                    </div>
                                </div>
                                <div v-if="imageError || form.errors.profile_picture" class="text-error text-sm mt-1">
                                    {{ imageError || form.errors.profile_picture }}
                                </div>
                            </div>

                            <!-- Contract Type -->
                            <div class="sm:col-span-3">
                                <label for="contract_type" class="block text-sm font-medium leading-6">Tipo di contratto</label>
                                <div class="mt-2">
                                    <select v-model="form.contract_type" class="select select-primary w-full max-w-xs">
                                        <option disabled value="">Seleziona il tipo di contratto</option>
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
                                <label for="job_titles" class="block text-sm font-medium leading-6">Titoli di lavoro per cui si rende disponibile</label>
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
                                <label for="availability" class="block text-sm font-medium leading-6">Periodo di disponibilità (se stagionale)</label>
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
                                <label for="has_car" class="block text-sm font-medium leading-6">Ha un'auto/moto</label>
                                <div class="mt-2">
                                    <input v-model="form.has_car" type="checkbox" class="checkbox checkbox-primary" />
                                    <div v-if="form.errors.has_car" class="text-error text-sm mt-1">{{ form.errors.has_car }}</div>
                                </div>
                            </div>

                            <!-- Languages -->
                            <div class="sm:col-span-3">
                                <label for="languages" class="block text-sm font-medium leading-6">Lingue</label>
                                <div class="mt-2">
                                    <input v-model="form.languages" type="text" placeholder="es: Italiano, Inglese, Tedesco" class="input input-bordered input-primary w-full max-w-xs" />
                                    <div v-if="form.errors.languages" class="text-error text-sm mt-1">{{ form.errors.languages }}</div>
                                </div>
                            </div>

                            <!-- Has HACCP Certificate -->
                            <div class="sm:col-span-3">
                                <label for="has_hccp_certificate" class="block text-sm font-medium leading-6">Ha certificato HACCP</label>
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

                            <!-- Work Experience 
                            <div class="col-span-full">
                                <label for="work_experience" class="block text-sm font-medium leading-6">Esperienza lavorativa</label>
                                <div class="mt-2">
                                    <textarea v-model="form.work_experience" placeholder="Dettagli sull'esperienza lavorativa" class="textarea textarea-primary w-full" rows="3"></textarea>
                                    <div v-if="form.errors.work_experience" class="text-error text-sm mt-1">{{ form.errors.work_experience }}</div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between gap-x-6">
                    <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
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
import { ref, onMounted } from 'vue';

const props = defineProps({
    worker: Object
})

const imagePreview = ref(null);
const imageError = ref('');

let form = useForm({
    id: props.worker.id,
    name: props.worker.name,
    profile_picture: null,
    contract_type: props.worker.contract_type,
    job_titles: props.worker.job_titles,
    description: props.worker.description,
    residence: props.worker.residence,
    availability_start: props.worker.availability_start,
    availability_end: props.worker.availability_end,
    has_car: props.worker.has_car,
    languages: props.worker.languages,
    has_hccp_certificate: props.worker.has_hccp_certificate,
    education: props.worker.education,
    work_experience: props.worker.work_experience,
    _method: 'PUT',
    remove_existing_image: false
})

onMounted(() => {
    if (props.worker.media && props.worker.media.filepath) {
        imagePreview.value = `/storage/${props.worker.media.filepath}`;
    }
});

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    imageError.value = ''; // Clear any previous errors
    
    if (file) {
        // Check file size before upload (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            imageError.value = 'L\'immagine non può superare i 10MB';
            event.target.value = ''; // Reset file input
            return;
        }

        // Check file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            imageError.value = 'Il file deve essere un\'immagine (jpg, jpeg, png, gif, webp)';
            event.target.value = ''; // Reset file input
            return;
        }

        form.profile_picture = file;
        form.remove_existing_image = false;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.profile_picture = null;
    form.remove_existing_image = true;
    imagePreview.value = null;
    imageError.value = ''; // Clear any errors when removing image
};

const submit = () => {
    form.post(route('admin.workers.update', {id: form.id}), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            imageError.value = ''; // Reset error message
        },
        onError: (errors) => {
            if (errors.profile_picture) {
                const fileInput = document.getElementById('image-upload');
                if (fileInput) fileInput.value = '';
                
                if (!props.worker.media?.filepath) {
                    imagePreview.value = null;
                    form.profile_picture = null; // Clear the form value
                } else {
                    // Restore original image preview
                    imagePreview.value = `/storage/${props.worker.media.filepath}`;
                    form.profile_picture = null; // Clear the form value
                    form.remove_existing_image = false; // Reset remove flag
                }
                
                imageError.value = errors.profile_picture; // Set the error message
            }
        }
    });
}

const destroy = () => {
    if (confirm('Sei sicuro di voler cancellare questo lavoratore?')) {
        form.delete(route('admin.workers.destroy', {id: form.id}));
    }
}
</script>
