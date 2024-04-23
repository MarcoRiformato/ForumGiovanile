<template>
    <AppLayout title="Modifica posizione">
        <div class="bg-base-200">
            <h1 class="text-4xl p-4">Modifica posizione</h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Titolo -->
                            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                                <div class="sm:col-span-3">
                                    <label for="lavoro" class="block text-sm font-medium leading-6">Titolo</label>
                                    <div class="mt-2">
                                        <input v-model="form.lavoro" type="text" placeholder="es: 'cameriere', 'barista', 'sviluppatore'" class="input input-bordered input-primary w-full max-w-xs" />
                                    </div>
                                </div>
                            </div>

                            <!-- Descrizione -->
                            <div class="col-span-full">
                                <label for="descrizione" class="block text-sm font-medium leading-6">Descrizione</label>
                                <div class="mt-2">
                                    <textarea v-model="form.descrizione" rows="3" class="block w-full textarea textarea-primary"></textarea>
                                </div>
                            </div>

                            <!-- Azienda -->
                            <div class="col-span-full">
                                <label for="azienda" class="block text-sm font-medium leading-6">Nome dell'azienda</label>
                                <div class="mt-2">
                                    <input v-model="form.azienda" type="text" placeholder="Quale azienda offre questo lavoro?" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Luogo -->
                            <div class="col-span-full">
                                <label for="luogo" class="block text-sm font-medium leading-6">Luogo</label>
                                <div class="mt-2">
                                    <input v-model="form.luogo" type="text" placeholder="Dove dovrà lavorare il dipendente?" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>

                            <!-- Stipendio -->
                            <div class="col-span-full">
                                <label for="stipendio" class="block text-sm font-medium leading-6">Retribuzione offerta</label>
                                <div class="mt-2">
                                    <input v-model="form.stipendio" type="text" placeholder="es: '€ 1400-1600', '€ 7/ora', 'su accordo'" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between gap-x-6">
                    <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
                    <button @click="$inertia.visit(route('admin.jobs.index'))" type="button" class="btn btn-secondary">Annulla</button>
                    <button type="submit" :disabled="form.processing" class="btn btn-primary">Salva</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    job: Object
})

let form = useForm({
    id: props.job.id,
    lavoro: props.job.lavoro,
    azienda: props.job.azienda,
    luogo: props.job.luogo,
    descrizione: props.job.descrizione,
    stipendio: props.job.stipendio
})

const submit = () => {
    form.put(route('admin.jobs.update', {id: form.id}), {
        onSuccess: () => {
            $inertia.visit(route('admin.jobs.index'));
        }
    });
}

const destroy = () => {
    form.delete(route('admin.jobs.destroy', {id: form.id}));
}
</script>

