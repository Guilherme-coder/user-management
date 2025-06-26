<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    profile: Object,
})

const form = useForm({
    profile: props.profile.profile,
})

const submit = () => {
    form.put(`/profiles/${props.profile.id}`)
}
</script>

<template>
    <Head title="Editar Perfil" />

    <AuthenticatedLayout>

        <div class="max-w-md mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Perfil</h1>

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
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                        :disabled="form.processing"
                    >
                        Atualizar
                    </button>
                </div>
            </form>
        </div>

    </AuthenticatedLayout>
</template>
