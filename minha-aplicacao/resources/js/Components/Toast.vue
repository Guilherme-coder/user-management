<script setup>
import { ref, watchEffect } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const visible = ref(false)
const message = ref('')
const type = ref('success')

watchEffect(() => {
    const success = page.props.flash.success
    const error = page.props.flash.error

    if (success || error) {
        message.value = success || error
        type.value = success ? 'success' : 'error'
        visible.value = true

        setTimeout(() => {
            visible.value = false
        }, 3000)
    }
})

const close = () => {
    visible.value = false
}
</script>

<template>
    <transition name="fade">
        <div
            v-if="visible"
            :class="[
                'fixed top-5 right-5 px-4 py-2 rounded shadow-lg text-white z-50 opacity-75',
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            ]"
        >
            {{ message }}
            <button @click="close" class="text-white font-bold text-lg leading-none ml-3">x</button>
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
