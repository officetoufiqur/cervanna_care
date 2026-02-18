<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import 'dropify';
import 'dropify/dist/css/dropify.min.css';
import $ from 'jquery';
import { onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'About',
        href: '/about',
    },
];

interface AboutItem {
    id: number;
    tag: string;
    tag_icon: string;
}

interface About {
    id: number;
    title: string;
    description: string;
    image: string;
    items: AboutItem[];
}

const props = defineProps<{
    about: About;
}>();

const form = useForm({
    title: props.about.title,
    description: props.about.description,
    image: null,
    items: (props.about.items ?? []).map(item => ({ ...item }))
});


const submit = () => {
    form.post('/about/update/' + props.about.id);
};

const addItem = () => form.items.push({ id: Date.now(), tag: '', tag_icon: '' });
const removeItem = (index: number) => form.items.splice(index, 1);

onMounted(() => {
    $('#image').dropify({
        defaultFile: props.about.image,
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

    <Head title="About" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">About Edit</h1>
                <LinkButton :label="'Back'" :url="'/about'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Title -->
                    <div>
                        <InputLabel forr="title" :label="'Title'" v-model="form.title" type="text"
                            :placeholder="'Enter your title'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
                    </div>

                    <!-- Description -->
                    <div>
                        <InputLabel forr="description" :label="'Description'" v-model="form.description" type="text"
                            :placeholder="'Enter your description'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description
                        }}</span>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <InputLabel forr="image" id="image" :label="'Image'" @input="form.image = $event.target.files[0]" type="file"
                            :placeholder="'Enter image URL'" />
                        <span class="text-red-500 text-sm" v-if="form.errors.image">{{ form.errors.image }}</span>
                    </div>

                    <!-- Dynamic Items -->
                    <div>
                        <div v-for="(item, index) in form.items" :key="item.id" class="mb-2">
                            <div class=" gap-5">
                                <div class="w-full">
                                    <InputLabel forr="item.tag" :label="'Tags'" v-model="item.tag" type="text"
                                        :placeholder="'Enter your item tag'" />
                                </div>
                                <div class="w-full mt-3">
                                    <InputLabel forr="item.tag_icon" :label="'Tags Icon'" v-model="item.tag_icon"
                                        type="text" :placeholder="'Enter your item tag icon'" />
                                </div>
                            </div>
                            <button type="button" @click="removeItem(index)"
                                class="text-red-500 float-right cursor-pointer">Remove</button>
                        </div>
                        <button type="button" @click="addItem" class="text-green-500 mt-2 cursor-pointer">+ Add
                            Tag</button>
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
