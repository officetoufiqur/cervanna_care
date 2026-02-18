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

interface AgencySource {
    companyName?: string;
    kraPin?: string;
    companyRegistrationNumber?: string;
    number?: string;
    businessLocation?: string;
    registrationDocument?: string;
    agency_services?: string[];
    placementFee?: string;
    replacementWindow?: string;
    numberOfReplacement?: string;
}

interface Agency {
    id: number;
    agency?: {
        companyName: string;
        kraPin: string;
        companyRegistrationNumber: string;
        number: string;
        businessLocation: string;
        registrationDocument: string;
        agency_services: string[];
        placementFee: string;
        replacementWindow: string;
        numberOfReplacement: string;
    };
    care_institution?: { 
        companyName: string;
        kraPin: string;
        companyRegistrationNumber: string;
        number: string;
        businessLocation: string;
        registrationDocument: string;
    };

    role: string;
    email: string;
    number: string;
    is_profile_verified: boolean;
    is_profile_completed: boolean;
}

const props = defineProps<{
    agency: Agency;
}>();

const source: AgencySource =
    props.agency.role === 'agency'
        ? props.agency.agency ?? {}
        : props.agency.care_institution ?? {};

const form = useForm({
    id: props.agency.id,

    companyName: source?.companyName ?? '',
    kraPin: source?.kraPin ?? '',
    companyRegistrationNumber: source?.companyRegistrationNumber ?? '',
    alternative_number: source?.number ?? '',
    businessLocation: source?.businessLocation ?? '',

    registrationDocument: null as File | null,

    agency_services: props.agency.agency?.agency_services ?? [],
    placementFee: props.agency.agency?.placementFee ?? '',
    replacementWindow: props.agency.agency?.replacementWindow ?? '',
    numberOfReplacement: props.agency.agency?.numberOfReplacement ?? '',

    role: props.agency.role,
    email: props.agency.email,
    number: props.agency.number,
    is_profile_completed: props.agency.is_profile_completed,
    is_profile_verified: props.agency.is_profile_verified,
    _method: 'put'
});

const submit = () => {
    form.post('/agency/update/' + props.agency.id, {
        forceFormData: true,
    });
};

const agencyServices = [
    'Cooking',
    'House Keeping',
    'First Aid',
    'Childcare',
    'Communication',
    'None'
];

onMounted(() => {
    $('#image').dropify({
        defaultFile: source?.registrationDocument ?? '',
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
                <h1 class="text-2xl font-medium mb-4">
                    Agency & Institution Update
                </h1>
                <LinkButton :label="'Back'" :url="'/all-agency'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                            <div class="hidden">
                                <InputLabel
                                    forr="role"
                                    :label="'Role'"
                                    v-model="form.role"
                                    type="text"
                                />
                                <span class="text-red-500 text-sm" v-if="form.errors.role">
                                    {{ form.errors.role }}
                                </span>
                            </div>

                            <div>
                                <InputLabel
                                    forr="number"
                                    :label="'Number'"
                                    v-model="form.number"
                                    type="number"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    forr="companyName"
                                    :label="'Company Name'"
                                    v-model="form.companyName"
                                    type="text"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    forr="email"
                                    :label="'Email'"
                                    v-model="form.email"
                                    type="text"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    forr="kraPin"
                                    :label="'KRA PIN'"
                                    v-model="form.kraPin"
                                    type="text"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    forr="companyRegistrationNumber"
                                    :label="'Company Registration Number'"
                                    v-model="form.companyRegistrationNumber"
                                    type="text"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    forr="alternative_number"
                                    :label="'Alternative Number'"
                                    v-model="form.alternative_number"
                                    type="text"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    forr="businessLocation"
                                    :label="'Business Location'"
                                    v-model="form.businessLocation"
                                    type="text"
                                />
                            </div>

                            <div>
                                <label class="block mb-2">Registration Document</label>
                                <input
                                    id="image"
                                    type="file"
                                    @change="form.registrationDocument = $event.target.files[0]"
                                    class="dropify"
                                />
                            </div>

                            <template v-if="form.role === 'agency'">
                                <div class="mb-6">
                                    <label class="text-lg font-medium mb-2 block">
                                        Agency Services
                                    </label>

                                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                                        <div
                                            v-for="item in agencyServices"
                                            :key="item"
                                            class="flex items-center space-x-2"
                                        >
                                            <input
                                                type="checkbox"
                                                :value="item"
                                                v-model="form.agency_services"
                                            />
                                            <label>{{ item }}</label>
                                        </div>
                                    </div>
                                </div>

                                <InputLabel
                                    forr="placementFee"
                                    :label="'Placement Fee'"
                                    v-model="form.placementFee"
                                    type="text"
                                />

                                <InputLabel
                                    forr="replacementWindow"
                                    :label="'Replacement Window'"
                                    v-model="form.replacementWindow"
                                    type="text"
                                />

                                <InputLabel
                                    forr="numberOfReplacement"
                                    :label="'Number of Replacement'"
                                    v-model="form.numberOfReplacement"
                                    type="text"
                                />
                            </template>

                            <div>
                                <label>Profile Complete</label>
                                <select class="form-control" v-model="form.is_profile_completed">
                                    <option :value="false">False</option>
                                    <option :value="true">True</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label>Profile Verified</label>
                                <select class="form-control" v-model="form.is_profile_verified">
                                    <option :value="false">False</option>
                                    <option :value="true">True</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <Button label="Update" type="submit" />
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style>
    .dropify-wrapper .dropify-preview .dropify-render img {
        width: 100% !important;
        height: auto !important;
        object-fit: contain;
    }

    .dropify-wrapper .dropify-message p {
        font-size: 16px;
        text-align: center;
    }
</style>