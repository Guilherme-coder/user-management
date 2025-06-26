<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    profile: Object,
    usersWithProfile: Array,
    allUsers: Array,
    attachedUserIds: Array
})

const userForm = useForm({
    users: [...props.attachedUserIds],
})

const submit = () => {
    userForm.post(route('profiles.syncUsers', props.profile.id))
}
</script>

<template>
    <Head :title="`Perfil: ${profile.perfil}`" />

    <AuthenticatedLayout>

        <div class="max-w-4xl mx-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Perfil: {{ profile.perfil }}</h1>
                <Link href="/profiles" class="text-blue-600 hover:underline">← Voltar</Link>
            </div>

            <div class="bg-white p-4 rounded-xl shadow mb-8">
                <h2 class="text-lg font-semibold mb-4">Usuários com esse perfil</h2>

                <ul v-if="usersWithProfile.length > 0" class="space-y-2">
                    <li v-for="user in usersWithProfile" :key="user.id" class="text-gray-800">
                        • {{ user.name }} ({{ user.email }})
                    </li>
                </ul>

                <p v-else class="text-gray-500">Nenhum usuário com esse perfil.</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Gerenciar associação de usuários</h2>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div v-for="user in allUsers" :key="user.id" class="flex items-center">
                            <input
                                type="checkbox"
                                :id="`user-${user.id}`"
                                :value="user.id"
                                v-model="userForm.users"
                                class="mr-2"
                            />
                            <label :for="`user-${user.id}`" class="text-sm text-gray-700">
                                {{ user.name }} ({{ user.email }})
                            </label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        :disabled="userForm.processing"
                    >
                        Atualizar usuários
                    </button>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
