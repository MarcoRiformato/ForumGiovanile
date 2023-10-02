<template>
    <AppLayout>
    <div class="bg-base-200">
    <h1 class="text-4xl p-4">Modifica articolo</h1>
    <form class="px-8 bg-base-200 pb-8" @submit.prevent="submit" enctype="multipart/form-data">
    <div class="space-y-12">
        <div class="border-b pb-12">
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
                            
                            <!-- Show Image if it exists -->
                            <div v-if="form.media_file && form.media_file.filepath">
                                <img :src="'/storage/' + form.media_file.filepath" alt="Article Image" class="object-cover mb-10" />
                                <button @click="removeImage" class="text-red-500">X</button>
                            </div>
    
                            <!-- Show Upload Option if No Image -->
                            <div v-else class="mt-2 flex justify-center rounded-lg border border-dashed border-white/25 px-6 py-10">
                                <div class="text-center">
                                    <div class="mt-4 flex text-sm leading-6 ">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-gray-900 font-semibold focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:ring-offset-gray-900 hover:text-indigo-500">
                                            <span>Carica una foto</span>
                                            <input id="file-upload" name="media_file" type="file" class="sr-only" @change="form.media_file = $event.target.files[0]" />
                                        </label>
                                        <p class="pl-1">oppure trascinala qui</p>
                                    </div>
                                    <p class="text-xs leading-5 ">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
        </div>
        </div>
    
    </div>
    
    <div class="mt-6 flex items-center justify-between gap-x-6">
        <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
        <button @click="$inertia.visit(route('admin.dashboard'))" type="button" class="btn btn-secondary">Annulla</button>
        <button @click="submit" type="submit" :disabled="form.processing" class="btn btn-primary ">Salva</button>
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
        media_file: props.article.media ? props.article.media[0] : null
    })
    
    const submit = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('extract', form.extract);
    formData.append('body', form.body);
    
    // Make sure you're appending the actual file object
    if (form.media_file) {
    formData.append('media_file', form.media_file);
}

    // Use the put method to send the FormData for updating.
    form.post(route('admin.articles.update', {id: props.article.id}), {
        body: formData
    });
    }
    
    const destroy = () =>{
        form.delete(route('articles.destroy', {id: props.article.id}));
    }
    
    </script>