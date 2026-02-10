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
import { onMounted, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Create Specialist', href: '/specialist/create' },
];

const form = useForm({

    email: '',
    password: '',
    role: 'specialist',
    subRole: 'nurse',
    name : '',
    number: '',
    location : '',
    age : '',
    experience : '',
    gender : '',
    preferredRole : '',
    languages: [] as string[],
    canDrive : '',
    bio : '',
    education : '',
    preferred : [] as string[],

    hospitalBasedCare : '',
    hospitalBasedYearsOfExperience : '',
    hospitalBasedReferenceContact : '',

    homeBasedCare : '',
    homeBasedYearsOfExperience : '',
    homeBasedReferenceContact : '',

    number_two : '',
    isNursingInKenya : '',
    registrationNumber : '',
    skills : '',
    mobilityYears : '',
    bathingYears : '',
    feedingYears : '',
    serviceFeeDay : '',
    serviceFeeMonth : '',

    idCopy : null as File | null,
    profilePhoto : null as File | null,
    goodConductCertificate : null as File | null,
    drivingLicense : null as File | null,
    referenceLetter : null as File | null,
    educationCertificate : null as File | null,
    practiceLicense : null as File | null,

});

const submit = () => {
    form.post('/specialist/store', {
        forceFormData: true,
    });
};

const props = defineProps({
    skills: Array,
});

const languageOptions = ['English', 'Swahili', 'French', 'German', 'Arabic', 'Chinese', 'Other'];
const preferred = ['Pre and post pregnancy care', 'Post surgery cage', 'Palliative care', 'Elderly care'];

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

watch(
    () => form.isNursingInKenya,
    (value) => {
        if (value === 'no') {
            const el = $('#practiceLicense');
            if (el.data('dropify')) {
                el.dropify('destroy');
            }
        }
    }
);


onMounted(() => {
    ['profilePhoto', 'idCopy', 'goodConductCertificate', 'drivingLicense', 'referenceLetter', 'educationCertificate']
        .forEach(initDropify);
});

</script>


<template>
    <Head title="Create Nurse" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create New Nurse</h1>
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
                                    <option value="">Select Role</option>
                                    <option value="house-manager">House Manager</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="physiotherapist">Physiotherapist</option>
                                    <option value="nurse-aide-or-assistant">Nurse Aide or Assistant</option>
                                    <option value="special-need-caregivers">Special Need Caregivers</option>
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


                                <div>
                                 
                                    <InputLabel forr="age" :label="'Age'" v-model="form.age" type="number" :placeholder="'Enter Age'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.age">{{ form.errors.age }}</span>

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
                                    <h1 class="text-sm font-medium">Education Level</h1>

                                    <select
                                        class="form-control"
                                        name="education"
                                        id="education"
                                        v-model="form.education"
                                    >
                                        <option value="">Select Education Level</option>
                                        <option value="Diploma In Nursing">Diploma In Nursing</option>
                                        <option value="Degree In Nursing">Degree In Nursing</option>

                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.education"
                                    >
                                        {{ form.errors.education }}
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
                                <div>
                                    <p class="font-medium text-gray-700">Gender</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.gender" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Male</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.gender" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Female</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <p class="font-medium text-gray-700">Can you drive?</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.canDrive" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Yes</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.canDrive" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">No</span>
                                        </label>
                                    </div>
                                </div>


                                <div>
                                    <p class="font-medium text-gray-700">Preferred Role</p>
                                    <div class="flex items-center space-x-6">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" value="Medical Nurse" v-model="form.preferredRole" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Medical Nurse</span>
                                        </label>
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" value="Nurse Aide" v-model="form.preferredRole" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                            <span class="text-gray-600">Nurse Aide</span>
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-6">
                                <label class="text-lg font-medium text-slate-700 mb-2 block">Bio</label>
                                <div class="flex flex-wrap gap-x-6 gap-y-3">
                                    <textarea v-model="form.bio" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#72275B] focus:border-[#72275B]" placeholder="Write something about yourself"></textarea>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-lg font-medium text-slate-700 mb-2 block">Languages</label>
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

                            <div class="space-y-3">
                                <p class="font-medium text-gray-700">Are you registered with the Nursing Council of Kenya?</p>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="true" v-model="form.isNursingInKenya" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">Yes</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="false" v-model="form.isNursingInKenya" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">No</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div v-if="form.isNursingInKenya">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel forr="registrationNumber" :label="'Registration Number'" v-model="form.registrationNumber" type="text" :placeholder="'Enter Registration Number'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.registrationNumber">{{ form.errors.registrationNumber }}</span>
                                    </div>
                                    <div>
                                        <InputLabel forr="practiceLicense"  :label="'Practice License'" id="practiceLicense" @input="form.practiceLicense = $event.target.files[0]" type="file" />
                                        <span class="text-red-500 text-sm" v-if="form.isNursingInKenya === 'yes'">{{ form.errors.practiceLicense }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="space-y-3">
                                <p class="font-medium text-gray-700">Hospital Based Care</p>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="true" v-model="form.hospitalBasedCare" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">Yes</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="false" v-model="form.hospitalBasedCare" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">No</span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="form.hospitalBasedCare">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel forr="hospitalBasedYearsOfExperience" :label="'Years of experience'" v-model="form.hospitalBasedYearsOfExperience" type="number" :placeholder="'Enter Years of experience'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.hospitalBasedYearsOfExperience">{{ form.errors.hospitalBasedYearsOfExperience }}</span>
                                    </div>
                                    <div>
                                        <InputLabel forr="hospitalBasedReferenceContact"  :label="'Reference Contact'" id="hospitalBasedReferenceContact" type="text" :placeholder="'Enter Hospital Ref'"/>
                                        <span class="text-red-500 text-sm" v-if="form.errors.hospitalBasedReferenceContact">{{ form.errors.hospitalBasedReferenceContact }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="space-y-3">
                                <p class="font-medium text-gray-700">Home Based Care</p>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="true" v-model="form.homeBasedCare" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">Yes</span>
                                    </label>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="radio" :value="false" v-model="form.homeBasedCare" class="w-5 h-5 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]" />
                                        <span class="text-gray-600">No</span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="form.homeBasedCare">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel forr="homeBasedYearsOfExperience" :label="'Years of experience'" v-model="form.homeBasedYearsOfExperience" type="number" :placeholder="'Enter Years of experience'" />
                                        <span class="text-red-500 text-sm" v-if="form.errors.homeBasedYearsOfExperience">{{ form.errors.homeBasedYearsOfExperience }}</span>
                                    </div>
                                    <div>
                                        <InputLabel forr="homeBasedReferenceContact"  :label="'Reference Contact'" id="homeBasedReferenceContact" type="text" :placeholder="'Enter Hospital Ref'"/>
                                        <span class="text-red-500 text-sm" v-if="form.errors.homeBasedReferenceContact">{{ form.errors.homeBasedReferenceContact }}</span>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="text-lg font-medium text-slate-700 mb-2 block">What are your preferred areas of intervention</label>
                                <div class="flex flex-wrap gap-x-6 gap-y-3">
                                    <div v-for="item in preferred" :key="item" class="flex items-center space-x-2">
                                        <input
                                            type="checkbox"
                                            :id="item"
                                            :value="item"
                                            v-model="form.preferred"
                                            class="w-5 h-5 rounded border-gray-300 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]"
                                        />
                                        <label :for="item" class="text-gray-600 font-medium cursor-pointer">{{ item }}</label>
                                    </div>
                                </div>
                             </div>

                            <div class="mb-6">
                                <label class="text-lg font-medium text-slate-700 mb-2 block">What are your preferred areas of intervention</label>
                                <div class="flex flex-wrap gap-x-6 gap-y-3">
                                    <div v-for="skill in skills" :key="skill.id" class="flex items-center space-x-2">
                                        <input
                                            type="checkbox"
                                            :id="skill.id"
                                            :value="skill.id"
                                            v-model="form.skills"
                                            class="w-5 h-5 rounded border-gray-300 text-[#72275B] focus:ring-[#72275B] accent-[#72275B]"
                                        />
                                        <label :for="skill.name" class="text-gray-600 font-medium cursor-pointer">{{ skill.name }}</label>
                                    </div>
                                </div>
                             </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <InputLabel forr="profilePhoto"  :label="'Profile Photo'" id="profilePhoto" @input="form.profilePhoto = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.profilePhoto">{{ form.errors.profilePhoto }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="idCopy"  :label="'ID Copy'" id="idCopy" @input="form.idCopy = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.idCopy">{{ form.errors.idCopy }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="drivingLicense"  :label="'Driving License'" id="drivingLicense" @input="form.drivingLicense = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.drivingLicense">{{ form.errors.drivingLicense }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="referenceLetter"  :label="'Reference Letter'" id="referenceLetter" @input="form.referenceLetter = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.referenceLetter">{{ form.errors.referenceLetter }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="educationCertificate"  :label="'Education Certificate'" id="educationCertificate" @input="form.educationCertificate = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.educationCertificate">{{ form.errors.educationCertificate }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="goodConductCertificate"  :label="'Good Conduct Certificate'" id="goodConductCertificate" @input="form.goodConductCertificate = $event.target.files[0]" type="file" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.goodConductCertificate">{{ form.errors.goodConductCertificate }}</span>
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
