<template>
<AppLayout>
<div class="bg-base-200 px-8 py-2">
    <div class="mb-12 flex flex-col sm:flex-row sm:items-center">
    <div class="flex-auto mb-4 sm:mb-0 mt-8">
        <h1 class="-mt-8 text-4xl">Gestisci elezioni</h1>
    </div>
    <div class=" sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" @click="$inertia.visit(route('admin.elections.create'))" class="btn btn-primary">Crea nuova elezione</button>
    </div>
</div>
    <div class="cards-container">
        <div v-for="election in elections" :key="election.id" class="card-container">
        <div class="card w-96 bg-secondary text-primary-content">
            <div class="card-body">
            <h2 class="card-title">{{ election.name }}</h2>
            <p>{{ election.description }}</p>
            <p>{{ election.start_date }}</p>
            <p>{{ election.end_date }}</p>
            <p>{{ election.status }}</p>
            <div class="card-actions justify-end">
                <button
                @click.stop="$inertia.visit(route('admin.elections.show', election.id))"
                 :href="election.link" class="btn">Modifica</button>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    elections: Object
})

</script>