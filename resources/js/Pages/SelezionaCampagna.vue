<template>
  <AppLayout title="Dashboard">
    <div class="bg-base-200">
      <div class=" flex justify-end">
        <a :href="route('campaigns.create')" role="button" class="btn me-2 mt-2 btn-active btn-secondary flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a1 1 0 01-1-1V11H2a1 1 0 110-2h7V3a1 1 0 112 0v6h7a1 1 0 110 2h-7v6a1 1 0 01-1 1z" clip-rule="evenodd"/>
          </svg>
          Crea nuova campagna
        </a>
      </div>
      <div v-for="campaign in campaigns">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="max-w-7xl mx-auto p-6 lg:p-8">
                  <div class="card card-side bg-base-100 shadow-xl">
                      <figure><img src="https://picsum.photos/200/200" alt="Movie"/></figure>
                      <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h2 class="card-title">{{ campaign.title }}</h2>
                            <div>
                                <div v-if="campaign.status == '1'" class="badge badge-secondary">Attivo</div>
                                <div v-if="campaign.status == '0'" class="badge badge-accent">Non attivo</div>
                            </div>
                        </div>
                        <p> {{ campaign.description }} </p>
                        <div class="card-actions justify-end">
                          <a type="button" :campaign="campaign" :href="route('campaigns.show', campaign.id)" class="btn btn-primary">Seleziona</a>
                        </div>
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
    campaigns: Object
  })
  
  </script>
  