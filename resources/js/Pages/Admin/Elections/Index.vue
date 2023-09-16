<template>
    <AppLayout title="Lista admin elezioni">
        <div class="bg-base-200 px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flex flex-col sm:flex-row sm:items-center">
                <div class="flex-auto mb-4 sm:mb-0 mt-8">
                    <h1 class="-mt-8 text-4xl">Gestisci elezioni</h1>
                </div>
                <div class="mt-12 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button type="button" @click="$inertia.visit(route('admin.elections.create'))" class="btn btn-primary">Crea nuova elezione</button>
                </div>
            </div>
            <div class="mt-2">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold">Nome</th>
                            <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold">Descrizione</th>
                            <th scope="col" class="hidden md:table-cell py-3.5 px-4 text-left text-sm font-semibold">Data Inizio</th>
                            <th scope="col" class="hidden md:table-cell py-3.5 px-4 text-left text-sm font-semibold">Data Fine</th>
                            <th scope="col" class="hidden md:table-cell py-3.5 px-4 text-left text-sm font-semibold">Stato</th>
                            <th scope="col" class="py-3.5 px-4 text-left text-sm font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="election in elections" :key="election.id">
                            <td class="py-4 px-4  font-medium truncate" style="max-width: 150px;">{{ election.name }}</td> <!-- Truncated Name -->
                            <td class="hidden md:table-cell py-4 px-4 " style="max-width: 200px;">{{ election.description }}</td> <!-- Truncated Description -->
                            <td class="hidden sm:table-cell py-4 px-4 ">{{ formatDate(election.start_date) }}</td>
                            <td class="hidden md:table-cell py-4 px-4 ">{{ formatDate(election.end_date) }}</td>
                            <td class="hidden sm:table-cell py-4 px-4 ">{{ election.status }}</td>
                            <td class="py-4 px-4 ">
                                <button class="btn btn-secondary" @click.stop="$inertia.visit(route('admin.elections.show', election.id))">Consulta</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>


<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';

    defineProps({
        elections: Object
    })

    const formatDate = (dateString) => {
    if (!dateString) return "Non definita";

    const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
    };

</script>
