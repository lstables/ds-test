<template>
<div class="text-center px-4 py-6 rounded-md" :class="{'border border-gray-200': hasBorder }">
    <div v-if="icon" class="mx-auto h-12 w-12 text-gray-400" :class="iconClasses">
        <slot name="icon" />
    </div>

    <div v-else>
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
    </div>
  <h3 class="mt-2 text-sm font-semibold text-gray-900">
    <slot name="title" />
  </h3>
  <p class="mt-1 text-sm text-gray-500">
    <slot name="description" />
  </p>
  <div v-if="url" class="mt-6">
    <button :href="url" type="button" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
      </svg>
      {{ urlText}}
    </button>
  </div>
  <div v-else class="my-3">
    <slot name="actions" />
  </div>
</div>
</template>

<script setup>
defineProps({
  url: String,
  urlText: String,
  icon: {
    type: Boolean,
    default: false
  },
  hasBorder: {
    type: Boolean,
    default: true
  },
})
</script>
