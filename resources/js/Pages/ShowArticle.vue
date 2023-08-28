<template>
<AppLayout title="Leggi articolo">
<div class="bg-base-200">
      <div class=" px-6 py-8 lg:px-8">
    <div class="mx-auto max-w-3xl text-base leading-7 ">
      <p class="text-base font-semibold leading-7 text-indigo-600">Dal blog del forum</p>
      <h1 class="mt-2 text-3xl font-bold tracking-tight  sm:text-4xl">{{ article.title }}</h1>
      <p class="mt-6 text-xl leading-8">{{ article.extract }}</p>
      <figure class="mt-8">
          <img v-if="article.media && article.media.length > 0" :src="'/storage/' + article.media[0].filepath" class="aspect-video rounded-xl bg-gray-50 object-cover" alt="Article Image" />
          <p v-if="article.media && article.media.length > 0">Descrizione dell'imagine</p>
      </figure>

      <div class="quill-content">
        <div class="mt-10 max-w-2xl" v-html="article.body"></div>
      </div>

    </div>
  </div>
</div>
</AppLayout>
</template>
<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  article: Object
})

</script>
<style>
.quill-content h1 {
  font-size: 38px;
}

.quill-content h2 {
  font-size: 30px;
}

.quill-content h3 {
  font-size: 24px;
}

.quill-content h4 {
  font-size: 18px;
}

.quill-content a {
  text-decoration: underline;
  color: blue; /* Or any desired color for links */
}

.quill-content blockquote {
  border-left: 4px solid #ccc;
  padding-left: 15px;
}

.quill-content .ql-align-center {
  text-align: center;
}

.quill-content .ql-align-right {
  text-align: right;
}

.quill-content .ql-align-left {
  text-align: left;
}

</style>