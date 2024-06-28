<template>
    <AppLayout title="Lista offerte di lavoro">
        <div class="bg-base-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center">
                    <div class="flex-auto mb-4 sm:mb-0">
                        <h1 class="text-4xl">Gestisci i collaboratori</h1>
                    </div>
                    <div class="mt-12 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button" @click="$inertia.visit(route('admin.jobs.create'))" class="btn btn-disabled">Nuovo collaboratore (non attivo)</button>
                    </div>
                </div>
                <div class="mt-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Titolo</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Azienda</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Luogo</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Stipendio</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Descrizione</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-lg text-info font-semibold">Data pubblicazione</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr
                            @click="$inertia.visit(route('jobs.index'))"
                             v-for="job in jobs" :key="job.id">
                                <td class="py-4 px-4 text-sm font-medium">{{ job.lavoro }}</td>
                                <td class="py-4 px-4 text-sm">{{ job.azienda }}</td>
                                <td class="py-4 px-4 text-sm">{{ job.luogo }}</td>
                                <td class="py-4 px-4 text-sm">{{ job.stipendio }}</td>
                                <td class="py-4 px-4 text-sm">{{ job.descrizione }}</td>
                                <td class="py-4 px-4 text-sm">
                                {{ new Date(job.data_pubblicazione).toLocaleDateString('it-IT', { month: 'short', day: 'numeric' }) }}
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    <button class="btn btn-secondary" @click.stop="$inertia.visit(route('admin.jobs.edit', job.id))">Modifica</button>
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
    jobs: Object
})
</script>
