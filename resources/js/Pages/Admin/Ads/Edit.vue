<template>
<AppLayout title="Modifica pubblicità">
    <div class="bg-base-200">
    <h1 class="text-4xl p-4">Modifica pubblicità</h1>
    <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
        <div class="space-y-12">
        <div class="border-b border-white/10 pb-12">
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            
            <!-- Title -->
            <div class="sm:col-span-4">
                <label for="title" class="block text-sm font-medium leading-6">Titolo</label>
                <div class="mt-2">
                <input v-model="form.title" type="text" class="input input-bordered input-primary w-full max-w-xs" />
                </div>
            </div>

            <!-- Link URL -->
            <div class="sm:col-span-4">
                <label for="link_url" class="block text-sm font-medium leading-6">Link URL</label>
                <div class="mt-2">
                <input v-model="form.link_url" type="url" class="input input-bordered input-primary w-full max-w-xs" />
                </div>
            </div>

            <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6">Priorità</label>
                <select v-model="form.priority" class="select select-primary w-full max-w-xs">
                <option value="0">Main nav</option>
                <option value="1">Primo</option>
                <option value="2">Secondo</option>
                <option value="3">Terzo</option>
                <option value="4">Quarto</option>
                <option value="5">Quinto</option>
                <option value="6">Sesto</option>
                <option value="7">Settimo</option>
                <option value="8">Ottavo</option>
                <option value="9">Nono</option>
                <option value="10">Decimo</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="sm:col-span-4">
                <label for="start_date" class="block text-sm font-medium leading-6">Data inizio</label>
                <div class="mt-2">
                <input v-model="form.start_date" type="date" class="block w-full rounded-md border-0 bg-red/5 py-1.5 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                </div>
            </div>

            <!-- End Date -->
            <div class="sm:col-span-4">
                <label for="end_date" class="block text-sm font-medium leading-6">Data fine</label>
                <div class="mt-2">
                <input v-model="form.end_date" type="date" class="block w-full rounded-md border-0 bg-red/5 py-1.5 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                </div>
            </div>
            
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex items-center justify-between gap-x-6">
            <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
            <button @click="$inertia.visit(route('admin.ads.index'))" type="button" class="btn btn-secondary">Annulla</button>
            <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary">Salva</button>
        </div>
        </div>
    </form>
    </div>
</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
ad: Object
});

let form = useForm({
id: props.ad.id,
title: props.ad.title,
link_url: props.ad.link_url,
priority: props.ad.priority,
start_date: props.ad.start_date,
end_date: props.ad.end_date
});

const submit = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('link_url', form.link_url);
    formData.append('priority', form.priority);
    formData.append('start_date', form.start_date);
    formData.append('end_date', form.end_date);

    form.put(route('admin.ads.update', {id: props.ad.id}), {
        body: formData
    });
}


const destroy = () => {
form.delete(route('admin.ads.destroy', {id: props.ad.id}));
};
</script>
