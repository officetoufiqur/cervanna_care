<script setup lang="ts">
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { SquarePenIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'News Letters',
        href: '/news-letterss',
    },
];

interface Letter {
    id: number;
    title: string;
    sub_title: string;
}

const props = defineProps<{
     newsLetters: Letter,
    flash: {
        message?: string;
    };
}>()

</script>

<template>

    <Head title="News Letters" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-10">
            <FlashMessage :message="props.flash.message" />
            <h2 class="text-xl font-semibold">News Letters List</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg">
                    <thead class="bg-gray-100 text-sm text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Sub Title</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- No newsLetters -->
                        <tr v-if="!newsLetters">
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                No data found
                            </td>
                        </tr>

                        <!-- Single newsLetters row -->
                        <tr v-else class="border-t">
                            <td class="px-4 py-3">{{ props.newsLetters.id }}</td>

                            <td class="px-4 py-3">{{ props.newsLetters.title }}</td>
                            <td class="px-4 py-3">
                                {{ newsLetters.sub_title.length > 40
                                    ? newsLetters.sub_title.substring(0, 50) + '...'
                                    : newsLetters.sub_title
                                }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <Link :href="`/news-letters/edit/${newsLetters.id}`"
                                        class="bg-[#0AB39C] text-sm cursor-pointer hover:bg-[#0AB39C] text-white rounded font-medium hover:bg-[#0AB39C] py-2 px-3">
                                        <SquarePenIcon class="w-5 h-5" />
                                    </Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AppLayout>
</template>
