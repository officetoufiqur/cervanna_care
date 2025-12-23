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
        title: 'Contacts',
        href: '/contacts',
    },
];

const props = defineProps<{
    contacts: {
        id: number;
        title: string;
        subtitle: string;
        icon: string;
    }[];
    heading: {
        id: number;
        heading: string;
        sub_heading: string;
        map: string;
    }
    flash: {
        message?: string;
    };
}>()

const columns = [
    { label: 'ID', key: 'id' },
    { label: 'Icon', key: 'icon' },
    { label: 'Title', key: 'title' },
    { label: 'Subtitle', key: 'subtitle' },
    { label: 'Action', key: 'action' },
]

const data = ref(props.contacts);


function deleteContacts(id: number) {
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
            router.delete(`/contacts/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.contacts;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="Contacts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <div class="mb-5">
                <h2 class="text-xl font-semibold">Contact Heading</h2>

                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border rounded-lg">
                        <thead class="bg-gray-100 text-sm text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Heading</th>
                                <th class="px-4 py-3 text-left">Sub Heading</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- No heading -->
                            <tr v-if="!heading">
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    No data found
                                </td>
                            </tr>

                            <!-- Single heading row -->
                            <tr v-else class="border-t">
                                <td class="px-4 py-3">{{ props.heading.id }}</td>
                                <td class="px-4 py-3">{{ props.heading.heading }}</td>
                                <td class="px-4 py-3">
                                    {{ heading.sub_heading.length > 40
                                        ? heading.sub_heading.substring(0, 50) + '...'
                                        : heading.sub_heading
                                    }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <Link :href="`/contacts/header/edit/${heading.id}`"
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

            <FilterTable :rows="data" :columns="columns" title="Contacts Card List" create-btn create-text="Create Contacts"
                create-url="/contacts/create">

                <template #subtitle="{ item }">
                    <span>{{ item.subtitle.length > 40
                        ? item.subtitle.substring(0, 50) + '...'
                        : item.subtitle
                    }}</span>
                </template>
                <template #icon="{ item }">
                    <span v-html="item.icon"></span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/contacts/${item.id}/edit/`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deleteContacts(item.id)"
                            class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
