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
        title: 'Our Core',
        href: '/our-core',
    },
];

const props = defineProps<{
    ourCore: {
        id: number;
        title: string;
        description: string;
        icon: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [
    { label: 'ID', key: 'id' },
    { label: 'Icon', key: 'icon' },
    { label: 'Title', key: 'title' },
    { label: 'Description', key: 'description' },
    { label: 'Action', key: 'action' },
]

const data = ref(props.ourCore);


function deleteourCore(id: number) {
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
            router.delete(`/our-cores/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.ourCore;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="Our Core" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="Our Core List" create-btn create-text="Create Our Core"
                create-url="/our-cores/create">

                <template #description="{ item }">
                    <span>{{ item.description.length > 40
                        ? item.description.substring(0, 50) + '...'
                        : item.description
                    }}</span>
                </template>
                <template #icon="{ item }">
                    <span v-html="item.icon"></span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/our-cores/${item.id}/edit/`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deleteourCore(item.id)"
                            class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
