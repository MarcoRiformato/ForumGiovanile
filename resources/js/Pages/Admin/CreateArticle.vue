<template>
    <AppLayout title="Crea articolo">
<div class="bg-base-200">
<h1 class="text-4xl p-4">Crea articolo</h1>
<form class="px-8 bg-base-200 pb-8" @submit.prevent="submit" enctype="multipart/form-data">
<div class="space-y-12">
    <div class="border-b border-white/10 pb-12">

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
            <div class="sm:col-span-3">
                <label for="username" class="block text-sm font-medium leading-6">Titolo</label>
                <div class="mt-2">
                    <span class="flex select-none
                    items-center pl-3 sm:text-sm"> </span>
                    <input
                    v-model="form.title"
                    type="text" placeholder="Scrivo qui" class="input input-bordered input-primary w-full max-w-xs" />
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <label for="about" class="block text-sm font-medium leading-6">Estratto</label>
            <div class="mt-2">
                <textarea
                v-model="form.extract"
                rows="3" class="block w-full textarea textarea-primary" />
            </div>
            </div>
        <div class="col-span-full">
            <label for="article-body" class="block text-sm font-medium leading-6">Testo dell'articolo</label>
            <div class="mt-2 bg-white/5 rounded-md">
                <QuillEditor  toolbar="full" v-model:content="form.body" contentType="html" theme="snow" />
            </div>
        </div>
        <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6">Foto</label>

            <div class="text-center">
            <div class="mt-4 flex text-sm leading-6">
                <input
                @change="form.media_file = $event.target.files[0]"
                type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
            </div>
            </div>

        </div>
    </div>
    </div>

</div>

<div class="mt-6 flex items-center justify-between gap-x-6">
    <button @click="$inertia.visit(route('admin.dashboard'))" type="button" class="btn btn-secondary">Annulla</button>
    <button @click="submit" type="button" :disabled="form.processing" class="btn btn-primary ">Salva</button>
</div>
</form>
</div>
</AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    article: Object
})

let form = useForm({
    title: '',
    extract: '',
    body: '',
    media_file: null
})


const submit = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('extract', form.extract);
    formData.append('body', form.body);
    if (form.media_file) {
        formData.append('media_file', form.media_file);
    }

    form.post(route('articles.store'), {
        body: formData,
        onSuccess: () => {
            form.reset();
        }
    });
}

</script>
