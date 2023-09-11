<template>
    <AppLayout>
      <div class="bg-base-200">
        <h1 class="text-4xl p-2">Modifica homepage</h1>
        <div class="flex justify-end">
          <button @click="$inertia.visit(route('admin.visions.index'))" class="btn btn-primary mr-4">Modifica visione</button>
          <button class="btn btn-secondary">Modifica squadra</button>
        </div>
        <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
          <div class="space-y-12">
            <div class="border-b border-white/10 pb-12">
              <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Main Title -->
                <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                  <div class="sm:col-span-3">
                    <label class="block text-sm font-medium leading-6 text-white">Titolo principale</label>
                    <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                      <input type="text" v-model="form.main_title" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
                <!-- Sub Title -->
                <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                  <div class="sm:col-span-3">
                    <label class="block text-sm font-medium leading-6 text-white">Sottotitolo principale</label>
                    <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                      <input type="text" v-model="form.sub_title" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
                <!-- About Us -->
                <div class="col-span-full">
                  <label class="block text-sm font-medium leading-6 text-white">Chi siamo</label>
                  <div class="mt-2">
                    <textarea rows="3" v-model="form.about_us" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
                <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                  <div class="sm:col-span-3">
                    <label class="block text-sm font-medium leading-6 text-white">Titolo ultime notizie</label>
                    <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                      <input type="text" v-model="form.latest_news_title" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
                <div class="col-span-full">
                  <label class="block text-sm font-medium leading-6 text-white">Descrizione ultime notizie</label>
                  <div class="mt-2">
                    <textarea rows="3" v-model="form.latest_news_desc" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
                <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                  <div class="sm:col-span-3">
                    <label class="block text-sm font-medium leading-6 text-white">Titolo nostra visione</label>
                    <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                      <input type="text" v-model="form.our_vision_title" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
                <div class="col-span-full">
                  <label class="block text-sm font-medium leading-6 text-white">Descrizione nostra visione</label>
                  <div class="mt-2">
                    <textarea rows="3" v-model="form.our_vision_desc" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
                <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                  <div class="sm:col-span-3">
                    <label class="block text-sm font-medium leading-6 text-white">Titolo la squadra</label>
                    <div class="mt-2 flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                      <input type="text" v-model="form.team_title" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                  </div>
                </div>
                <div class="col-span-full">
                  <label class="block text-sm font-medium leading-6 text-white">Descrizione la squadra</label>
                  <div class="mt-2">
                    <textarea rows="3" v-model="form.team_desc" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-between gap-x-6">
                  <button @click="$inertia.visit(route('admin.dashboard'))" type="button" class="btn btn-secondary">Annulla</button>
                  <button @click="submit" type="button" :disabled="form.processing" v-if="isChanged" class="btn btn-primary">Salva</button>
              </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
</template>
  
  <script setup>
  import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';
  import { watchEffect, ref } from 'vue';
  
  const props = defineProps({
    homepages: Object
  });
  
  let form = useForm({
  main_title: props.homepages.main_title,
  sub_title: props.homepages.sub_title,
  about_us: props.homepages.about_us,
  latest_news_title: props.homepages.latest_news_title,
  latest_news_desc: props.homepages.latest_news_desc,
  our_vision_title: props.homepages.our_vision_title,
  our_vision_desc: props.homepages.our_vision_desc,
  team_title: props.homepages.team_title,
  team_desc: props.homepages.team_desc
});

const isChanged = ref(false);  // Add this line to track changes

// Watch for changes in the form
watchEffect(() => {
    isChanged.value = form.main_title !== props.homepages.main_title ||
        form.sub_title !== props.homepages.sub_title ||
        form.about_us !== props.homepages.about_us ||
        form.latest_news_title !== props.homepages.latest_news_title ||
        form.latest_news_desc !== props.homepages.latest_news_desc ||
        form.our_vision_title !== props.homepages.our_vision_title ||
        form.our_vision_desc !== props.homepages.our_vision_desc ||
        form.team_title !== props.homepages.team_title ||
        form.team_desc !== props.homepages.team_desc;
});

const submit = () => {
  const formData = new FormData();
  formData.append('main_title', form.main_title);
  formData.append('sub_title', form.sub_title);
  formData.append('about_us', form.about_us);
  formData.append('latest_news_title', form.latest_news_title);
  formData.append('latest_news_desc', form.latest_news_desc);
  formData.append('our_vision_title', form.our_vision_title);
  formData.append('our_vision_desc', form.our_vision_desc);
  formData.append('team_title', form.team_title);
  formData.append('team_desc', form.team_desc);

  form.put(route('admin.homepages.update', {id: props.homepages.id}), {
    body: formData
  });
};
  </script>
  