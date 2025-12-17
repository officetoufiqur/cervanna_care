<script setup lang="ts">
import FilterTable from '@/components/admin/FilterTable.vue';
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { SquarePenIcon, Trash2Icon } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Faqs',
        href: '/faqs',
    },
];

type Faqs = {
    id: number
    question: string
    answer: string
}

const props = defineProps<{
    faqs: Faqs[];
    header: {
        id: number;
        title: string;
        subtitle: string;
        image: string;
    }
    flash: {
        message?: string;
    };
}>()

const columns = [
    { label: 'ID', key: 'id' },
    { label: 'Question', key: 'question' },
    { label: 'Answer', key: 'answer' },
    { label: 'Action', key: 'action' },
]

const data = ref(props.faqs);


function deletefaqs(id: number) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/faqs/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.faqs;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="faqs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <div class="mb-5">
                <h2 class="text-xl font-semibold">Faqs Heading</h2>

                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border rounded-lg">
                        <thead class="bg-gray-100 text-sm text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Image</th>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Sub Title</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- No header -->
                            <tr v-if="!header">
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    No data found
                                </td>
                            </tr>

                            <!-- Single header row -->
                            <tr v-else class="border-t">
                                <td class="px-4 py-3">{{ props.header.id }}</td>
                                <td class="px-4 py-3">
                                    <img :src="header.image" alt="header image" class="w-10 h-10" />
                                </td>

                                <td class="px-4 py-3">{{ props.header.title }}</td>
                                <td class="px-4 py-3">
                                    {{ header.subtitle.length > 40
                                        ? header.subtitle.substring(0, 50) + '...'
                                        : header.subtitle
                                    }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <Link :href="`/faqs/header/edit/${header.id}`"
                                            class="bg-[#0AB39C] text-sm cursor-pointer hover:bg-[#0AB39C] text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                                            <SquarePenIcon class="w-5 h-5" />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <FilterTable :rows="data" :columns="columns" title="Faqs List" create-btn create-text="Create Faqs"
                create-url="/faqs/create">

                <template #answer="{ item }">
                    <span>{{ item.answer.length > 40
                        ? item.answer.substring(0, 50) + '...'
                        : item.answer
                    }}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/faqs/${item.id}/edit/`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deletefaqs(item.id)"
                            class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
