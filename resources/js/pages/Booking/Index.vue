<script setup lang="ts">
import FilterTable from '@/components/admin/FilterTable.vue';
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ViewIcon } from 'lucide-vue-next';
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
        specialist_id: string;
        booking_person_id: string;
        booking_amount: string;
        booking_status: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Patient Name', key: 'patient_name' },
    { label: 'Specialist', key: 'specialist.name' },
    { label: 'Booking Person', key: 'user.name' },
    { label: 'Amount', key: 'booking_amount' },
    { label: 'Status', key: 'booking_status' },

    { label: 'Action', key: 'action' }

];

const data = ref(props.bookings);




</script>

<template>

    <Head title="Booking" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="Booking List"
                create-url="#">

                <template #patient_name="{ item }">
                    <span>{{ item.patient_name}}</span>
                </template>

                <template #specialist.name="{ item }">
                    <span>{{ item?.specialist?.name}}</span>
                </template>

                <template #user.name="{ item }">
                    <span>{{ item?.user?.name}}</span>
                </template>

                <template #booking_amount="{ item }">
                    <span>{{ item.booking_amount}}</span>
                </template>

                <template #booking_status="{ item }">
                    <span v-if="item.booking_status === 'pending'" class="bg-yellow-500 text-white px-2 pt-1 pb-1 rounded-full">{{ item.booking_status}}</span>
                    <span v-if="item.booking_status === 'approved'" class="bg-green-500 text-white px-2 pt-1 pb-1 rounded-full">{{ item.booking_status}}</span>
                    <span v-if="item.booking_status === 'rejected'" class="bg-red-500 text-white px-2 pt-1 pb-1 rounded-full">{{ item.booking_status}}</span>
                </template>

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/booking/edit/${item.id}`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <ViewIcon class="w-5 h-5" />
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
