<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import 'dropify';
import 'dropify/dist/css/dropify.min.css';
import $ from 'jquery';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Create Specialist', href: '/specialist/create' },
];

const form = useForm({

    type: 'house-manager',
    name: '',
    email: '',
    password: '',
    role: 'specialist',
    subRole: 'house-manager',

    education: '',
    experience: '',
    location: '',
    preferredRole: '',

    languages: [] as string[],
    preferred: '',

    number: '',
    number_two: '',

    salaryRange: '',

    isMother: false,
    ageOfKids: [] as string[],
    isHandelingPet: false,

    firstAidCertificate: null as File | null,
    goodConductCertificate: null as File | null,
    drivingLicense: null as File | null,
    profilePhoto: null as File | null,
    idCopy: null as File | null,
});

const submit = () => {
    form.post('/specialist/store', {
        forceFormData: true,
    });
};

const languageOptions = ['English', 'Swahili', 'French', 'German', 'Arabic', 'Chinese', 'Other'];
const ageOptions = ['0-3 years', '4-10 years', '11+ years'];

const initDropify = (id: string) => {
    $(`#${id}`).dropify({
        height: 120,
        messages: {
            default: 'Drag and drop a file here or click',
            replace: 'Drag and drop or click to replace',
            remove: 'Remove',
            error: 'Ooops, something wrong happened.',
        },
    });
};

onMounted(() => {
    ['firstAidCertificate', 'goodConductCertificate', 'drivingLicense', 'profilePhoto', 'idCopy']
        .forEach(initDropify);
});
</script>


<template>
    <Head title="Create House Manager" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create House Manager</h1>
                <LinkButton :label="'Back'" :url="'/all-specialist'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                    <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                            <div>
                                <h1 class="text-sm font-medium">Role</h1>

                                <select
                                    class="form-control"
                                    name="subRole"
                                    id="subRole"
                                    v-model="form.subRole"
                                >
                                    <option value="house-manager">House Manager</option>
                                </select>

                                <span
                                    class="text-red-500 text-sm"
                                    v-if="form.errors.subRole"
                                >
                                    {{ form.errors.subRole }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <InputLabel forr="number" :label="'Phone Number'" v-model="form.number" type="text" :placeholder="'Enter Phone Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="name" :label="'Full Name (As per ID)'" v-model="form.name" type="text" :placeholder="'Enter Full Name'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="email" :label="'Email'" v-model="form.email" type="text" :placeholder="'Enter Email'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="password" :label="'Password'" v-model="form.password" type="password" :placeholder="'Enter Password'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</span>
                                </div>

                                <div class="">
                                    <h1 class="text-sm font-medium">Education Level</h1>

                                    <select
                                        class="form-control"
                                        name="education"
                                        id="education"
                                        v-model="form.education"
                                    >
                                        <option value="">Select Education Level</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                        <option value="College">College</option>
                                        <option value="University">University</option>

                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.education"
                                    >
                                        {{ form.errors.education }}
                                    </span>
                                </div>

                                <div class="">
                                    <h1 class="text-sm font-medium">Experience (Years)</h1>

                                    <select
                                        class="form-control"
                                        name="experience"
                                        id="experience"
                                        v-model="form.experience"
                                    >
                                        <option value="">Select Experience</option>
                                        <option value="1 year">1 year</option>
                                        <option value="2 years">2 years</option>
                                        <option value="3 years">3 years</option>
                                        <option value="4 years">4 years</option>
                                        <option value="5 years">5 years</option>
                                        <option value="More than 5 years">More than 5 years</option>

                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.education"
                                    >
                                        {{ form.errors.education }}
                                    </span>
                                </div>

                                <div class="">
                                    <h1 class="text-sm font-medium">Salary Range (KSh)</h1>

                                    <select
                                        class="form-control"
                                        name="salaryRange"
                                        id="salaryRange"
                                        v-model="form.salaryRange"
                                    >
                                        <option value="">Select Salary Range</option>
                                        <option value="200 - 400">200 - 400</option>
                                        <option value="400 - 600">400 - 600</option>
                                        <option value="600 - 800">600 - 800</option>
                                        <option value="800 - 1000">800 - 1000</option>
                                        <option value="More than 1000">More than 1000</option>

                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.salaryRange"
                                    >
                                        {{ form.errors.salaryRange }}
                                    </span>
                                </div>
                                <div>
                                    <InputLabel forr="number_two" :label="'Alternative Number'" v-model="form.number_two" type="text" :placeholder="'Enter Alternative Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.number_two">{{ form.errors.number_two }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="location" :label="'Location'" v-model="form.location" type="text" :placeholder="'Location'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.location">{{ form.errors.location }}</span>
                                </div>
                                <div class="space-y-3">
                                    <p class="font-medium text-gray-700">Service Offered</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="'Live In'" v-model="form.preferred" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Live In</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="'DayBurg'" v-model="form.preferred" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">DayBurg</span>
                                        </label>
                                    </div>
                                </div>

                            </div>


                            <div class="mb-10">
                                <label class="text-lg font-semibold text-slate-700 mb-4 block">Languages</label>
                                <div class="flex flex-wrap gap-x-6 gap-y-3">
                                    <div v-for="lang in languageOptions" :key="lang" class="flex items-center space-x-2">
                                        <input
                                            type="checkbox"
                                            :id="lang"
                                            :value="lang"
                                            v-model="form.languages"
                                            class="w-5 h-5 rounded border-gray-300 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]"
                                        />
                                        <label :for="lang" class="text-gray-600 font-medium cursor-pointer">{{ lang }}</label>
                                    </div>
                                </div>
                            </div>


                           <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <p class="font-medium text-gray-700">Are you a mother?</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.isMother" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Yes</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.isMother" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">No</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <p class="font-medium text-gray-700">Are you okay handling pets?</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.isHandelingPet" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Yes</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.isHandelingPet" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">No</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <p class="font-medium text-gray-700">What age of kids do you prefer working with?</p>
                                    <div class="flex flex-wrap gap-4">
                                        <label v-for="age in ageOptions" :key="age" class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox" :value="age" v-model="form.ageOfKids" class="w-5 h-5 rounded border-gray-300 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">{{ age }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <p class="font-medium text-gray-700">Preferred Role</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" value="Nanny" v-model="form.preferredRole" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Nanny</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" value="Housekeeper" v-model="form.preferredRole" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Housekeeper</span>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel forr="firstAidCertificate"  :label="'First Aid Certificate'" id="firstAidCertificate" @input="form.firstAidCertificate = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.firstAidCertificate">{{ form.errors.firstAidCertificate }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="goodConductCertificate"  :label="'Good Conduct Certificate'" id="goodConductCertificate" @input="form.goodConductCertificate = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.goodConductCertificate">{{ form.errors.goodConductCertificate }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel forr="drivingLicense"  :label="'Driving License'" id="drivingLicense" @input="form.drivingLicense = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.drivingLicense">{{ form.errors.drivingLicense }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="profilePhoto"  :label="'Profile Photo'" id="profilePhoto" @input="form.profilePhoto = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.profilePhoto">{{ form.errors.profilePhoto }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="idCopy"  :label="'ID Copy'" id="idCopy" @input="form.idCopy = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.idCopy">{{ form.errors.idCopy }}</span>
                                </div>

                            </div>

                        </div>
                    </div>

                    <Button class="mt-10" :label="`Create Specialist`" :type="`submit`" :disabled="form.processing" />
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
