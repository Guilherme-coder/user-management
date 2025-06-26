<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    users: Array
})
</script>

<template>
    <Head title="Usuários" />

    <AuthenticatedLayout>

        <div class="max-w-4xl mx-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Gerenciar Usuários</h1>
                <Link
                    href="/users/create"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Novo Usuário
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                    <tr v-for="user in users" :key="user.id">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ user.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ user.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ user.email }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <Link :href="`/users/${user.id}`" class="text-indigo-600 hover:underline mr-4">Ver</Link>
                            <Link :href="`/users/${user.id}/edit`" class="text-blue-600 hover:underline">Editar</Link>
                        </td>
                    </tr>
                    <tr v-if="users.length === 0">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhum usuário cadastrado.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
