<script setup lang="ts">
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import 'dropify';
import 'dropify/dist/css/dropify.min.css';
import $ from 'jquery';
import { nextTick, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Add Institution Employee',
        href: '/institution-employee/create',
    },
];

const props = defineProps<{
    employee: any;
    institutions: {
        id: number;
        companyName: string;
    }[];
}>()


interface InstitutionEmployeeForm {
    care_institution_id: string;
    fullName: string;
    age: string;
    location: string;
    experience: string;
    gender: string;
    education: string;
    type: string;
    canDrive: string;
    preferredRole: string;
    languages: string[];
    educationCertificate: File | null;
    isNursingInKenya: string;
    practiceLicense: File | null;
    registrationNumber: string;
    hospitalBasedCare: string;
    hospitalBasedYearsOfExperience: string;
    hospitalBasedReferenceContact: string;
    homeBasedCare: string;
    homeBasedYearsOfExperience: string;
    homeBasedReferenceContact: string;
    mobilityYears: string;
    bathingYears: string;
    feedingYears: string;
    serviceFee: string;
    serviceFeeDay: string;
    serviceFeeMonth: string;
    bio: string;
    idCopy: File | null;
    profilePhoto: File | null;
    services: string[];
}


const form = useForm<InstitutionEmployeeForm>({
    care_institution_id: props.employee.care_institution_id || '',
    fullName: props.employee.fullName || '',
    age: props.employee.age || '',
    location: props.employee.location || '',
    experience: props.employee.experience || '',
    gender: props.employee.gender || '',
    education: props.employee.education || '',
    type: props.employee.type || '',
    canDrive: props.employee.canDrive || false,
    preferredRole: props.employee.preferredRole || '',
    languages: props.employee.languages || [],
    educationCertificate: null,
    isNursingInKenya: props.employee.isNursingInKenya || false,
    practiceLicense: null,
    registrationNumber: props.employee.registrationNumber || '',
    hospitalBasedCare: props.employee.hospitalBasedCare || false,
    hospitalBasedYearsOfExperience: props.employee.hospitalBasedYearsOfExperience || '',
    hospitalBasedReferenceContact: props.employee.hospitalBasedReferenceContact || '',
    homeBasedCare: props.employee.homeBasedCare || false,
    homeBasedYearsOfExperience: props.employee.homeBasedYearsOfExperience || '',
    homeBasedReferenceContact: props.employee.homeBasedReferenceContact || '',
    mobilityYears: props.employee.mobilityYears || '',
    bathingYears: props.employee.bathingYears || '',
    feedingYears: props.employee.feedingYears || '',
    serviceFee: props.employee.serviceFee || '',
    serviceFeeDay: props.employee.serviceFeeDay || '',
    serviceFeeMonth: props.employee.serviceFeeMonth || '',
    bio: props.employee.bio || '',
    idCopy: null,
    profilePhoto: null,
    services: props.employee.services || [],
});


const handleFileChange = (
    e: Event,
    field: keyof InstitutionEmployeeForm
) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form[field] = target.files[0] as any;
    }
};



const submit = () => {
    form.post('/institution-employee/update/' + props.employee.id, {
        onSuccess: () => {
            form.reset();
        },
    });
};

onMounted(async () => {
    await nextTick();

    $('.dropify').dropify({
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

    <Head title="Institution Employee Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create Institution Employee</h1>
                <LinkButton :label="'Back'" :url="'/institution-employees'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" enctype="multipart/form-data">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- Institution -->
                        <div>
                            <label class="block mb-1">Institution</label>
                            <select v-model="form.care_institution_id" class="w-full border rounded px-3 py-2">
                                <option value="">Select Institution</option>
                                <option v-for="institution in props.institutions" :key="institution.id"
                                    :value="institution.id">
                                    {{ institution.companyName }}
                                </option>
                            </select>
                        </div>

                        <InputLabel forr="fullName" label="Full Name" v-model="form.fullName" type="text"
                            :placeholder="'Enter Full Name'" />

                        <InputLabel forr="age" label="Age" v-model="form.age" type="number"
                            :placeholder="'Enter Age'" />

                        <InputLabel forr="location" label="Location" v-model="form.location" type="text"
                            :placeholder="'Enter Location'" />

                        <!-- Experience (Multiple) -->
                        <div>
                            <label class="block mb-1">Experience</label>
                            <select v-model="form.experience" class="w-full border rounded px-3 py-2">
                                <option value="">Select experience</option>
                                <option value="1 years">1 Year</option>
                                <option value="2 years">2 Years</option>
                                <option value="3 years">3 Years</option>
                                <option value="4 years">4 Years</option>
                                <option value="More than 5+ years">More than 5+ years</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block mb-1">Gender</label>
                            <select v-model="form.gender" class="w-full border rounded px-3 py-2">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <!-- Can Drive -->
                        <div>
                            <label class="block mb-1">Can Drive?</label>
                            <select v-model="form.canDrive" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Preferred Role</label>
                            <select v-model="form.preferredRole" class="w-full border rounded px-3 py-2">
                                <option value="">Select preferred role</option>
                                <option value="Medical Nurse">Medical Nurse</option>
                                <option value="Nurse Aide">Nurse Aide</option>
                            </select>
                        </div>

                        <!-- Education -->
                        <div>
                            <label class="block mb-1">Education</label>
                            <select v-model="form.education" class="w-full border rounded px-3 py-2">
                                <option value="">Select Education</option>
                                <option value="Diploma In Nursing">Diploma In Nursing</option>
                                <option value="Degree In Nursing">Degree In Nursing</option>
                            </select>
                        </div>

                        <!-- Nursing In Kenya -->
                        <div>
                            <label class="block mb-1">Is Nursing In Kenya?</label>
                            <select v-model="form.isNursingInKenya" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Hospital Based Care</label>
                            <select v-model="form.hospitalBasedCare" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Home Based Care</label>
                            <select v-model="form.homeBasedCare" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <InputLabel forr="mobilityYears" label="Mobility Years" v-model="form.mobilityYears"
                            type="number" :placeholder="'Enter Years'" />

                        <InputLabel forr="bathingYears" label="Bathing Years" v-model="form.bathingYears" type="number"
                            :placeholder="'Enter Years'" />

                        <InputLabel forr="feedingYears" label="Feeding Years" v-model="form.feedingYears" type="number"
                            :placeholder="'Enter Years'" />


                        <InputLabel forr="serviceFeeDay" label="Service Fee (Day)" v-model="form.serviceFeeDay"
                            type="number" :placeholder="'Enter Day Fee'" />

                        <InputLabel forr="serviceFeeMonth" label="Service Fee (Month)" v-model="form.serviceFeeMonth"
                            type="number" :placeholder="'Enter Month Fee'" />

                        <InputLabel forr="registrationNumber" label="Registration Number"
                            v-model="form.registrationNumber" type="text" :placeholder="'Enter Registration Number'" />


                        <InputLabel forr="hospitalBasedYearsOfExperience" label="Hospital Experience (Years)"
                            v-model="form.hospitalBasedYearsOfExperience" type="text" :placeholder="'Enter Years'" />

                        <InputLabel forr="hospitalBasedReferenceContact" label="Hospital Reference Contact"
                            v-model="form.hospitalBasedReferenceContact" type="text" :placeholder="'Enter Contact'" />

                        <InputLabel forr="homeBasedYearsOfExperience" label="Home Experience (Years)"
                            v-model="form.homeBasedYearsOfExperience" type="text" :placeholder="'Enter Years'" />

                        <InputLabel forr="homeBasedReferenceContact" label="Home Reference Contact"
                            v-model="form.homeBasedReferenceContact" type="text" :placeholder="'Enter Contact'" />

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Services -->
                        <div class="mt-6">
                            <label class="block mb-2 font-semibold">Services</label>
                            <div class="flex flex-col gap-3">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)"
                                        v-model="form.services" />
                                    <span>Basic Patient Care (bathing, dressing, feeding, and assisting with
                                        mobility)</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Vital Signs Monitoring (checking blood pressure, blood sugar, pulse, temperature, etc.)"
                                        v-model="form.services" />
                                    <span>Vital Signs Monitoring (checking blood pressure, blood sugar, pulse,
                                        temperature, etc.)</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Medical Assistance: Assisting nurses with wound care and administering medication (in some cases)"
                                        v-model="form.services" />
                                    <span>Medical Assistance: Assisting nurses with wound care and administering
                                        medication (in some cases)</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Compassion & Communication services" v-model="form.services" />
                                    <span>Compassion & Communication services</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Special needs children caregiving" v-model="form.services" />
                                    <span>Special needs children caregiving</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="Elderly caregiving"
                                        v-model="form.services" />
                                    <span>Elderly caregiving</span>
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]"
                                        value="Handling Medical Equipment (e.g., feeding tubes, catheter, oxygen tanks)"
                                        v-model="form.services" />
                                    <span>Handling Medical Equipment (e.g., feeding tubes, catheter, oxygen
                                        tanks)</span>
                                </label>

                            </div>
                        </div>
                        <!-- Languages -->
                        <div class="mt-5">
                            <label class="block mb-2 font-semibold">Languages</label>
                            <div class="flex flex-wrap gap-4">
                                <label><input type="checkbox" value="English" v-model="form.languages" />
                                    English</label>
                                <label><input type="checkbox" value="Swahili" v-model="form.languages" />
                                    Swahili</label>
                                <label><input type="checkbox" value="French" v-model="form.languages" /> French</label>
                                <label><input type="checkbox" value="German" v-model="form.languages" /> German</label>
                                <label><input type="checkbox" value="Arabic" v-model="form.languages" /> Arabic</label>
                                <label><input type="checkbox" value="Chinese" v-model="form.languages" />
                                    Chinese</label>
                                <label><input type="checkbox" value="Other" v-model="form.languages" /> Other</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mt-5">
                        <label class="block mb-1">Bio</label>
                        <textarea v-model="form.bio" class="w-full border rounded px-3 py-2" rows="4"
                        placeholder="Write short bio"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div>
                            <label class="block mb-1">Practice License</label>
                            <input type="file" class="dropify" :data-default-file="props.employee.practiceLicense"
                                @change="(e) => handleFileChange(e, 'practiceLicense')" />
                        </div>

                        <div>
                            <label class="block mb-1">Education Certificate</label>
                            <input type="file" class="dropify" :data-default-file="props.employee.educationCertificate"
                                @change="(e) => handleFileChange(e, 'educationCertificate')" />
                        </div>

                        <div>
                            <label class="block mb-1">ID Copy</label>
                            <input type="file" class="dropify" :data-default-file="props.employee.idCopy" @change="(e) => handleFileChange(e, 'idCopy')" />
                        </div>

                        <div>
                            <label class="block mb-1">Profile Photo</label>
                            <input type="file" class="dropify" :data-default-file="props.employee.profilePhoto" @change="(e) => handleFileChange(e, 'profilePhoto')" />
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="bg-[#72275B] text-white px-6 py-2 rounded cursor-pointer">
                            Update Employee
                        </button>
                    </div>

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
