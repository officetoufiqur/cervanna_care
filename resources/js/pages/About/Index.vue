<script setup lang="ts">
import FlashMessage from '@/components/admin/FlashMessage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { SquarePenIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'About',
        href: '/about',
    },
];

const props = defineProps<{
    about: {
        id: number;
        title: string;
        description: string;
        image: string;
        items: {
            id: number;
            tag: string;
            tag_icon: string;
        }[];
    };
    flash: {
        message?: string;
    };
}>();
</script>

<template>

    <Head title="About" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <FlashMessage :message="props.flash.message" />

        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-10">
            <div class="mb-5">
                <h2 class="text-xl font-semibold">About List</h2>

                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full bg-white border rounded-lg">
                        <thead class="bg-gray-100 text-sm text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Image</th>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-left">Tags Icon</th>
                                <th class="px-4 py-3 text-left">Tags</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- No about -->
                            <tr v-if="!props.about">
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    No data found
                                </td>
                            </tr>

                            <!-- Single about row -->
                            <tr v-else class="border-t">
                                <td class="px-4 py-3">{{ props.about.id }}</td>
                                <td class="px-4 py-3">
                                    <img :src="props.about.image" alt="About Image"
                                        class="w-16 h-12 object-cover rounded" />
                                </td>
                                <td class="px-4 py-3">{{ props.about.title }}</td>
                                <td class="px-4 py-3">
                                    {{ props.about.description.length > 40
                                        ? props.about.description.substring(0, 40) + '...'
                                        : props.about.description
                                    }}
                                </td>
                                <td class="px-4 py-3">
                                    <ul class="flex flex-wrap gap-2">
                                        <li v-for="item in props.about.items.slice(0, 2)" :key="item.id"
                                            class="flex items-center gap-1">
                                            <span v-html="item.tag_icon"></span>
                                        </li>
                                        <li v-if="props.about.items.length > 2" class="text-gray-500">
                                            +{{ props.about.items.length - 2 }} more
                                        </li>
                                    </ul>
                                </td>

                                <td class="px-4 py-3">
                                    <ul class="flex flex-wrap gap-2">
                                        <li v-for="item in props.about.items.slice(0, 2)" :key="item.id"
                                            class="flex items-center gap-1">
                                            <span>{{ item.tag }}</span>
                                        </li>
                                        <li v-if="props.about.items.length > 2" class="text-gray-500">
                                            +{{ props.about.items.length - 2 }} more
                                        </li>
                                    </ul>
                                </td>

                                <td class="px-4 py-3">
                                    <Link :href="`/about/edit/${props.about.id}`"
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
