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
        title: 'Hero Banner',
        href: '/banners',
    },
];

type Banner = {
    id: number
    image: string
    title: string
    sub_title: string
    btn_text: string
}

const props = defineProps<{
    banner: Banner[];
    flash: {
        message?: string;
    };
}>()

const columns = [
    { label: 'ID', key: 'id' },
    { label: 'Image', key: 'image' },
    { label: 'Title', key: 'title' },
    { label: 'Sub Title', key: 'sub_title' },
    { label: 'Button Text', key: 'btn_text' },
    { label: 'Action', key: 'action' },
]

const data = ref(props.banner);


function deleteBanner(id: number) {
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
            router.delete(`/banner/delete/${id}`,{
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.banner;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="Hero Banner" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="Hero Banner List" create-btn create-text="Create Banner"
                create-url="/banners/create">

                <template #image="{ item }">
                    <img :src="item.image" class="w-10 h-10 rounded" />
                </template>

                <template #sub_title="{ item }">
                    <span>{{ item.sub_title.length > 40
                        ? item.sub_title.substring(0, 50) + '...'
                        : item.sub_title
                    }}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/banner/edit/${item.id}`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deleteBanner(item.id)" class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
