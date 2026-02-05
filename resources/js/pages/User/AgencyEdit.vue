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
        title: 'Edit Agency and Care Institution',
        href: '/agency',
    },
];

interface Agency {
    id: number;
    agency: {
        companyName : string;
        kraPin : string;
        companyRegistrationNumber : string;
        number : string;
        businessLocation : string;
        registrationDocument : string;
        agency_services : string;
        placementFee : string;
        replacementWindow : string;
        numberOfReplacement : string;
    }
    care_institution: {
        companyName : string;
        kraPin : string;
        companyRegistrationNumber : string;
        number : string;
        businessLocation : string;
        registrationDocument : string;
    }

    role: string;

    is_profile_verified: boolean;
    is_profile_completed: boolean;
    created_at: string;
}

const props = defineProps<{
    agency: Agency;
}>()

const source =
    props.agency.role === 'agency'
        ? props.agency.agency
        : props.agency.care_institution;

const form = useForm({
    id: props.agency.id,

    companyName: source?.companyName ?? '',
    kraPin: source?.kraPin ?? '',
    companyRegistrationNumber: source?.companyRegistrationNumber ?? '',
    number: source?.number ?? '',
    businessLocation: source?.businessLocation ?? '',

    registrationDocument: source?.registrationDocument ?? '',

    agency_services: props.agency.agency?.agency_services ?? '',
    placementFee: props.agency.agency?.placementFee ?? '',
    replacementWindow: props.agency.agency?.replacementWindow ?? '',
    numberOfReplacement: props.agency.agency?.numberOfReplacement ?? '',

    role: props.agency.role,
    is_profile_completed: props.agency.is_profile_completed,
    is_profile_verified: props.agency.is_profile_verified,
});


const submit = () => {
    form.put('/agency/update/' + props.agency.id);
}

onMounted(() => {
    $('#image').dropify({
        defaultFile: source?.registrationDocument,
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

    <Head title="Agency & Institution Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Agency & Institution Update</h1>
                <LinkButton :label="'Back'" :url="'/all-agency'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                                <div>
                                    <InputLabel forr="companyName" :label="'Company Name'" v-model="form.companyName" type="text"
                                        :placeholder="'Company Name'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.companyName">{{ form.errors.companyName }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="kraPin" :label="'KRA PIN'" v-model="form.kraPin" type="text"
                                        :placeholder="'KRA PIN'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.kraPin">{{ form.errors.kraPin }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="companyRegistrationNumber" :label="'Company Registration Number'" v-model="form.companyRegistrationNumber" type="text"
                                        :placeholder="'Company Registration Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.companyRegistrationNumber">{{ form.errors.companyRegistrationNumber }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="number" :label="'Number'" v-model="form.number" type="text"
                                        :placeholder="'Number'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="businessLocation" :label="'Business Location'" v-model="form.businessLocation" type="text"
                                        :placeholder="'Business Location'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.businessLocation">{{ form.errors.businessLocation }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="image" id="image" :label="'Registration Document'" @input="form.registrationDocument = $event.target.files[0]" type="file"
                                        :placeholder="'Enter image URL'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.registrationDocument">{{ form.errors.registrationDocument }}</span>
                                </div>

                                <template v-if="form.role == 'agency'">
                                <div>
                                    <InputLabel forr="agency_services" :label="'Agency Services'" v-model="form.agency_services" type="text"
                                        :placeholder="'Agency Services'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.agency_services">{{ form.errors.agency_services }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="placementFee" :label="'Placement Fee'" v-model="form.placementFee" type="text"
                                        :placeholder="'Placement Fee'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.placementFee">{{ form.errors.placementFee }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="replacementWindow" :label="'Replacement Window'" v-model="form.replacementWindow" type="text"
                                        :placeholder="'Replacement Window'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.replacementWindow">{{ form.errors.replacementWindow }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="numberOfReplacement" :label="'Number of Replacement'" v-model="form.numberOfReplacement" type="text"
                                        :placeholder="'Number of Replacement'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.numberOfReplacement">{{ form.errors.numberOfReplacement }}</span>
                                </div>
                                </template>
                                <div>
                                    <InputLabel forr="role" :label="'Role'" v-model="form.role" type="text"
                                        :placeholder="'Role'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.role">{{ form.errors.role }}</span>
                                </div>

                                <div class="mt-5 mb-8">
                                    <h1 class="text-sm font-medium mb-2">Profile Complete</h1>

                                    <select
                                        class="form-control"
                                        name="is_profile_completed"
                                        id="is_profile_completed"
                                        v-model="form.is_profile_completed"
                                        :disabled="form.is_profile_completed"
                                    >
                                        <option :value="false">False</option>
                                        <option :value="true">True</option>
                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.is_profile_completed"
                                    >
                                        {{ form.errors.is_profile_completed }}
                                    </span>
                                </div>

                                <div class="mt-5 mb-8">
                                    <h1 class="text-sm font-bold mb-2">Profile Verified</h1>

                                    <select
                                        class="form-control"
                                        name="is_profile_verified"
                                        id="is_profile_verified"
                                        v-model.boolean="form.is_profile_verified"
                                    >
                                        <option :value="false">False</option>
                                        <option :value="true">True</option>
                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.is_profile_verified"
                                    >
                                        {{ form.errors.is_profile_verified }}
                                    </span>
                                </div>


                        </div>
                    </div>

                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>







