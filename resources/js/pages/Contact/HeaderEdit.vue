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
        title: 'Contacts Header',
        href: '/contacts',
    },
];

interface Contact {
    id: number;
    heading: string;
    sub_heading: string;
    map: string;
}

const props = defineProps<{
    contact: Contact;
}>()

const form = useForm({
   heading: props.contact.heading,
   sub_heading: props.contact.sub_heading,
   map: props.contact.map
});


const submit = () => {
    form.post('/contact/header/update/' + props.contact.id);
}

</script>

<template>

    <Head title="Contact Header" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Contact Header Edit</h1>
                <LinkButton :label="'Back'" :url="'/contacts'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                    <div class="space-y-3 mb-5">
                        <div>
                            <InputLabel forr="heading" :label="'Heading'" v-model="form.heading" type="text"
                                :placeholder="'Enter your heading'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.heading">{{ form.errors.heading }}</span>
                        </div>
                        <div>
                            <InputLabel forr="subheading" :label="'Sub Heading'" v-model="form.sub_heading" type="text"
                                :placeholder="'Enter your sub heading'" />
                            <span class="text-red-500 text-sm" v-if="form.errors.sub_heading">{{ form.errors.sub_heading
                            }}</span>
                        </div>
                        <div>
                            <Label forr="map" :label="'Map (iframe)'" />
                            <textarea name="" id="" cols="30" rows="3" v-model="form.map" placeholder="Enter your map i frame" class="form-control"></textarea>
                            <span class="text-red-500 text-sm" v-if="form.errors.map">{{ form.errors.map
                            }}</span>
                        </div>
                    </div>
                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>