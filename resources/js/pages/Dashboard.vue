<script setup lang="ts">
import Card from '@/components/admin/Card.vue';
import Table from '@/components/admin/Table.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

type Users = {
    id: number;
    name: string;
    email: string;
}

const props = defineProps({
    booking: Number,
    user: Number,
    nurse: Number,
    houseManager: Number,
    physiotherapist: Number,
    nurseAide: Number,
    caregiver: Number,
    agency: Number,
    careInstitution: Number,
    users: Array<Users>,
})



const column = [
    { label: 'Name', key: 'name' },
    { label: 'Email', key: 'email' },
]


</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 px-4">
                <Card title="Total Booking" :value="0" />
                <Card title="Users" :value="user" />
                <Card title="Nurses" value="0" />
                <Card title="House Managers" value="0" />
                <Card title="Physiotherapists" value="0" />
                <Card title="Nurse Aides or Assistants" value="0" />
                <Card title="Caregivers" value="0" />
                <Card title="Agency" value="0" />
                <Card title="Care Institutions" value="0" />
            </div>
            <!-- <div class="flex items-center justify-center space-x-4 px-4">
                <div class="w-full h-[44vh] rounded-xl border border-sidebar-border/70 p-5">
                    <BarChart />
                </div>
                <div class="w-full h-[44vh] rounded-xl border border-sidebar-border/70 p-5">
                    <LineChart />
                </div>
            </div> -->
            <div class="grid grid-cols-1 gap-4 space-x-4 px-4">
                <div class="col-span-2 w-full h-[42vh] rounded-xl border border-sidebar-border/70 p-5">
                    <Table :rows="users" :columns="column" :title="`Active Users`" />
                </div>
                <!-- <div class="w-full h-[42vh] rounded-xl border border-sidebar-border/70 p-5">
                    <div class="">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Performing User</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <Building2Icon class="h-5 w-5 text-[#56284F]" />
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">John Doe</div>
                                    <div class="text-sm text-gray-500">House Manager</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-600 font-medium">40%</div>
                                    <div class="text-xs text-gray-500">Growth</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <img src="/assets/icon/nurse.svg" alt="" class="h-6 w-6 text-pink-600">
                                </div> 
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Zaneya</div>
                                    <div class="text-sm text-gray-500">Nurse</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-600 font-medium">35%</div>
                                    <div class="text-xs text-gray-500">Growth</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <img src="/assets/icon/nurse.svg" alt="" class="h-6 w-6 text-pink-600">
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Ariya</div>
                                    <div class="text-sm text-gray-500">Nurse</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-600 font-medium">35%</div>
                                    <div class="text-xs text-gray-500">Growth</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <img src="/assets/icon/nurse.svg" alt="" class="h-6 w-6 text-pink-600">
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Ariya</div>
                                    <div class="text-sm text-gray-500">Nurse</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-600 font-medium">35%</div>
                                    <div class="text-xs text-gray-500">Growth</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <img src="/assets/icon/nurse.svg" alt="" class="h-6 w-6 text-pink-600">
                                </div>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">Ariya</div>
                                    <div class="text-sm text-gray-500">Nurse</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-600 font-medium">35%</div>
                                    <div class="text-xs text-gray-500">Growth</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </AppLayout>
</template>
