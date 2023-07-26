<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MainDashboard from '@/Components/MainDashboard.vue';
</script>

<template>
<div >
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ">
                Seleziona campagna
            </h2>
        </template>

        <div class="bg-base-200">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto p-6 lg:p-8">
                    <MainDashboard />
                </div>
            </div>
        </div>
    </AppLayout>
</div>
</template>
