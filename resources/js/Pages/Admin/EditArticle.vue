<template>
<AppLayout>
<div class="bg-base-200">
<h1 class="text-4xl p-4">Modifica articolo</h1>
    <form class="px-8 bg-base-200 pb-8"  @submit.prevent="submit">
<div class="space-y-12">
    <div class="border-b border-white/10 pb-12">

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
        <div class="sm:col-span-3">
            <label for="username" class="block text-sm font-medium leading-6 text-white">Titolo</label>
            <div class="mt-2">
            <div class="flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm"> </span>
                <input
                v-model="form.title"
                type="text" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
            </div>
            </div>
        </div>
        </div>

        <div class="col-span-full">
        <label for="about" class="block text-sm font-medium leading-6 text-white">Estratto</label>
        <div class="mt-2">
            <textarea
            v-model="form.extract"
            rows="3" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
        </div>
        </div>
        
        <div class="col-span-full">
            <label for="article-body" class="block text-sm font-medium leading-6 text-white">Testo dell'articolo</label>
            <div class="mt-2 bg-white/5 rounded-md">
                <QuillEditor  toolbar="full" v-model:content="form.body" contentType="html" theme="snow" />
            </div>
        </div>
        <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-white">Foto</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">
            <div class="text-center">
            <div class="mt-4 flex text-sm leading-6 text-gray-400">
                <label for="file-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold text-white focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                <span>Carica una foto</span>
                <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                </label>
                <p class="pl-1">oppure trascinala qui</p>
            </div>
            <p class="text-xs leading-5 text-gray-400">PNG, JPG, GIF up to 10MB</p>
            </div>
        </div>
        </div>
    </div>
    </div>

</div>

<div class="mt-6 flex items-center justify-between gap-x-6">
    <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
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
    id: props.article.id,
    title: props.article.title,
    extract: props.article.extract,
    body: props.article.body,
})

const submit = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('extract', form.extract);
    formData.append('body', form.body);
    
    // If there's a media_file, append it to the FormData.
    if (form.media_file) {
        formData.append('media_file', form.media_file);
    }

    // Use the put method to send the FormData for updating.
    form.put(route('articles.update', {id: props.article.id}), {
        body: formData
    });
}

const destroy = () =>{
    form.delete(route('articles.destroy', {id: props.article.id}));
}

</script>