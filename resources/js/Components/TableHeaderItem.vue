<template>
    <th
        :class="[
            width,
            'py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide bg-gray-200',
            { 'sm:pl-6': firstColumn, 'cursor-pointer': showSortOptions }
        ]"
        @click="orderBy"
        scope="col"
    >
        <div class="flex items-center">
            <slot />
            <i
                v-if="showSortOptions && columnName && orderingDirection === 'asc'"
                class="fas fa-chevron-up ml-2"
            ></i>
            <i
                v-if="showSortOptions && columnName && orderingDirection === 'desc'"
                class="fas fa-chevron-down ml-2"
            ></i>
        </div>
    </th>
</template>

<script>
export default {
    props: {
        columnName: {
            type: String,
            required: false
        },

        firstColumn: {
            type: Boolean,
            default: false
        },

        showSortOptions: {
            type: Boolean,
            default: true
        },

        orderingDirection: {
            type: String,
            default: "asc",
            validator: mode => ["asc", "desc"].includes(mode)
        },

        width: {
            type: String
        }
    },

    methods: {
        orderBy() {
            this.$emit("orderBy", this.columnName)
        }
    }
}
</script>
