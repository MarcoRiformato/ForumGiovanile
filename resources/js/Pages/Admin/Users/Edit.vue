<template>
    <AppLayout>
    <div class="bg-base-200">
    <h1 class="text-4xl p-4">Modifica Utente</h1>
        <form class="px-8 bg-base-200 pb-8"  @submit.prevent="submit">
    <div class="space-y-12">
        <div class="border-b border-white/10 pb-12">
    
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4 grid sm:grid-cols-4 gap-4">
            <div class="sm:col-span-3">
                <label for="name" class="block text-sm font-medium leading-6 text-white">Nome</label>
                <div class="mt-2">
                <div class="flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                    <input v-model="form.name" type="text" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" />
                </div>
                </div>
            </div>
            </div>
    
            <div class="col-span-full">
            <label for="email" class="block text-sm font-medium leading-6 text-white">Email</label>
            <div class="mt-2">
                <input v-model="form.email" type="email" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
            </div>
            </div>
            <div class="col-span-full">
            <label for="email" class="block text-sm font-medium leading-6 text-white">Password</label>
            <div class="mt-2">
                <input v-model="form.password" type="password" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
            </div>
            <p class="text-xs italic">Hai un grande potere, usalo saggiamente!</p>
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
        user: Object
    })
    
    let form = useForm({
        id: props.user.id,
        name: props.user.name,
        email: props.user.email,
        password: props.user.password
    })
    
    const submit = () => {
        const formData = new FormData();
            formData.append('name', form.name);
            formData.append('email', form.email);
            formData.append('password', form.password);
        form.put(route('users.update', {id: props.user.id}), {
            body: formData
        });
    }
    
    const destroy = () =>{
        form.delete(route('users.destroy', {id: props.user.id}));
    }
    
    </script>
    