<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array
})
</script>

<template>
    <div class="m-4 flex justify-center flex-wrap">
        <template v-for="link in links" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                class="px-3 py-1 mx-1 border rounded text-sm"
                :class="{
                    'bg-blue-600 text-white': link.active,
                    'text-gray-700 hover:bg-gray-100': !link.active
                }"
                v-html="link.label"
            />
            <span
                v-else
                class="px-3 py-1 mx-1 text-gray-400 text-sm"
                v-html="link.label"
            ></span>
        </template>
    </div>
</template>
