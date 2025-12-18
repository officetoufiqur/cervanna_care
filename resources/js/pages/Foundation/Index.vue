<script setup lang="ts">
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { SquarePenIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Foundation',
        href: '/foundation',
    },
];

const props = defineProps<{
    foundation: {
        id: number;
        heading: string;
        subheading: string;
        vision_title: string;
        vision_subtitle: string;
        mission_title: string;
        mission_subtitle: string;
        image: string;
    };
    flash: {
        message?: string;
    };
}>();
</script>

<template>

    <Head title="Foundation" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <div class="mb-5">
                <h2 class="text-xl font-semibold">Foundation List</h2>

                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border rounded-lg">
                        <thead class="bg-gray-100 text-sm text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Image</th>
                                <th class="px-4 py-3 text-left">Heading</th>
                                <th class="px-4 py-3 text-left">Sub Heading</th>
                                <th class="px-4 py-3 text-left">Vision Title</th>
                                <th class="px-4 py-3 text-left">Mission Title</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- No Foundation -->
                            <tr v-if="!props.foundation">
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    No data found
                                </td>
                            </tr>

                            <!-- Single Foundation row -->
                            <tr v-else class="border-t">
                                <td class="px-4 py-3">{{ props.foundation.id }}</td>
                                <td class="px-4 py-3">
                                    <img :src="props.foundation.image" alt="foundation Image"
                                        class="w-16 h-12 object-cover rounded" />
                                </td>
                                <td class="px-4 py-3">{{ props.foundation.heading }}</td>
                                <td class="px-4 py-3">
                                    {{ props.foundation.subheading.length > 40
                                        ? props.foundation.subheading.substring(0, 40) + '...'
                                        : props.foundation.subheading
                                    }}
                                </td>
                                <td class="px-4 py-3">{{ props.foundation.vision_title }}</td>
                                <td class="px-4 py-3">{{ props.foundation.mission_title }}</td>
                                <td class="px-4 py-3">
                                    <Link :href="`/foundation/${props.foundation.id}/edit`"
                                        class="bg-[#0AB39C] text-sm cursor-pointer text-white rounded font-medium w-10 h-9 p-1 flex items-center justify-center gap-1 hover:bg-[#089b8a]">
                                        <SquarePenIcon class="w-5 h-5" />
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
