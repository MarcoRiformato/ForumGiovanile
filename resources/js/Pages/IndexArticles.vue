<template>
<AppLayout>
  <div class="overflow-hidden bg-base-200">
    <!-- Blog section -->
    <div class="mx-auto max-w-7xl px-6 sm:mt-4 lg:px-8">
      <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Ultime notizie</h2>
        <p class="my-6 text-lg leading-8">Leggi analisi, sondaggi e notizie del Forum Giovanile Elbano</p>
      </div>
      <div class="mx-auto grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-10 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        <article v-for="article in articles" :key="article.id" class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-20 sm:pt-48 lg:pt-80">
          <div :article="article" @click="$inertia.visit(route('articles.show', article.id))">
            <img src="https://picsum.photos/800" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
          <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40" />
          <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10" />

          <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
            <time :created_at="article.created_at" class="mr-8">{{ article.created_at }}</time>
            <div class="-ml-4 flex items-center gap-x-4">
              <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50">
                <circle cx="1" cy="1" r="1" />
              </svg>
              <div class="flex gap-x-2.5">
                <img src="https://picsum.photos/100" alt="" class="h-6 w-6 flex-none rounded-full bg-white/10" />
                {{ article.user_id }}
              </div>
            </div>
          </div>
          <h3 class="mt-3 text-lg font-semibold leading-6 text-white">
            <p>
              <span class="absolute inset-0" />
              {{ article.title }}
            </p>
          </h3>
          </div>
        </article>
      </div>
    </div>
  </div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


defineProps({
  articles: Object
})

</script>