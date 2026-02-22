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
        title: 'Edit House Manager',
        href: '/house-manager',
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
    house_manager: {
        experience?: string;
        experienceYear?: string;
        salaryRange?: string;
        isMother?: boolean;
        ageOfKids?: string;
        isHandelingPet?: boolean;
        preferBeingA?: string;
        firstAidCertificate?: string;
        goodConductCertificate: string;
    };

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
    drivingLicense: props.specialist.drivingLicense,
    referenceLetter: props.specialist.referenceLetter,

    is_profile_completed: props.specialist.is_profile_completed,
    is_profile_verified: props.specialist.is_profile_verified,
    created_at: props.specialist.created_at,

    experience: props.specialist.house_manager?.experience || '',
    isMother: props.specialist.house_manager?.isMother || false,
    ageOfKids: props.specialist.house_manager?.ageOfKids || '',
    salaryRange: props.specialist.house_manager?.salaryRange || '',
    isHandelingPet: props.specialist.house_manager?.isHandelingPet || false,
    preferBeingA: props.specialist.house_manager?.preferBeingA || '',
    firstAidCertificate: props.specialist.house_manager?.firstAidCertificate || '',
    goodConductCertificate: props.specialist.house_manager?.goodConductCertificate || '',


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
    form.post('/house-manager/update/' + props.specialist.id);
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

    <Head title="House Manager Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">House Manager Update</h1>
                <LinkButton :label="'Back'" :url="'/all-specialist'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="grid grid-cols-2 gap-3">

                        <!-- Basic Info -->
                        <InputLabel forr="name" label="Name" v-model="form.name" type="text" />
                        <InputLabel forr="age" label="Age" v-model="form.age" type="number" />
                        <div>
                            <label class="block mb-1">Education</label>
                            <select v-model="form.education" class="w-full border rounded px-3 py-2">
                                <option value="">Select education</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="College">College</option>
                                <option value="University">University</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Experience (Years)</label>
                            <select v-model="form.experience" class="w-full border rounded px-3 py-2">
                                <option value="">Select experience</option>
                                <option value="1 years">1 years</option>
                                <option value="2 years">2 years</option>
                                <option value="3 years">3 years</option>
                                <option value="4 years">4 years</option>
                                <option value="5+ years">5+ years</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Salary Range (KSH)</label>
                            <select v-model="form.salaryRange" class="w-full border rounded px-3 py-2">
                                <option value="">Select salary range</option>
                                <option value="200-400">200-400</option>
                                <option value="400-600">400-600</option>
                                <option value="600-800">600-800</option>
                                <option value="800-1000">800-1000</option>
                                <option value="More then 1000">More then 1000</option>
                            </select>
                        </div>

                        <InputLabel forr="location" label="Location" v-model="form.location" type="text" />

                        <div>
                            <label>Perferred</label>
                            <select v-model="form.preferred" class="form-control">
                                <option value="">Select</option>
                                <option value="Live In">Live In</option>
                                <option value="DayBurg">DayBurg</option>
                            </select>
                        </div>

                        <InputLabel forr="number_two" label="Phone" v-model="form.number_two" type="text" />

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

                        <div>
                            <label>Are You Mother</label>
                            <select v-model="form.isMother" class="form-control">
                                <option :value="null">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label>What age of kids do you prefer working with</label>
                            <select v-model="form.ageOfKids" class="form-control">
                                <option value="">Select Age</option>
                                <option value="0-3">0-3 years</option>
                                <option value="4-10">4-10 years</option>
                                <option value="more then 10">more then 10 years</option>
                            </select>
                        </div>

                        <div>
                            <label>Are you okay handling pets</label>
                            <select v-model="form.isHandelingPet" class="form-control">
                                <option :value="null">Select</option>
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                        </div>

                        <div>
                            <label>Preferred Role</label>
                            <select v-model="form.preferredRole" class="form-control">
                                <option value="">Select</option>
                                <option value="Nanny">Nanny</option>
                                <option value="Housekeeper">Housekeeper</option>
                            </select>
                        </div>


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
                            <label>First Aid Certificate</label>
                            <input type="file" class="dropify" :data-default-file="form.firstAidCertificate"
                                @change="(e) => handleFileChange(e, 'firstAidCertificate')" />
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