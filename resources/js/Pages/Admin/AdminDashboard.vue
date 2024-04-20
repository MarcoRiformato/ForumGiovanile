<template>
<AppLayout>
    <div class="bg-base-200">
        <div class="grid gap-4 grid-cols-2">
        <p><a class="link link-primary" @click="$inertia.visit(route('admin.dashboard'))" >Notizie</a></p>
        <p><a class="link link-primary"
        @click="$inertia.visit(route('admin.documents.index'))">Documenti</a></p>
        <p><a class="link link-primary" @click="$inertia.visit(route('admin.elections.index'))">Sondaggi/Elezioni</a></p>
        <p><a class="link link-primary" @click="$inertia.visit(route('admin.homepage.edit'))">Homepage</a></p>
        <p><a class="link link-primary" @click="$inertia.visit(route('admin.users.index'))">Utenti</a></p>
        <p><a class="link link-primary" @click="$inertia.visit(route('admin.ads.index'))">Pubblicità</a></p>
        </div>
    </div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

</script>