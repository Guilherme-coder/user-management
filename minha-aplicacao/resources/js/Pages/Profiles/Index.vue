<script setup>
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    profiles: Array
})

const confirmDelete = (id) => {
    if (confirm('Deseja realmente excluir este perfil?')) {
        router.delete(`/profiles/${id}`)
    }
}
</script>

<template>
    <Head title="Perfis" />

    <div class="max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gerenciar Perfis</h1>
            <Link href="/profiles/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Novo Perfil
            </Link>
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Perfil</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                <tr v-for="profile in profiles" :key="profile.id">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ profile.id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ profile.profile }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <Link :href="`/profiles/${profile.id}`" class="text-blue-600 hover:underline mr-4">Ver</Link>
                        <Link :href="`/profiles/${profile.id}/edit`" class="text-blue-600 hover:underline mr-4">Editar</Link>
                        <button @click="confirmDelete(profile.id)" class="text-red-600 hover:underline">Excluir</button>
                    </td>
                </tr>
                <tr v-if="profiles.length === 0">
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Nenhum perfil cadastrado.</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
