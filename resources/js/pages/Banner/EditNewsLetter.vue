<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'News Letters',
        href: '/banners',
    },
];

interface Letter {
    id: number;
    title: string;
    sub_title: string;
}

const props = defineProps<{
    newsLetters: Letter;
}>()

const form = useForm({
    title: props.newsLetters.title,
    sub_title: props.newsLetters.sub_title
});


const submit = () => {
    form.post('/news-letters/update/' + props.newsLetters.id);
}

</script>

<template>

    <Head title="News Letters" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">News Letters Edit</h1>
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
                    </div>
                    <Button :label="`Submit`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>