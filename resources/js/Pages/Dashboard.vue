<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MainDashboard from '@/Components/MainDashboard.vue';
</script>

<template>
<div >
    <AppLayout title="Dashboard">

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
