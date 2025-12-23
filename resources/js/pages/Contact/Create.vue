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
        title: 'Contacts',
        href: '/contacts',
    },
];

const form = useForm({
    title: '',
    subtitle: '',
    icon: '',
});

const submit = () => {
    form.post('/contacts');
}

</script>

<template>

    <Head title="Contacts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create Contacts</h1>
                <LinkButton :label="'Back'" :url="'/contacts'" />
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
                            <Label forr="subtitle" :label="'Subtitle'" />
                            <textarea name="" id="" cols="30" rows="4" v-model="form.subtitle"
                                placeholder="Enter your subtitle" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.subtitle">{{ form.errors.subtitle
                            }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <Label forr="icon" :label="'Icon'" />
                            <textarea name="" id="" cols="30" rows="4" v-model="form.icon" placeholder="Enter your icon" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.icon">{{ form.errors.icon }}</span>
                        </div>
                    </div>

                    <Button :label="`Submit`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>
