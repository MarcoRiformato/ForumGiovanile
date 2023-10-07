<template>
    <AppLayout>
        <div class="bg-base-200">
            <h1 class="text-4xl p-2">Edit Vision</h1>
            <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Title -->
                            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6">Title</label>
                                    <input type="text" v-model="form.title" class="input input-bordered input-primary w-full max-w-xs" />
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="col-span-full">
                                <label class="block text-sm font-medium leading-6">Description</label>
                                <div class="mt-2">
                                    <textarea rows="2" v-model="form.desc" class="block w-full textarea textarea-primary"></textarea>
                                </div>
                            </div>
                            <!-- Icon -->
                            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium leading-6">Icon</label>
                                    <div class="mt-2 flex rounded-md bg-white/5">
                                        <input type="text" v-model="form.icon" class="flex-1 border-0 bg-transparent py-1.5 pl-1 focus:ring-0 sm:text-sm sm:leading-6" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-between gap-x-6">
                            <button @click="$inertia.visit(route('admin.visions.index'))" type="button" class="btn btn-secondary">Annulla</button>
                            <button @click="submit" type="button" class="btn btn-primary">Save</button>
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
    vision: Object
  });

let form = useForm({
  title: props.vision.title,
  desc: props.vision.desc,
  icon: props.vision.icon
});

const isChanged = ref(false);  // Add this line to track changes

// Watch for changes in the form
watchEffect(() => {
    isChanged.value = form.title !== props.vision.title ||
        form.desc !== props.vision.desc ||
        form.icon !== props.vision.icon;
});

const submit = () => {
  const formData = new FormData();
  formData.append('title', form.title);
  formData.append('desc', form.sub_title);
  formData.append('icon', form.about_us);

  form.put(route('admin.visions.update', {id: props.vision.id}), {
    body: formData
  });
};
</script>