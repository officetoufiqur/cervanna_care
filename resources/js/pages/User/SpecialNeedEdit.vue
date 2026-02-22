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
import { nextTick, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Specialist Need Caregivers',
        href: '/all-specialist',
    },
];

const props = defineProps<{
    specialist: Specialist;
}>()

interface Specialist {
    id: number,
    name: string,
    role: string,
    subRole: string,
    location: string,
    age: string,
    gender: string,
    preferredRole: string,
    languages: string[];
    canDrive: string,
    bio: string,
    education: string,
    preferred: string,
    number_two: string,

    hospitalBasedCare: string,
    hospitalBasedYearsOfExperience: string,
    hospitalBasedReferenceContact: string,

    homeBasedCare: string,
    homeBasedYearsOfExperience: string,
    homeBasedReferenceContact: string,
    idCopy: string,
    profilePhoto: string,
    goodConductCertificate: string,
    drivingLicense: string,
    referenceLetter: string,
    is_profile_completed: boolean;
    is_profile_verified: boolean;
    created_at: string;

    special_need: {
        educationCertificate: string,
        experience: string,
        isRegisterPCK: string,
        registrationNumber: string,
        practiceLicense: string,
        serviceFee: string,
        serviceFeeDay: string,
        serviceFeeMonth: string,
    }

}




const form = useForm({

    name: props.specialist.name,
    role: props.specialist.role,
    subRole: props.specialist.subRole,
    location: props.specialist.location,
    age: props.specialist.age,
    gender: props.specialist.gender,
    preferredRole: props.specialist.preferredRole,
    languages: props.specialist.languages || [],
    canDrive: props.specialist.canDrive,
    bio: props.specialist.bio,
    education: props.specialist.education,
    preferred: props.specialist.preferred,
    number_two: props.specialist.number_two,
    hospitalBasedCare: props.specialist.hospitalBasedCare,
    hospitalBasedYearsOfExperience: props.specialist.hospitalBasedYearsOfExperience,
    hospitalBasedReferenceContact: props.specialist.hospitalBasedReferenceContact,

    homeBasedCare: props.specialist.homeBasedCare,
    homeBasedYearsOfExperience: props.specialist.homeBasedYearsOfExperience,
    homeBasedReferenceContact: props.specialist.homeBasedReferenceContact,

    idCopy: props.specialist.idCopy,
    profilePhoto: props.specialist.profilePhoto,
    goodConductCertificate: props.specialist.goodConductCertificate,
    drivingLicense: props.specialist.drivingLicense,
    referenceLetter: props.specialist.referenceLetter,

    is_profile_completed: props.specialist.is_profile_completed,
    is_profile_verified: props.specialist.is_profile_verified,
    created_at: props.specialist.created_at,

    educationCertificate: props.specialist.special_need.educationCertificate,
    experience: props.specialist.special_need.experience,
    isRegisterPCK: props.specialist.special_need.isRegisterPCK,
    registrationNumber: props.specialist.special_need.registrationNumber,
    practiceLicense: props.specialist.special_need.practiceLicense,
    serviceFee: props.specialist.special_need.serviceFee,
    serviceFeeDay: props.specialist.special_need.serviceFeeDay,
    serviceFeeMonth: props.specialist.special_need.serviceFeeMonth,


});


const handleFileChange = (
    e: Event,
    field: keyof typeof form
) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files.length > 0) {
        (form as Record<string, any>)[field] = target.files[0];
    }
};



const submit = () => {
    form.post('/specialist-need/update/' + props.specialist.id);
}


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

    <Head title="Specialist Need Caregivers Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Specialist Need Caregivers Update</h1>
                <LinkButton :label="'Back'" :url="'/all-specialist'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="grid grid-cols-2 gap-3">

                        <!-- Basic Info -->
                        <InputLabel forr="name" label="Name" v-model="form.name" type="text" />
                        <InputLabel forr="location" label="Location" v-model="form.location" type="text" />
                        <InputLabel forr="age" label="Age" v-model="form.age" type="number" />

                        <div>
                            <label>Gender</label>
                            <select v-model="form.gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>


                        <!-- Array Fields -->
                        <div>
                            <label class="block font-medium mb-2">Languages</label>

                            <div class="flex flex-wrap gap-4">

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="English"
                                        v-model="form.languages" />
                                    English
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="Swahili"
                                        v-model="form.languages" />
                                    Swahili
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="French"
                                        v-model="form.languages" />
                                    French
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="German"
                                        v-model="form.languages" />
                                    German
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="Arabic"
                                        v-model="form.languages" />
                                    Arabic
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="Chinese"
                                        v-model="form.languages" />
                                    Chinese
                                </label>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" class="accent-[#72275B]" value="Other"
                                        v-model="form.languages" />
                                    Other
                                </label>

                            </div>

                            <span class="text-red-500 text-sm" v-if="form.errors.languages">
                                {{ form.errors.languages }}
                            </span>
                        </div>

                        <!-- Boolean -->
                        <div>
                            <label>Can Drive</label>
                            <select v-model="form.canDrive" class="form-control">
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Education</label>
                            <select v-model="form.education" class="w-full border rounded px-3 py-2">
                                <option value="">Select education</option>

                                <option value="Degree In Special Needs Education (SNE)">
                                    Degree In Special Needs Education (SNE)
                                </option>

                                <option value="Degree In Early Childhood Development (ECD) with SNE units">
                                    Degree In Early Childhood Development (ECD) with SNE units
                                </option>

                                <option value="Diploma In Special Needs Education (SNE)">
                                    Diploma In Special Needs Education (SNE)
                                </option>

                                <option value="Diploma In Early Childhood Development (ECD) with SNE units">
                                    Diploma In Early Childhood Development (ECD) with SNE units
                                </option>

                            </select>
                        </div>

                        <!-- Hospital Care -->
                        <div>
                            <label>Hospital Based Care</label>
                            <select v-model="form.hospitalBasedCare" class="form-control">
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <InputLabel v-if="form.hospitalBasedCare" forr="hospitalBasedYearsOfExperience"
                            label="Hospital Experience Years" v-model="form.hospitalBasedYearsOfExperience"
                            type="number" />
                        <InputLabel v-if="form.hospitalBasedCare" forr="hospitalBasedReferenceContact"
                            label="Hospital Reference Contact" v-model="form.hospitalBasedReferenceContact"
                            type="number" />

                        <!-- Home Care -->
                        <div>
                            <label>Home Based Care</label>
                            <select v-model="form.homeBasedCare" class="form-control">
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <InputLabel v-if="form.homeBasedCare" forr="homeBasedYearsOfExperience"
                            label="Home Experience Years" v-model="form.homeBasedYearsOfExperience" type="number" />
                        <InputLabel v-if="form.homeBasedCare" forr="homeBasedReferenceContact"
                            label="Home Reference Contact" v-model="form.homeBasedReferenceContact" type="number" />

                        <div>
                            <label class="block font-medium mb-2">Preferred</label>
                            <select v-model="form.preferred" class="w-full border rounded px-3 py-2">
                                <option value="">Select specialization</option>
                                <option value="Autism Spectrum Disorder (ASD)">
                                    Autism Spectrum Disorder (ASD)
                                </option>
                                <option value="Speech therapy">
                                    Speech therapy
                                </option>
                                <option value="ADHD (Attention Deficit Hyperactivity Disorder)">
                                    ADHD (Attention Deficit Hyperactivity Disorder)
                                </option>
                                <option value="Cerebral palsy">
                                    Cerebral palsy
                                </option>
                                <option value="Down syndrome">
                                    Down syndrome
                                </option>
                                <option value="Blindness">
                                    Blindness
                                </option>
                                <option value="Dementia & Alzheimer">
                                    Dementia & Alzheimer
                                </option>
                            </select>

                            <span class="text-red-500 text-sm" v-if="form.errors.preferred">
                                {{ form.errors.preferred }}
                            </span>
                        </div>

                        <InputLabel forr="serviceFeeDay" label="Service Fee Per Day" v-model="form.serviceFeeDay"
                            type="text" />
                        <InputLabel forr="serviceFeeMonth" label="Service Fee Per Month" v-model="form.serviceFeeMonth"
                            type="text" />


                        <!-- File Uploads -->
                        <div>
                            <label>ID Copy</label>
                            <input type="file" class="dropify" :data-default-file="form.idCopy"
                                @change="(e) => handleFileChange(e, 'idCopy')" />
                        </div>

                        <div>
                            <label>Profile Photo</label>
                            <input type="file" class="dropify" :data-default-file="form.profilePhoto"
                                @change="(e) => handleFileChange(e, 'profilePhoto')" />
                        </div>

                        <div>
                            <label>Driving License</label>
                            <input type="file" class="dropify" :data-default-file="form.drivingLicense"
                                @change="(e) => handleFileChange(e, 'drivingLicense')" />
                        </div>

                        <div>
                            <label>Good Conduct Certificate</label>
                            <input type="file" class="dropify" :data-default-file="form.goodConductCertificate"
                                @change="(e) => handleFileChange(e, 'goodConductCertificate')" />
                        </div>

                        <div>
                            <label>Reference Letter</label>
                            <input type="file" class="dropify" :data-default-file="form.referenceLetter"
                                @change="(e) => handleFileChange(e, 'referenceLetter')" />
                        </div>

                        <div>
                            <label>Education Certificate</label>
                            <input type="file" class="dropify" :data-default-file="form.educationCertificate"
                                @change="(e) => handleFileChange(e, 'educationCertificate')" />
                        </div>

                    </div>

                    <div class="mt-8">
                        <Button label="Update" type="submit" />
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