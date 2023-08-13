<template>
<AppLayout>
<div class="bg-base-200">
<div class="px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center">
        <div class="flex-auto mb-4 sm:mb-0 mt-8">
            <h1 class="text-4xl">Gestisci utenti</h1>
        </div>
    </div>
    <div class="mt-2">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0"></th>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">Nome</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Email</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr v-for="user in users" :key="user.id">
                    <td class="py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">
                        <div class="h-11 w-11 flex-shrink-0">
                            <img class="rounded-full" src="https://picsum.photos/100" />
                        </div>
                    </td>
                    <td class="py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">{{ user.name }}</td>
                    <td class="px-3 py-4 text-sm">{{ user.email }}</td>
                    <td class="px-3 py-4 text-sm">{{ user.is_admin ? 'Yes' : 'No' }}</td>
                    <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <button @click.stop="$inertia.visit(route('admin.users.edit', user.id))" class="btn btn-secondary">Modifica</button>
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
  users: Object
})
</script>
