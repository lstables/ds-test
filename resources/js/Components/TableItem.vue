<template>
    <td :class="['py-4 pl-4 pr-3 text-sm',
        {'whitespace-nowrap' : !wrapContent, 'whitespace-normal' : wrapContent },
        { 'font-medium' : bold, 'text-gray-700' : !bold },
        { 'sm:pl-6' : firstColumn },
        { 'h-full flex justify-end items-center' : actionButtons }
    ]">
        <slot />
    </td>
</template>

<script>
    export default {
        props: {
            firstColumn: {
                type: Boolean,
                default: false
            },

            bold: {
                type: Boolean,
                default: false
            },

            wrapContent: {
                type: Boolean,
                default: false
            },

            actionButtons: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
