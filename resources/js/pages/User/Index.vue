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
        title: 'User',
        href: '/users',
    },
];

const props = defineProps<{
    users: {
        id: number;
        name: string;
        email: string;
        profileImage: string;
        number: string;
        role: string;
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
    { label: 'Profile Image', key: 'profileImage' },
    { label: 'Number', key: 'number' },
    { label: 'Role', key: 'role' },
    { label: 'Profile Verified', key: 'is_profile_verified' },
    { label: 'Created At', key: 'created_at' },

    { label: 'Action', key: 'action' }

];

const data = ref(props.users);

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

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="User List" 
                create-url="#">

                <template #name="{ item }">
                    <span>{{ item.name}}</span>
                </template>

                <template #email="{ item }">
                    <span>{{ item.email}}</span>
                </template>

                <template #profileImage="{ item }">
                    <img
                        v-if="item.profileImage"
                        :src="item.profileImage"
                        alt="Profile"
                        class="w-10 h-10 rounded-full object-cover border"
                    />
                    <span v-else>No Image</span>
                </template>

                <template #number="{ item }">
                    <span>{{ item.number}}</span>
                </template>

                <template #role="{ item }">
                    <span>{{ item.role}}</span>
                </template>

                <template #is_profile_verified="{ item }">
                    <span>{{ item.is_profile_verified}}</span>
                </template>

                <template #created_at="{ item }">
                    <span>{{formatDate(item.created_at)}}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/user/edit/${item.id}`"
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
