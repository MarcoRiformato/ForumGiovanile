<template>
    <AppLayout title="Lista collaboratori">
        <div class="bg-base-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center">
                    <div class="flex-auto mb-4 sm:mb-0">
                        <h1 class="text-4xl">Gestisci i collaboratori</h1>
                    </div>
                    <div class="mt-12 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button" @click="$inertia.visit(route('admin.workers.create'))" class="btn btn-primary">Nuovo collaboratore</button>
                    </div>
                </div>
                <div class="mt-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Immagine</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Nome</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Tipo di contratto</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Titoli di lavoro</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Residenza</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Disponibilità</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Azioni</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="worker in workers" :key="worker.id">
                                <p>{{ worker }}</p>
                                <td class="py-4 px-4 text-sm">
                                    <img 
                                        :src="'/storage/' + worker.media.filepath" 
                                        :alt="worker.name + ' Image'" 
                                        class="h-12 w-12 rounded-full object-cover" 
                                    />
                                </td>
                                <td class="py-4 px-4 text-sm font-medium">{{ worker.name }}</td>
                                <td class="py-4 px-4 text-sm">{{ worker.contract_type }}</td>
                                <td class="py-4 px-4 text-sm">{{ worker.job_titles }}</td>
                                <td class="py-4 px-4 text-sm">{{ worker.residence }}</td>
                                <td class="py-4 px-4 text-sm">
                                    {{ worker.availability ? new Date(worker.availability).toLocaleDateString('it-IT', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A' }}
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    <button class="btn btn-secondary" @click="$inertia.visit(route('admin.workers.edit', worker.id))">Modifica</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    workers: Object
})
</script>