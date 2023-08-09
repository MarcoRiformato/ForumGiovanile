<template>
    <AppLayout>
        <div class="bg-base-200">
  <div class="px-4 sm:px-6 lg:px-8  ">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-4xl mt-4">Gestisci articoli</h1>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none ">
        <button type="button" class="btn btn-primary mt-4">Crea nuovo articolo</button>
      </div>
    </div>
    <div class="-mx-4 mt-2 sm:-mx-0">
      <table class="min-w-full divide-y divide-gray-300">
        <thead>
          <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">Titolo</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold sm:table-cell">Autore</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Estratto</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <tr :article="article" @click="$inertia.visit(route('articles.show', article.id))" v-for="article in articles" :key="article.id ">
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">{{ article.title }}</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm md:table-cell">
                    <div class="flex items-center">
                        <div class="h-11 w-11 flex-shrink-0">
                            <img class="rounded-full" src="https://picsum.photos/100" />
                        </div>
                        <div class="ml-4">
                            <div class="font-medium">{{ article.user_id }}</div>
                        </div>
                    </div>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm md:table-cell">{{ article.extract }}</td>
                <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                    <button @click.stop="$inertia.visit(route('admin.articles.edit', article.id))" class="btn btn-secondary">Modifica</button>
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
  articles: Object
})
</script>