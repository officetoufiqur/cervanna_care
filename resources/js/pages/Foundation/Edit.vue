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
        title: 'Foundation',
        href: '/foundation',
    },
];


interface Foundation {
    id: number;
    heading: string;
    subheading: string;
    vision_title: string;
    vision_subtitle: string;
    mission_title: string;
    mission_subtitle: string;
    image: string;
}

const props = defineProps<{
    foundation: Foundation;
}>();

const form = useForm({
    heading: props.foundation.heading,
    subheading: props.foundation.subheading,
    vision_title: props.foundation.vision_title,
    vision_subtitle: props.foundation.vision_subtitle,
    mission_title: props.foundation.mission_title,
    mission_subtitle: props.foundation.mission_subtitle,
    image: null as File | null,
});


const submit = () => {
    form.put('/foundation/' + props.foundation.id);
};


onMounted(() => {
    $('#image').dropify({
        defaultFile: props.foundation.image,
        height: 120,
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

    <Head title="Foundation" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Foundation Edit</h1>
                <LinkButton :label="'Back'" :url="'/foundation'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" class="space-y-4">

                    <!-- Title -->
                    <div>
                        <InputLabel forr="heading" :label="'Heading'" v-model="form.heading" type="text"
                            :placeholder="'Enter your heading'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.heading">{{ form.errors.heading }}</span>
                    </div>

                    <!-- subheading -->
                    <div>
                        <InputLabel forr="subheading" :label="'subheading'" v-model="form.subheading" type="text"
                            :placeholder="'Enter your subheading'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.subheading">{{ form.errors.subheading
                            }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- vision_title -->
                        <div>
                            <InputLabel forr="vision_title" :label="'Vision Title'" v-model="form.vision_title"
                                type="text" :placeholder="'Enter your vision_title'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.vision_title">{{
                                form.errors.vision_title
                                }}</span>
                        </div>
                        <!-- mission_title -->
                        <div>
                            <InputLabel forr="mission_title" :label="'Mission Title'" v-model="form.mission_title"
                                type="text" :placeholder="'Enter your mission_title'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.mission_title">{{
                                form.errors.mission_title
                                }}</span>
                        </div>
                    </div>

                    <!-- vision_subtitle -->
                    <div>
                        <InputLabel forr="vision_subtitle" :label="'Vision Subtitle'" v-model="form.vision_subtitle"
                            type="text" :placeholder="'Enter your vision_subtitle'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.vision_subtitle">{{
                            form.errors.vision_subtitle
                            }}</span>
                    </div>

                    <!-- mission_subtitle -->
                    <div>
                        <InputLabel forr="mission_subtitle" :label="'Mission Subtitle'" v-model="form.mission_subtitle"
                            type="text" :placeholder="'Enter your mission_subtitle'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.mission_subtitle">{{
                            form.errors.mission_subtitle
                            }}</span>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <InputLabel forr="image" id="image" :label="'Image'"
                            @input="form.image = $event.target.files[0]" type="file" :placeholder="'Enter image URL'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.image">{{ form.errors.image }}</span>
                    </div>

                    <Button :label="'Update'" :type="'submit'" />
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