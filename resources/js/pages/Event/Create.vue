<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import Label from '@/components/admin/Label.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import { onMounted } from 'vue';
import 'dropify/dist/css/dropify.min.css';
import $ from 'jquery';
import 'dropify';
import { Trash2Icon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Events',
        href: '/events',
    },
];

const form = useForm({
    title: '',
    description: '',
    image: null as File | null,
    items: [
        { name: '', }
    ],
});

const handleImage = (event: Event) => {
    const target = event.target as HTMLInputElement | null
    if (target?.files?.length) {
        form.image = target.files[0]
    }
}

const addItem = () => {
    form.items.push({ name: '' });
}

const removeItem = (index: number) => {
    form.items.splice(index, 1);
}

onMounted(() => {
    $('#image').dropify({
        height: 105,
        messages: {
            default: 'Drag and drop a file here or click',
            replace: 'Drag and drop or click to replace',
            remove: 'Remove',
            error: 'Ooops, something wrong happened.'
        }
    });
});

const submit = () => {
    form.post('/events');
}

</script>

<template>

    <Head title="Events" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create Events</h1>
                <LinkButton :label="'Back'" :url="'/events'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel forr="title" :label="'Title'" v-model="form.title" type="text"
                            :placeholder="'Enter your title'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
                    </div>

                    <div class="space-y-3 grid grid-cols-2 gap-5 mt-5">
                        <div>
                            <Label forr="description" :label="'Description'" />
                            <textarea name="" id="" cols="30" rows="4" v-model="form.description"
                                placeholder="Enter your description" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description
                            }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label forr="image" :label="'Image'" />
                            <input type="file" id="image" @change="handleImage">
                            <span class="text-red-500 text-sm" v-if="form.errors.image">{{ form.errors.image }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-3">
                        <div v-for="(item, index) in form.items" :key="index" class="flex items-end gap-2">
                            <div class="flex-1">
                                <InputLabel forr="name" :label="'Partner Name ' + (index + 1) + ' (Optional)'" v-model="item.name" type="text"
                                    :placeholder="'Enter your event partner name'" />
                            </div>

                            <button v-if="index > 0" type="button" @click="removeItem(index)"
                                class="text-red-500 mb-4 cursor-pointer hover:text-red-700">
                                <Trash2Icon class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                    <div>
                        <button type="button" @click="addItem" class="text-green-500 mb-4 cursor-pointer">Add Event Partner</button>
                    </div>

                    <Button :label="`Submit`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>

<style>
.dropify-wrapper .dropify-preview .dropify-render img {
    width: 100% !important;
    height: auto !important;
    object-fit: contain;
}

.dropify-wrapper .dropify-message p {
    font-size: 16px;
    text-align: center;
}
</style>