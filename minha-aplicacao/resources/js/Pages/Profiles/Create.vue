<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'

const form = useForm({
    profile: '',
})

const submit = () => {
    form.post('/profiles', {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Novo Perfil" />

    <div class="max-w-md mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Criar Novo Perfil</h1>

        <form @submit.prevent="submit" class="space-y-4 bg-white p-6 rounded-xl shadow-md">
            <div>
                <label for="perfil" class="block text-sm font-medium text-gray-700">Nome do Perfil</label>
                <input
                    id="perfil"
                    v-model="form.profile"
                    type="text"
                    class="mt-1 block w-full border rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                    :class="{ 'border-red-500': form.errors.perfil }"
                />
                <span v-if="form.errors.perfil" class="text-red-500 text-sm">{{ form.errors.perfil }}</span>
            </div>

            <div class="flex justify-between items-center mt-6">
                <Link href="/profiles" class="text-gray-600 hover:underline">Cancelar</Link>
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    Salvar
                </button>
            </div>
        </form>
    </div>
</template>
