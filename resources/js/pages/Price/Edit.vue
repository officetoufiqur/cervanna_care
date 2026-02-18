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

interface Price {
    id: number;
    name: string;
    price: string;
}

const props = defineProps<{
    price: Price;
}>()

const form = useForm({

    id: props.price.id,
    name: props.price.name,
    price: props.price.price,

});

const submit = () => {
    form.put('/price/' + props.price.id);
}

</script>

<template>

    <Head title="Price Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Price Update</h1>
                <LinkButton :label="'Back'" :url="'/price'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5 mb-5">
                    
                            <div>
                                <InputLabel forr="name" :label="'Name'" v-model="form.name" type="text"
                                    :placeholder="'Name'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                            </div>

                            <div>
                                <InputLabel forr="price" :label="'Price'" v-model="form.price" type="number"
                                    :placeholder="'Price'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.price">{{ form.errors.price }}</span>
                            </div>

                    </div>
  

                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>