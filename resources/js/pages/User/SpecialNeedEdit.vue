<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

import 'dropify';
import 'dropify/dist/css/dropify.min.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Specialist',
        href: '/specialist',
    },          
];

interface specialist {
    name : string,
    location : string,
    age : string,
    role : string,
    subRole : string,
    number_two : string,
    experience : string,
    gender : string,
    languages : string,
    canDrive : string,
    bio : string,
    education : string,
    hospitalBasedCare : string,
    hospitalBasedYearsOfExperience : string,
    hospitalBasedReferenceContact : string,
    homeBasedCare : string,
    homeBasedYearsOfExperience : string,
    homeBasedReferenceContact : string,
    preferred : string,

    special_need : {
        educationCertificate : string,
        isRegisterPCK : string,
        registrationNumber : string,
        practiceLicense : string,
        serviceFee : string,
        serviceFeeDay : string,
        serviceFeeMonth : string,
    }

    idCopy : string,
    profilePhoto : string,
    goodConductCertificate : string,
    drivingLicense : string,
    referenceLetter : string,
    educationCertificate : string,
    practiceLicense : string,

    is_profile_completed : string,
    is_profile_verified : string,
    created_at : string,



}


const props = defineProps<{
    specialist: specialist;
}>()

const form = useForm({

    name: props.specialist.name,
    role: props.specialist.role,
    subRole: props.specialist.subRole,
    location: props.specialist.location,
    age: props.specialist.age,
    gender: props.specialist.gender,
    languages: props.specialist.languages, 
    canDrive: props.specialist.canDrive, 
    experience: props.specialist.experience,
    bio: props.specialist.bio, 
    education: props.specialist.education, 
    preferred: props.specialist.preferred, 
    hospitalBasedCare: props.specialist.hospitalBasedCare,
    hospitalBasedYearsOfExperience: props.specialist.hospitalBasedYearsOfExperience,
    hospitalBasedReferenceContact: props.specialist.hospitalBasedReferenceContact,

    homeBasedCare: props.specialist.homeBasedCare,
    homeBasedYearsOfExperience: props.specialist.homeBasedYearsOfExperience,
    homeBasedReferenceContact: props.specialist.homeBasedReferenceContact,

    // idCopy: props.specialist.idCopy,
    // profilePhoto: props.specialist.profilePhoto,
    // goodConductCertificate: props.specialist.goodConductCertificate,
    // drivingLicense: props.specialist.drivingLicense,
    // referenceLetter: props.specialist.referenceLetter, 

    is_profile_completed: props.specialist.is_profile_completed,
    is_profile_verified: props.specialist.is_profile_verified,
    created_at: props.specialist.created_at,

    // educationCertificate: props.specialist.specialNeed.educationCertificate,   
    isRegisterPCK: props.specialist.special_need.isRegisterPCK,
    registrationNumber: props.specialist.special_need.registrationNumber,
    practiceLicense: props.specialist.special_need.practiceLicense,
    serviceFee: props.specialist.special_need.serviceFee,
    serviceFeeDay: props.specialist.special_need.serviceFeeDay,
    serviceFeeMonth: props.specialist.special_need.serviceFeeMonth,

});
 

const submit = () => {
    form.put('/specialist/update/' + props.specialist.id);
}


</script>

<template>

    <Head title="Specialist Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Specialist Update</h1>
                <LinkButton :label="'Back'" :url="'/all-specialist'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                                <div>
                                    <InputLabel forr="name" :label="'Name'" v-model="form.name" type="text"
                                        :placeholder="'Name'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="role" :label="'Role'" v-model="form.role" type="text"
                                        :placeholder="'Role'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.role">{{ form.errors.role }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="subRole" :label="'Sub Role'" v-model="form.subRole" type="text"
                                        :placeholder="'Sub Role'" readonly />
                                    <span class="text-red-500 text-sm" v-if="form.errors.subRole">{{ form.errors.subRole }}</span>
                                </div>

                                <div>   
                                    <InputLabel forr="location" :label="'Location'" v-model="form.location" type="text"
                                        :placeholder="'Location'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.location">{{ form.errors.location }}</span>
                                </div>
                                <div>   
                                    <InputLabel forr="age" :label="'Age'" v-model="form.age" type="text"
                                        :placeholder="'Age'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.age">{{ form.errors.age }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="gender" :label="'gender'" v-model="form.gender" type="text"
                                        :placeholder="'gender'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.gender">{{ form.errors.gender }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="languages" :label="'languages'" v-model="form.languages" type="text"
                                        :placeholder="'languages'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.languages">{{ form.errors.languages }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="canDrive" :label="'canDrive'" v-model="form.canDrive" type="text"
                                        :placeholder="'canDrive'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.canDrive">{{ form.errors.canDrive }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="bio" :label="'bio'" v-model="form.bio" type="text"
                                        :placeholder="'bio'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.bio">{{ form.errors.bio }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="education" :label="'education'" v-model="form.education" type="text"
                                        :placeholder="'education'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.education">{{ form.errors.education }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="experience" :label="'experience'" v-model="form.experience" type="text"
                                        :placeholder="'experience'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.experience">{{ form.errors.experience }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="preferred" :label="'preferred'" v-model="form.preferred" type="text"
                                        :placeholder="'preferred'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.preferred">{{ form.errors.preferred }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="hospitalBasedCare" :label="'hospitalBasedCare'" v-model="form.hospitalBasedCare" type="text"
                                        :placeholder="'hospitalBasedCare'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.hospitalBasedCare">{{ form.errors.hospitalBasedCare }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="hospitalBasedYearsOfExperience" :label="'hospitalBasedYearsOfExperience'" v-model="form.hospitalBasedYearsOfExperience" type="text"
                                        :placeholder="'hospitalBasedYearsOfExperience'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.hospitalBasedYearsOfExperience">{{ form.errors.hospitalBasedYearsOfExperience }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="hospitalBasedReferenceContact" :label="'hospitalBasedReferenceContact'" v-model="form.hospitalBasedReferenceContact" type="text"
                                        :placeholder="'hospitalBasedReferenceContact'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.hospitalBasedReferenceContact">{{ form.errors.hospitalBasedReferenceContact }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="homeBasedCare " :label="'homeBasedCare'" v-model="form.homeBasedCare" type="text"
                                        :placeholder="'homeBasedCare'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.homeBasedCare">{{ form.errors.homeBasedCare }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="homeBasedYearsOfExperience" :label="'homeBasedYearsOfExperience'" v-model="form.homeBasedYearsOfExperience" type="text"
                                        :placeholder="'homeBasedYearsOfExperience'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.homeBasedYearsOfExperience">{{ form.errors.homeBasedYearsOfExperience }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="homeBasedReferenceContact" :label="'homeBasedReferenceContact'" v-model="form.homeBasedReferenceContact" type="text"
                                        :placeholder="'homeBasedReferenceContact'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.homeBasedReferenceContact">{{ form.errors.homeBasedReferenceContact }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="isRegisterPCK" :label="'isRegisterPCK'" v-model="form.isRegisterPCK" type="text"
                                        :placeholder="'isRegisterPCK'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.isRegisterPCK">{{ form.errors.isRegisterPCK }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="registrationNumber" :label="'registrationNumber'" v-model="form.registrationNumber" type="text"
                                        :placeholder="'registrationNumber'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.registrationNumber">{{ form.errors.registrationNumber }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="practiceLicense" :label="'practiceLicense'" v-model="form.practiceLicense" type="text"
                                        :placeholder="'practiceLicense'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.practiceLicense">{{ form.errors.practiceLicense }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="serviceFee" :label="'serviceFee'" v-model="form.serviceFee" type="text"
                                        :placeholder="'serviceFee'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.serviceFee">{{ form.errors.serviceFee }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="serviceFeeDay" :label="'serviceFeeDay'" v-model="form.serviceFeeDay" type="text"
                                        :placeholder="'serviceFeeDay'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.serviceFeeDay">{{ form.errors.serviceFeeDay }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="serviceFeeMonth" :label="'serviceFeeMonth'" v-model="form.serviceFeeMonth" type="text"
                                        :placeholder="'serviceFeeMonth'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.serviceFeeMonth">{{ form.errors.serviceFeeMonth }}</span>
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