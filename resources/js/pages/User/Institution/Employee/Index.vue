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
        title: 'Institution Employees',
        href: '/institution-employees',
    },
];

const props = defineProps<{
    employees: {
        id: number;
        fullName: string;
        location: string;
        experience: string;
        education: string;
        practiceLicense: string;
        registrationNumber: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Full Name', key: 'fullName' },
    { label: 'Location', key: 'location' },
    { label: 'Experience', key: 'experience' },
    { label: 'Education', key: 'education' },
    { label: 'Practice License', key: 'practiceLicense' },
    { label: 'Registration Number', key: 'registrationNumber' },
    { label: 'Action', key: 'action' }

];

const data = ref(props.employees);


function deleteEmployee(id: number) {
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
            router.delete(`/institution-employee/delete/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.employees;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="Institution Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" create-btn create-text="Add New" create-url="/institution-employee/create" title="Institution Employees List">

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`institution-employee/edit/${item.id}`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deleteEmployee(item.id)" class="bg-red-500 text-sm cursor-pointer text-white rounded font-medium hover:bg-red-600 py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
