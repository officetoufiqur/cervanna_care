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
        title: 'Specialist',
        href: '/all-specialist',
    },
];

const props = defineProps<{
    specialists: {
        id: number;
        name: string;
        email: string;
        profileImage: string;
        number: string;
        role: string;
        subRole: string;
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
    { label: 'Email', key: 'email' },
    { label: 'Role', key: 'role' },
    { label: 'Sub Role', key: 'subRole' },
    { label: 'Profile Complete', key: 'is_profile_completed' },
    { label: 'Profile Verified', key: 'is_profile_verified' },
    { label: 'Created At', key: 'created_at' },
    { label: 'Action', key: 'action' }

];

const data = ref(props.specialists);

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

    <Head title="Specialists" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns"   create-btn create-text="Create Specialist" create-url="/specialist/create">
                <template #name="{ item }">
                    <span>{{ item.name}}</span>
                </template>

                <template #email="{ item }">
                    <span>{{ item.email}}</span>
                </template>


                <template #role="{ item }">
                    <span>{{ item.role}}</span>
                </template>

                <template #subRole="{ item }">
                    <span>{{ item.subRole}}</span>
                </template>

                <template #is_profile_completed="{ item }">
                    <span>{{ item.is_profile_completed ? 'Yes' : 'No'}}</span>
                </template>

                <template #is_profile_verified="{ item }">
                    <span>{{ item.is_profile_verified ? 'Yes' : 'No'}}</span>
                </template>

                <template #created_at="{ item }">
                    <span>{{formatDate(item.created_at)}}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`specialist/edit/${item.id}`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <!-- <button @click="deleteWorks(item.id)"
                            class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button> -->
                    </div>
                </template>
            </FilterTable>
        </div>

    </AppLayout>
</template>




