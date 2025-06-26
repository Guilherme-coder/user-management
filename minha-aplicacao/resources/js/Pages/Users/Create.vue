<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    profiles: Array,
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    profiles: [],
})

const submit = () => {
    form.post('/users')
}
</script>

<template>
    <Head title="Criar Usuário" />

    <AuthenticatedLayout>

        <div class="max-w-xl mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Criar Novo Usuário</h1>

            <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded-xl shadow-md">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full border rounded-md px-3 py-2 shadow-sm"
                        :class="{ 'border-red-500': form.errors.name }"
                    />
                    <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full border rounded-md px-3 py-2 shadow-sm"
                        :class="{ 'border-red-500': form.errors.email }"
                    />
                    <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full border rounded-md px-3 py-2 shadow-sm"
                        :class="{ 'border-red-500': form.errors.password }"
                    />
                    <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perfis</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div v-for="profile in profiles" :key="profile.id" class="flex items-center">
                            <input
                                type="checkbox"
                                :id="`profile-${profile.id}`"
                                :value="profile.id"
                                v-model="form.profiles"
                                class="mr-2"
                            />
                            <label :for="`profile-${profile.id}`" class="text-sm text-gray-700">
                                {{ profile.profile }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-6">
                    <Link href="/users" class="text-gray-600 hover:underline">Cancelar</Link>
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        :disabled="form.processing"
                    >
                        Criar Usuário
                    </button>
                </div>
            </form>
        </div>

    </AuthenticatedLayout>
</template>
