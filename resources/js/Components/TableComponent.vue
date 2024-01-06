<template>
    <div class="overflow-x-auto overflow-y-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="rounded-md">
                <table :class="['min-w-full divide-y divide-gray-300 bg-white', layoutType]">
                    <thead class="bg-gray-50 ">
                        <tr>
                            <slot name="headers" />
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white ">
                        <slot name="rows" />
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            layoutType: {
                type: String,
                default: 'table-auto'
            }
        }
    }
</script>
