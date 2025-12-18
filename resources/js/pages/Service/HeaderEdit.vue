<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Services Header',
        href: '/services',
    },
];

interface Service {
    id: number;
    title: string;
    subtitle: string;
}

const props = defineProps<{
    service: Service;
}>()

const form = useForm({
    title: props.service.title,
    subtitle: props.service.subtitle
});


const submit = () => {
    form.post('/service/header/update/' + props.service.id);
}

</script>

<template>

    <Head title="Services Header" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Services Header Edit</h1>
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
                                :placeholder="'Enter your sub title'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.subtitle">{{ form.errors.subtitle
                            }}</span>
                        </div>
                    </div>
                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>