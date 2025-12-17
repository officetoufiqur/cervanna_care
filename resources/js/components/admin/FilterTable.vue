<script setup lang="ts" generic="T extends { id: number }">
import { ref, computed, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-vue-next';

/* ----------------------------------
   Types
-----------------------------------*/
interface TableColumn<T> {
    key: keyof T | string
    label: string
    icon?: any
}

/* ----------------------------------
   Props
-----------------------------------*/
const props = defineProps<{
    rows: T[]
    columns: TableColumn<T>[]
    title?: string
    createText?: string
    createUrl?: string
    createBtn?: boolean
}>()

/* ----------------------------------
   State
-----------------------------------*/
const entriesPerPage = ref(10)
const currentPage = ref(1)
const search = ref('')

/* ----------------------------------
   Computed
-----------------------------------*/
const filteredData = computed(() => {
    if (!search.value) return props.rows

    return props.rows.filter(item =>
        Object.values(item)
            .join(' ')
            .toLowerCase()
            .includes(search.value.toLowerCase())
    )
})

const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredData.value.length / entriesPerPage.value))
)

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * entriesPerPage.value
    return filteredData.value.slice(start, start + entriesPerPage.value)
})

/* ----------------------------------
   Watchers
-----------------------------------*/
watch([search, entriesPerPage], () => {
    currentPage.value = 1
})
</script>

<template>
    <div class="w-full">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold">{{ title }}</h2>

            <div class="flex gap-2">
                <Link v-if="createBtn" :href="createUrl || '#'"
                    class="bg-[#72275B] hover:bg-[#56284F] px-6 py-2 text-white rounded-md cursor-pointer">
                    {{ createText }}
                </Link>
            </div>
        </div>

        <!-- Filters -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <select v-model="entriesPerPage" class="border px-2 py-1 rounded text-sm border-gray-300">
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                </select>
                <span class="text-sm text-gray-700">entries per page</span>
            </div>

            <div class="text-sm">
                <label class="mr-2">Search:</label>
                <input v-model="search" type="text" class="border px-2 py-1 rounded border-gray-300" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th v-for="col in columns" :key="String(col.key)" class="px-4 py-3 text-left font-medium">
                            {{ col.label }}
                            <component :is="col.icon" v-if="col.icon" class="inline w-4 h-4 ml-1" />
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Empty -->
                    <tr v-if="paginatedData.length === 0">
                        <td :colspan="columns.length" class="text-center py-6 text-gray-500">
                            No data found
                        </td>
                    </tr>

                    <!-- Rows -->
                    <tr v-for="item in paginatedData" :key="item.id" class="border-t">
                        <td v-for="col in columns" :key="String(col.key)" class="px-4 py-3 border">
                            <slot :name="String(col.key)" :item="item">
                                {{ item[col.key as keyof typeof item] }}
                            </slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
            <div>
                Showing
                {{ (currentPage - 1) * entriesPerPage + 1 }}
                to
                {{ Math.min(currentPage * entriesPerPage, filteredData.length) }}
                of {{ filteredData.length }} entries
            </div>

            <div class="flex gap-1">
                <button @click="currentPage--" :disabled="currentPage === 1"
                    class="px-2 py-1 border rounded disabled:opacity-50 cursor-pointer">
                    <ChevronLeftIcon class="w-4 h-4" />
                </button>

                <button class="px-2 py-1 border rounded bg-[#72275B] text-white">
                    {{ currentPage }}
                </button>

                <button @click="currentPage++" :disabled="currentPage >= totalPages"
                    class="px-2 py-1 border rounded disabled:opacity-50 cursor-pointer">
                    <ChevronRightIcon class="w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</template>
