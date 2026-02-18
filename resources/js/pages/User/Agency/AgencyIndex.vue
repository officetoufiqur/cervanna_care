<script setup lang="ts">
import FilterTable from '@/components/admin/FilterTable.vue';
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { SquarePenIcon } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Agency & Institution',
        href: '/all-agency',
    },
];

const props = defineProps<{
    agencies: {
        id: number;
        agency?: {
            companyName: string;
        };
        care_institution?: {
            companyName: string;
        };
        role: string;
        is_profile_completed: boolean;
        is_profile_verified: boolean;
        created_at: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Name', key: 'name' },
    { label: 'Role', key: 'role' },
    { label: 'Profile Complete', key: 'is_profile_completed' },
    { label: 'Profile Verified', key: 'is_profile_verified' },
    { label: 'Created At', key: 'created_at' },
    { label: 'Action', key: 'action' }

];

const data = ref(props.agencies);

const formatDate = (date: string) => {
    return new Date(date).toLocaleString(undefined, {
        year: 'numeric',
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    });
};



</script>

<template>

    <Head title="Agency & Institution" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" create-btn create-text="Add New" create-url="agency/create" title="Agency & Institution List">

                <template #name="{ item }">
                    <span>{{ item.agency?.companyName || item.care_institution?.companyName}}</span>
                </template>

                <template #role="{ item }">
                    <span>{{ item.role}}</span>
                </template>

                <template #is_profile_completed="{ item }">
                    <span>{{ item.is_profile_completed ? 'True' : 'False'}}</span>
                </template>

                <template #is_profile_verified="{ item }">
                    <span>{{ item.is_profile_verified ? 'True' : 'False'}}</span>
                </template>

                <template #created_at="{ item }">
                    <span>{{formatDate(item.created_at)}}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`agency/edit/${item.id}`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
