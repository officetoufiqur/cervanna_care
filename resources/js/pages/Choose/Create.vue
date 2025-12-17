<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import Label from '@/components/admin/Label.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Chooses',
        href: '/chooses',
    },
];

const form = useForm({
    title: '',
    subtitle: '',
    icon: '',
});


const submit = () => {
    form.post('/chooses');
}

</script>

<template>

    <Head title="Chooses" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Chooses Create</h1>
                <LinkButton :label="'Back'" :url="'/chooses'" />
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
                            <Label forr="icon" :label="'Icon (Only svg)'" />
                            <textarea name="" id="" cols="30" rows="3" v-model="form.icon" placeholder="Enter your icon" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.icon">{{ form.errors.icon }}</span>
                        </div>
                    </div>
                    <Button :label="`Submit`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>