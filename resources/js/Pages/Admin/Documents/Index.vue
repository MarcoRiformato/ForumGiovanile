<template>
    <AppLayout title="Documenti">
        <div class="bg-base-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flex flex-col sm:flex-row sm:items-center">
                    <div class="flex-auto mb-4 sm:mb-0 mt-8">
                        <h1 class="-mt-8 text-4xl">Gestisci i documenti del forum</h1>
                    </div>
                    <div class="mt-12 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button" @click="$inertia.visit(route('admin.documents.create'))" class="btn btn-primary">Crea nuovo documento</button>
                    </div>
                </div>
                <div class="mt-2">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold">Titolo</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold">Descrizione</th>
                                <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr
                            @click="$inertia.visit(route('documents.index'))"
                             v-for="document in documents" :key="document.id">
                                <td class="py-4 px-4 text-sm font-medium">{{ document.title }}</td>
                                <td class="py-4 px-4 text-sm">{{ document.description }}</td>
                                <td class="py-4 px-4 text-sm">
                                    <button class="btn btn-secondary" @click.stop="$inertia.visit(route('admin.documents.edit', document.id))">Modifica</button>
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
      documents: Object
    })
</script>
