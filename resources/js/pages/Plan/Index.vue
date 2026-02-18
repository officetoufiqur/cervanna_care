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
        title: 'Plan',
        href: '/plan',
    },
];

const props = defineProps<{
    plans: {
        id: number;
        name: string;
        price: string;
        description: string;
    }[];
    flash: {
        message?: string;
    };
}>()

const columns = [

    { label: 'ID', key: 'id' },
    { label: 'Name', key: 'name' },
    { label: 'Price', key: 'price' },
    { label: 'Description', key: 'description' },

    { label: 'Action', key: 'action' }

];

const data = ref(props.plans);



function deletePlan(id: number) {
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
            router.delete(`/plan/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    data.value = props.plans;
                }
            });
        }
    })
}

</script>

<template>

    <Head title="Plan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <FilterTable :rows="data" :columns="columns" title="Plan List" create-btn create-text="Create Plan"
                create-url="/plan/create">

                <template #name="{ item }">
                    <span>{{ item.name}}</span>
                </template>

                <template #price="{ item }">
                    <span>{{ item.price}}</span>
                </template>

                <template #description="{ item }">
                    <span>{{ item.description}}</span>
                </template>


                <!-- <template #status="{ item }">
                    <span v-if="item.status === 'active'" class="bg-yellow-500 text-white px-2 pt-1 pb-1 rounded-full">{{ item.status}}</span>
                    <span v-if="item.status === 'inactive'" class="bg-green-500 text-white px-2 pt-1 pb-1 rounded-full">{{ item.status}}</span>
                </template> -->

                <template #action="{ item }">
                    <div class="flex items-center gap-2">
                        <Link :href="`/plan/${item.id}/edit`"
                            class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                            <SquarePenIcon class="w-5 h-5" />
                        </Link>
                        <button @click="deletePlan(item.id)"
                            class="bg-[#F06548] text-sm cursor-pointer text-white rounded font-medium py-2 px-3">
                            <Trash2Icon class="w-5 h-5" />
                        </button>
                    </div>
                </template>
            </FilterTable>
        </div>
    </AppLayout>
</template>
