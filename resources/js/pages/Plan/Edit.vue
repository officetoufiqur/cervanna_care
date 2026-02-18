<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Price',
        href: '/price',
    },          
];

interface Plan {
    id: number;
    name: string;
    price: string;
    description: string;
}

const props = defineProps<{
    plan: Plan;
}>()

const form = useForm({

    id: props.plan.id,
    name: props.plan.name,
    price: props.plan.price,
    description: props.plan.description,

});

const submit = () => {
    form.put('/plan/' + props.plan.id);
}

</script>

<template>

    <Head title="Plan Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Plan Update</h1>
                <LinkButton :label="'Back'" :url="'/plan'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                    <div class="space-y-3 mb-5">
                        <div>
                            <InputLabel forr="name" :label="'Name'" v-model="form.name" type="text"
                                :placeholder="'Enter your name'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                        </div>
                        <div>
                            <InputLabel forr="price" :label="'Price'" v-model="form.price" type="number"
                                :placeholder="'Enter your price'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.price">{{ form.errors.price }}</span>
                        </div>
                        <div>
                            <Label forr="description" :label="'Description'" />
                            <textarea name="description" id="" cols="30" rows="3" v-model="form.description" placeholder="Enter your description" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description }}</span>
                        </div>
                    </div>
                    <Button :label="`Submit`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>