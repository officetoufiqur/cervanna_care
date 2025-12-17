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
        title: 'Hero Banner',
        href: '/banners',
    },
];

interface Banner {
    id: number;
    title: string;
    sub_title: string;
    btn_text: string;
    image: string;
}

const props = defineProps<{
    banner: Banner;
}>()

const form = useForm({
    title: props.banner.title,
    sub_title: props.banner.sub_title,
    btn_text: props.banner.btn_text,
    image: null as File | null,
});


const submit = () => {
    form.post('/banner/update/' + props.banner.id);
}

onMounted(() => {
    $('#image').dropify({
        height: 150,
        defaultFile: props.banner.image,
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

    <Head title="Hero Banner" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Hero Banner Create</h1>
                <LinkButton :label="'Back'" :url="'/banners'" />
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
                            <InputLabel forr="sub_title" :label="'Sub Title'" v-model="form.sub_title" type="text"
                                :placeholder="'Enter your sub title'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.sub_title">{{ form.errors.sub_title
                            }}</span>
                        </div>
                        <div>
                            <InputLabel forr="btn_text" :label="'Button Text'" v-model="form.btn_text" type="text"
                                :placeholder="'Enter your button text'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.btn_text">{{ form.errors.btn_text
                            }}</span>
                        </div>
                        <div>
                            <InputLabel id="image" forr="image" :label="'Image'"
                                @input="form.image = $event.target.files[0]" type="file" />
                            <span class="text-red-500 text-sm" v-if="form.errors.image">{{ form.errors.image }}</span>
                        </div>
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