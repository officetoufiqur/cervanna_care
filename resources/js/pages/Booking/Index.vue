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
        title: 'Booking',
        href: '/booking',
    },
];

const props = defineProps<{
    bookings: {
        id: number;
        patient_name: string;
        patient_age: string;
        patient_gender: string;
        relationship_to_booking_person: string;
        booking_amount: string;
        patient_have_any_conditions: string;
        mobility_status_of_patient: string;
        care_start_date: string;
        care_end_date: string;
        booking_status: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Patient Name', key: 'patient_name' },
    { label: 'Patient Age', key: 'patient_age' },
    { label: 'Patient Gender', key: 'patient_gender' },
    { label: 'Relationship', key: 'relationship_to_booking_person' },
    { label: 'Booking Amount', key: 'booking_amount' },
    { label: 'Has Conditions', key: 'patient_have_any_conditions' },
    { label: 'Mobility Status', key: 'mobility_status_of_patient' },
    { label: 'Care Start Date', key: 'care_start_date' },
    { label: 'Care End Date', key: 'care_end_date' },
    { label: 'Booking Status', key: 'booking_status' },


    { label: 'Action', key: 'action' }

];

const data = ref(props.bookings);




</script>

<template>

    <Head title="Booking" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="Booking List" create-btn create-text="Create Booking"
                create-url="#">

                <template #patient_name="{ item }">
                    <span>{{ item.patient_name}}</span>
                </template>

                <template #patient_age="{ item }">
                    <span>{{ item.patient_age}}</span>
                </template>

                <template #patient_gender="{ item }">
                    <span>{{ item.patient_gender}}</span>
                </template>

                <template #relationship_to_booking_person="{ item }">
                    <span>{{ item.relationship_to_booking_person}}</span>
                </template>

                <template #booking_amount="{ item }">
                    <span>{{ item.booking_amount}}</span>
                </template>

                <template #patient_have_any_conditions="{ item }">
                    <span>{{ item.patient_have_any_conditions}}</span>
                </template>

                <template #mobility_status_of_patient="{ item }">
                    <span>{{ item.mobility_status_of_patient}}</span>
                </template>

                <template #care_start_date="{ item }">
                    <span>{{ item.care_start_date}}</span>
                </template>

                <template #care_end_date="{ item }">
                    <span>{{ item.care_end_date}}</span>
                </template>

                <template #booking_status="{ item }">
                    <span>{{ item.booking_status}}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`#`"
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
