<template>
    <AppLayout title="Modifica documento">
        <div class="bg-base-200">
            <h1 class="text-4xl p-4">Modifica documento</h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Title -->
                            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                                <div class="sm:col-span-3">
                                <label for="username" class="block text-sm font-medium leading-6">Titolo</label>
                                <div class="mt-2">
                                    <span class="flex select-none
                                    items-center pl-3 sm:text-sm"> </span>
                                    <input
                                    v-model="form.title"
                                    type="text" placeholder="Scrivo qui" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>
                            </div>

                            <!-- Description -->
                            <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium leading-6">Descrizione</label>
                                <div class="mt-2">
                                    <textarea v-model="form.description" rows="5" class="block w-full textarea textarea-primary"></textarea>
                                </div>
                            </div>

                            <!-- Embed Link -->
                            <div class="col-span-full">
                                <label for="link" class="block text-sm font-medium leading-6">Link Embed</label>
                                <div class="mt-2">
                                    <textarea v-model="form.link" rows="3"  class="block w-full textarea textarea-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between gap-x-6">
                    <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
                    <button @click="$inertia.visit(route('admin.documents.index'))" type="button" class="btn btn-secondary">Annulla</button>
                    <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary">Salva</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    document: Object
})

let form = useForm({
    id: props.document.id,
    title: props.document.title,
    description: props.document.description,
    link: props.document.link
})

const submit = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('description', form.description);
    formData.append('link', form.link);

    // Use the put method to send the FormData for updating.
    form.put(route('admin.documents.update', {id: props.document.id}), {
        body: formData
    });
}

const destroy = () => {
    form.delete(route('admin.documents.destroy', {id: props.document.id}));
}
</script>
