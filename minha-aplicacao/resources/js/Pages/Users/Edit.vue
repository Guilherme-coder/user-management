<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    user: Object
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})

const submit = () => {
    form.put(`/users/${props.user.id}`)
}
</script>

<template>
    <Head title="Editar Usuário" />

    <AuthenticatedLayout>

        <div class="max-w-md mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Usuário</h1>

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

                <div class="flex justify-between items-center mt-6">
                    <Link href="/users" class="text-gray-600 hover:underline">Cancelar</Link>
                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                        :disabled="form.processing"
                    >
                        Atualizar
                    </button>
                </div>
            </form>
        </div>

    <AuthenticatedLayout>
</template>
