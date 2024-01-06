<template>
<div aria-live="assertive" class="pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6 z-50">
    <div v-if="showNotification && message || errorMessage" class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
              v-if="showNotification"
              class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
              :class="message ? 'border border-green-400 bg-green-400 text-green-900' : 'border border-red-400 text-rose-800'"
            >
                <div class="p-4">
                <div class="flex items-start">

                    <div class="flex-shrink-0">
                        <CheckCircleIcon v-if="message" class="h-6 w-6 text-green-900" aria-hidden="true" />
                        <CircleExclamationIcon v-if="errorMessage" class="h-6 w-6 text-red-900" aria-hidden="true" />
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5" v-if="message">
                        <p class="text-sm font-medium text-green-900">Success</p>
                        <p class="mt-1 text-sm text-green-900">{{ message }}</p>
                    </div>

                    <div class="ml-3 w-0 flex-1 pt-0.5" v-if="errorMessage">
                        <p class="text-sm font-medium text-white">Error</p>
                        <p class="mt-1 text-sm text-white">{{ errorMessage }}</p>
                    </div>

                    <div class="ml-4 flex flex-shrink-0">
                    <button
                        type="button"
                        @click="showNotification = false"
                        :class="{
                            'text-green-900 hover:text-green-200 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-200': message,
                            'text-rose-900 hover:text-rose-200 hover:bg-rose-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-200': errorMessage,
                        }"
                        class="inline-flex rounded-md">
                            <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                    </div>
                </div>
                </div>
            </div>
        </transition>
    </div>
</div>
</template>

<script setup>
import CheckCircleIcon from '@/Icons/circle-check.vue'
import CircleExclamationIcon from '@/Icons/circle-exclamation.vue'
import XMarkIcon from '@/Icons/x-sign.vue'
import { ref, onMounted } from 'vue'

defineProps({
    message: String,
    errorMessage: String,
});

const showNotification = ref(false)

onMounted(() => {
    showNotification.value = true
    setTimeout(() => {
        showNotification.value = false
    }, 5000)
})
</script>
