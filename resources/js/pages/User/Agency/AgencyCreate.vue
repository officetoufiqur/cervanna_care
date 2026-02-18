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
        title: 'Add Agency and Care Institution',
        href: '/agency',
    },
];




const form = useForm({

    companyName: '',
    number: '',
    email: '',
    password: '',
    kraPin: '',
    companyRegistrationNumber: '',
    businessLocation: '',
    alternative_number: '',

    registrationDocument: '',

    agency_services: [],
    placementFee: '',
    replacementWindow: '',
    numberOfReplacement: '',
    role: '',

});


const submit = () => {
    form.post('/agency/store');
}

const agencyServices = ['Cooking', 'House Keeping', 'First Aid', 'Childcare', 'Communication','None'];

onMounted(() => {
    $('#registrationDocument').dropify({
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

    <Head title="Agency & Institution Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Agency & Institution Create</h1>
                <LinkButton :label="'Back'" :url="'/all-agency'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5 mb-8">
                        <div class="space-y-4">
                                 <div class="mt-5">
                                    <h1 class="text-sm font-bold mb-2">Role</h1>

                                    <select
                                        class="form-control"
                                        name="role"
                                        id="role"
                                        v-model="form.role"
                                    >
                                        <option :value="''" selected>Select Role</option>
                                        <option :value="'agency'">Agency</option>
                                        <option :value="'care_institutions'">Care Institution</option>
                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.role"
                                    >
                                        {{ form.errors.role }}
                                    </span>
                                </div>

                                <div>
                                    <InputLabel forr="companyName" :label="'Company Name'" v-model="form.companyName" type="text"
                                        :placeholder="'Company Name'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.companyName">{{ form.errors.companyName }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="number" :label="'Number'" v-model="form.number" type="number"
                                        :placeholder="'Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="email" :label="'Email'" v-model="form.email" type="email"
                                        :placeholder="'Email'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="password" :label="'Password'" v-model="form.password" type="password"
                                        :placeholder="'Password'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="kraPin" :label="'KRA PIN'" v-model="form.kraPin" type="text"
                                        :placeholder="'KRA PIN'"/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.kraPin">{{ form.errors.kraPin }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="companyRegistrationNumber" :label="'Company Registration Number'" v-model="form.companyRegistrationNumber" type="text"
                                        :placeholder="'Company Registration Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.companyRegistrationNumber">{{ form.errors.companyRegistrationNumber }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="alternative_number" :label="'Alternative Number'" v-model="form.alternative_number" type="text"
                                        :placeholder="'Alternative Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.alternative_number">{{ form.errors.alternative_number }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="businessLocation" :label="'Business Location'" v-model="form.businessLocation" type="text"
                                        :placeholder="'Business Location'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.businessLocation">{{ form.errors.businessLocation }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="registrationDocument" id="registrationDocument" :label="'Registration Document'" @input="form.registrationDocument = $event.target.files[0]" type="file"
                                        :placeholder="'Enter image URL'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.registrationDocument">{{ form.errors.registrationDocument }}</span>
                                </div>

                                <template v-if="form.role == 'agency'">

                                    <div class="mb-6">
                                        <label class="text-lg font-medium text-slate-700 mb-2 block">Agency Services</label>
                                        <div class="flex flex-wrap gap-x-6 gap-y-3">
                                            <div v-for="item in agencyServices" :key="item" class="flex items-center space-x-2">
                                                <input
                                                    type="checkbox"
                                                    :id="item"
                                                    :value="item"
                                                    v-model="form.agency_services"
                                                    class="w-5 h-5 rounded border-gray-300 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]"
                                                />
                                                <label :for="item" class="text-gray-600 font-medium cursor-pointer">{{ item }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <InputLabel forr="placementFee" :label="'Placement Fee'" v-model="form.placementFee" type="number"
                                            :placeholder="'Placement Fee'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.placementFee">{{ form.errors.placementFee }}</span>
                                    </div>

                                    <div>
                                        <InputLabel forr="replacementWindow" :label="'Replacement Window'" v-model="form.replacementWindow" type="number"
                                            :placeholder="'Replacement Window'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.replacementWindow">{{ form.errors.replacementWindow }}</span>
                                    </div>

                                    <div>
                                        <InputLabel forr="numberOfReplacement" :label="'Number of Replacement'" v-model="form.numberOfReplacement" type="number"
                                            :placeholder="'Number of Replacement'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.numberOfReplacement">{{ form.errors.numberOfReplacement }}</span>
                                    </div>

                                </template>

                        </div>
                    </div>

                    <Button :label="`Create`" :type="`submit`" />
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




