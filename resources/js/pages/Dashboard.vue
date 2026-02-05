<script setup lang="ts">
import Card from '@/components/admin/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '#'
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
});



const column = [
    { label: 'Name', key: 'name' },
    { label: 'Email', key: 'email' },
];


</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3 px-4">
                <Card title="Total Booking" :value="booking" />
                <Card title="Users" :value="user" />
                <Card title="Nurses" :value="nurse" />
                <Card title="House Managers" :value="houseManager" />
                <Card title="Physiotherapists" :value="physiotherapist" />
                <Card title="Nurse Aides or Assistants" :value="nurseAide" />
                <Card title="Caregivers" :value="caregiver" />
                <Card title="Agency" :value="agency" />
                <Card title="Care Institutions" :value="careInstitution" />
            </div>
            <!-- <div class="flex items-center justify-center space-x-4 px-4">
                <div class="w-full h-[44vh] rounded-xl border border-sidebar-border/70 p-5">
                    <BarChart />
                </div>
                <div class="w-full h-[44vh] rounded-xl border border-sidebar-border/70 p-5">
                    <LineChart />
                </div>
            </div> -->

        </div>
    </AppLayout>
</template>
