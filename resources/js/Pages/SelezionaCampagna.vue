<template>
<div >
<AppLayout title="Dashboard">
    <div class="bg-base-200" v-for="campaign in campaigns">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="card card-side bg-base-100 shadow-xl">
                <figure><img src="https://picsum.photos/200/200" alt="Movie"/></figure>
                <div class="card-body">
                  <h2 class="card-title">{{ campaign.title }}</h2>
                  <p> {{ campaign.description }} </p>
                  <div class="card-actions justify-end">
                    <button class="btn btn-primary">Seleziona</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</AppLayout>
</div>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  campaigns: Object
})

</script>