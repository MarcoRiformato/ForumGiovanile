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
                <label for="username" class="block text-sm font-medium leading-6">Nome</label>
                <div class="mt-2">
                    <span class="flex select-none
                    items-center pl-3 sm:text-sm"> </span>
                    <input
                    v-model="form.name"
                    type="text" placeholder="Scrivo qui" class="input input-bordered input-primary w-full max-w-xs" />
                </div>
            </div>
            </div>
            <div class="col-span-full">
            <label for="email" class="block text-sm font-medium leading-6">Email</label>
            <div class="mt-2">
                <input v-model="form.email" type="email" class="input input-bordered input-primary w-full max-w-xs" />
            </div>
            </div>
            <div class="col-span-full">
                <label for="email" class="block text-sm font-medium leading-6">Ruolo</label>
                <div class="mt-2">
                    <input v-model="form.role" class="block w-full textarea textarea-primary" />
                </div>
            </div>
            <div class="col-span-full">
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text">Mostra in homepage</span>
                        <input type="checkbox" v-model="form.is_team_member" />
                    </label>
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <div class="mt-6 flex items-center justify-between gap-x-6">
        <button @click="destroy" type="button" class="btn btn-error">Cancella</button>
        <button @click="$inertia.visit(route('admin.users.index'))" type="button" class="btn btn-secondary">Annulla</button>
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
        role: props.user.role,
        is_admin: props.user.is_admin,
        is_team_member: Boolean(props.user.is_team_member)
    })
    
    const submit = () => {
        const formData = new FormData();
            formData.append('name', form.name);
            formData.append('email', form.email);
            formData.append('email', form.role);
            formData.append('is_team_member', form.is_team_member);
        form.put(route('users.update', {id: props.user.id}), {
            body: formData
        });
    }
    
    const destroy = () =>{
        form.delete(route('users.destroy', {id: props.user.id}));
    }
    
    </script>
    