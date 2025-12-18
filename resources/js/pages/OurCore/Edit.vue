<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Our Core',
        href: '/our-core',
    },
];

interface OurCore {
    id: number;
    title: string;
    description: string;
    icon: string;
}

const props = defineProps<{
    core: OurCore;
}>()

const form = useForm({
    title: props.core.title,
    description: props.core.description,
    icon: props.core.icon
});


const submit = () => {
    form.put('/our-cores/' + props.core.id);
}

</script>

<template>

    <Head title="Our Core" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Our Core Edit</h1>
                <LinkButton :label="'Back'" :url="'/our-core'" />
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
                            <InputLabel forr="description" :label="'Sub Title'" v-model="form.description" type="text"
                                :placeholder="'Enter your description'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description }}</span>
                        </div>
                        <div>
                            <Label forr="icon" :label="'Icon'" />
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