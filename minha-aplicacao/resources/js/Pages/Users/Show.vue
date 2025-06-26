<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: Object,
    profiles: Array,
    attachedProfileIds: Array
})

const profileForm = useForm({
    profiles: [...props.attachedProfileIds],
})

const submit = () => {
    profileForm.post(route('users.syncProfiles', props.user.id))
}
</script>

<template>
    <Head :title="`Usuário: ${user.name}`" />

    <div class="max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Usuário: {{ user.name }}</h1>
            <Link href="/users" class="text-blue-600 hover:underline">← Voltar</Link>
        </div>

        <div class="bg-white p-4 rounded-xl shadow mb-8">
            <p class="text-gray-700"><strong>Email:</strong> {{ user.email }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-4">Gerenciar Perfis</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div v-for="profile in profiles" :key="profile.id" class="flex items-center">
                        <input
                            type="checkbox"
                            :id="`profile-${profile.id}`"
                            :value="profile.id"
                            v-model="profileForm.profiles"
                            class="mr-2"
                        />
                        <label :for="`profile-${profile.id}`" class="text-sm text-gray-700">
                            {{ profile.profile }}
                        </label>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    :disabled="profileForm.processing"
                >
                    Atualizar Perfis
                </button>
            </form>
        </div>
    </div>
</template>
