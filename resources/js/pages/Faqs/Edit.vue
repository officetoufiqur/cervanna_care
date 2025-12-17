<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Faqs',
        href: '/faqs',
    },
];

interface Faq {
    id: number;
    question: string;
    answer: string;
}

const props = defineProps<{
    faq: Faq;
}>()

const form = useForm({
    question: props.faq.question,
    answer: props.faq.answer,
});


const submit = () => {
    form.put('/faqs/' + props.faq.id);
}

</script>

<template>

    <Head title="Faqs" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Faqs Create</h1>
                <LinkButton :label="'Back'" :url="'/faqs'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                    <div class="space-y-3 mb-5">
                        <div class="space-y-3 mb-5">
                            <div>
                                <InputLabel forr="question" :label="'Question'" v-model="form.question" type="text"
                                    :placeholder="'Enter your question'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.question">{{ form.errors.question
                                    }}</span>
                            </div>
                            <div>
                                <Label forr="answer" :label="'Answer'" />
                                <textarea name="" id="" cols="30" rows="5" v-model="form.answer"
                                    placeholder="Enter your answer" class="form-control"></textarea>
                                <span class="text-red-500 text-sm" v-if="form.errors.answer">{{ form.errors.answer
                                    }}</span>
                            </div>
                        </div>
                    </div>
                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>