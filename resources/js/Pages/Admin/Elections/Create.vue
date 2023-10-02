<template>
<AppLayout title="Crea elezione">
<div class="bg-base-200">
    <h1 class="text-4xl p-4">Crea elezione</h1>
    <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
        <div class="space-y-12">
            <div class="border-b border-white/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <!-- Name -->
                    <div class="sm:col-span-4">
                        <label for="name" class="block text-sm font-medium leading-6">Nome</label>
                        <div class="mt-2">
                        <input
                            v-model="form.name"
                            type="text" placeholder="Scrivi qui" class="input input-bordered input-primary w-full max-w-xs" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-span-full">
                        <label for="about" class="block text-sm font-medium leading-6">Estratto</label>
                        <div class="mt-2">
                            <textarea
                            v-model="form.extract"
                            rows="3" class="block w-full textarea textarea-primary" />
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div class="sm:col-span-3">
                        <label for="start_date" class="block text-sm font-medium leading-6">Inizio elezioni</label>
                        <div class="mt-2">
                            <input v-model="form.start_date" type="date" class="block w-full rounded-md border-0 bg-white/5 py-1.5 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="sm:col-span-3">
                        <label for="end_date" class="block text-sm font-medium leading-6">Fine elezioni</label>
                        <div class="mt-2">
                            <input v-model="form.end_date" type="date" class="block w-full rounded-md border-0 bg-white/5 py-1.5 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm font-medium leading-6">Stato</label>
                        <div class="mt-2">
                            <select v-model="form.status" class="block w-full rounded-md border-0 bg-white/5 py-1.5 shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between gap-x-6">
        <button @click="$inertia.visit(route('admin.elections.index'))" type="button" class="btn btn-secondary">Annulla</button>
        <button type="submit" :disabled="form.processing" class="btn btn-primary">Avanti</button> <!-- Use submit button here -->
    </div>
    </form>
</div>
</AppLayout>
</template>

<script setup>
import { reactive } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = reactive({
    name: '',
    description: '',
    start_date: '',
    end_date: '',
    status: 'open'
});

const submit = () => {
    console.log('Saving');
    console.log('Saving: ', form);
    sessionStorage.setItem('election', JSON.stringify(form));
    window.location.href = route('admin.elections.questions');
};
</script>

