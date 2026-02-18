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
        title: 'Agency Employees',
        href: '/agency-employees',
    },
];

const props = defineProps<{
    employees: {
        id: number;
        name: string;
        educationLevel: string;
        location: string;
        experience: string;
        cooking: string;
        housekeeping: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Name', key: 'name' },
    { label: 'Education Level', key: 'educationLevel' },
    { label: 'Location', key: 'location' },
    { label: 'Experience', key: 'experience' },
    { label: 'Cooking', key: 'cooking' },
    { label: 'Housekeeping', key: 'housekeeping' },
    { label: 'Action', key: 'action' }

];

const data = ref(props.employees);



</script>

<template>

    <Head title="Agency Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" create-btn create-text="Add New" create-url="/agency-employee/create" title="Agency Employees List">

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
