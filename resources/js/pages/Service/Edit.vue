<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import { onMounted } from 'vue';
import 'dropify/dist/css/dropify.min.css';
import $ from 'jquery';
import 'dropify';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Services',
        href: '/services',
    },
];

interface Service {
    id: number;
    title: string;
    subtitle: string;
    image: string;
    icon: string;
}

const props = defineProps<{
    service: Service;
}>()

const form = useForm({
    title: props.service.title,
    subtitle: props.service.subtitle,
    image: null,
    icon: props.service.icon
});


const submit = () => {
    form.put('/services/' + props.service.id);
}

onMounted(() => {
    $('#image').dropify({
        height: 120,
        defaultFile: props.service.image,
        messages: {
            default: 'Drag and drop a file here or click',
            replace: 'Drag and drop or click to replace',
            remove: 'Remove',
            error: 'Ooops, something wrong happened.'
        }
    });
});

</script>

<template>

    <Head title="Services" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Services Edit</h1>
                <LinkButton :label="'Back'" :url="'/services'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 mb-5">
                        <div>
                            <InputLabel forr="title" :label="'Title'" v-model="form.title" type="text"
                                :placeholder="'Enter your title'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
                        </div>
                        <div>
                            <InputLabel forr="subtitle" :label="'Sub Title'" v-model="form.subtitle" type="text"
                                :placeholder="'Enter your subtitle'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.subtitle">{{ form.errors.subtitle }}</span>
                        </div>
                        <div>
                            <InputLabel forr="image" :label="'Image'" id="image" @input="form.image = $event.target.files[0]" type="file" />
                            <span class="text-red-500 text-sm" v-if="form.errors.image">{{ form.errors.image }}</span>
                        </div>
                        <div>
                            <Label forr="icon" :label="'Icon (SVG)'" />
                            <textarea name="" id="" cols="30" rows="3" v-model="form.icon" placeholder="Enter your icon" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.icon">{{ form.errors.icon }}</span>
                        </div>
                    </div>
                    <Button :label="`Update`" :type="`submit`" />
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