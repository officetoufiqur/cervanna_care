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
        title: 'Add Agency Employee',
        href: '/agency-employee/create',
    },
];

const props = defineProps<{
    agencies: {
        id: number;
        companyName: string;
    }[];
}>()

interface AgencyEmployeeForm {
    agency_id: string;
    name: string;
    educationLevel: string;
    location: string;
    experience: string;
    salaryRange: string;
    isMother: string;
    kidAges: string;
    handlePets: string;
    preferredRole: string;
    languages: string[];
    cooking: string;
    housekeeping: string;
    childcare: string;
    preferred: string;
    idCopy: File | null;
    profilePhoto: File | null;
    drivingLicense: File | null;
    goodConductCertificate: File | null;
    aidCertificate: File | null;
}


const form = useForm<AgencyEmployeeForm>({
    agency_id: '',
    name: '',
    educationLevel: '',
    location: '',
    experience: '',
    salaryRange: '',
    isMother: '',
    kidAges: '',
    handlePets: '',
    preferredRole: '',
    languages: [],
    cooking: '',
    housekeeping: '',
    childcare: '',
    preferred: '',
    idCopy: null,
    profilePhoto: null,
    drivingLicense: null,
    goodConductCertificate: null,
    aidCertificate: null,
});


const handleFileChange = (
    e: Event,
    field: keyof AgencyEmployeeForm
) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form[field] = target.files[0] as any;
    }
};



const submit = () => {
    form.post('/agency-employee/store');
};

onMounted(() => {
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

    <Head title="Employee Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Employee Create</h1>
                <LinkButton :label="'Back'" :url="'/agency-employee'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit" enctype="multipart/form-data">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <!-- Basic Info -->
                        <div>
                            <label class="block mb-1">Agency</label>
                            <select v-model="form.agency_id" class="w-full border rounded px-3 py-2">
                                <option value="">Select Agency</option>
                                <option v-for="agency in props.agencies" :key="agency.id" :value="agency.id">
                                    {{ agency.companyName }}
                                </option>
                            </select>
                        </div>
                        <InputLabel forr="name" label="Name" v-model="form.name" type="text"
                            :placeholder="'Enter Name'" />
                        <div>
                            <label class="block mb-1">Education Level</label>
                            <select v-model="form.educationLevel" class="w-full border rounded px-3 py-2">
                                <option value="">Select education</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Bachelor">Bachelor</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <InputLabel forr="location" label="Location" v-model="form.location" type="text"
                            placeholder="Type your location" />
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
                        <div>
                            <label class="block mb-1">Salary (KSh)</label>
                            <select v-model="form.salaryRange" class="w-full border rounded px-3 py-2">
                                <option value="">Select salary</option>
                                <option value="200-400">200-400</option>
                                <option value="400-600">400-600</option>
                                <option value="600-800">600-800</option>
                                <option value="800-1000">800-1000</option>
                                <option value="More than 1000">More than 1000</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Is Mother?</label>
                            <select v-model="form.isMother" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Kid Ages</label>
                            <select v-model="form.kidAges" class="w-full border rounded px-3 py-2">
                                <option value="">Select kid ages</option>
                                <option value="0-3 years">0-3 years</option>
                                <option value="4-10 years">4-10 years</option>
                                <option value="11+ years">11+ years</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Handle Pets?</label>
                            <select v-model="form.handlePets" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Preferred Role</label>
                            <select v-model="form.preferredRole" class="w-full border rounded px-3 py-2">
                                <option value="">Select preferred role</option>
                                <option value="Nanny">Nanny</option>
                                <option value="Housekeeper">Housekeeper</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Preferred Role</label>
                            <select v-model="form.preferred" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

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
                            <label class="block mb-1">Cooking Skill</label>
                            <select v-model="form.cooking" class="w-full border rounded px-3 py-2">
                                <option value="">Select cooking</option>
                                <option value="Strong">Strong</option>
                                <option value="Average">Average</option>
                                <option value="Weak">Weak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1">Housekeeping Skill</label>
                            <select v-model="form.housekeeping" class="w-full border rounded px-3 py-2">
                                <option value="">Select housekeeping</option>
                                <option value="Strong">Strong</option>
                                <option value="Average">Average</option>
                                <option value="Weak">Weak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Childcare Skill</label>
                            <select v-model="form.childcare" class="w-full border rounded px-3 py-2">
                                <option value="">Select cleaning</option>
                                <option value="Strong">Strong</option>
                                <option value="Average">Average</option>
                                <option value="Weak">Weak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1">Preferred</label>
                            <select v-model="form.preferred" class="w-full border rounded px-3 py-2">
                                <option value="">Select preferred</option>
                                <option value="Live In">Live In</option>
                                <option value="DayBurg">DayBurg</option>
                            </select>
                        </div>

                    </div>

                    <!-- File Upload Section -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block mb-1">ID Copy</label>
                            <input type="file" class="dropify" @change="(e) => handleFileChange(e, 'idCopy')" />
                        </div>

                        <div>
                            <label class="block mb-1">Profile Photo</label>
                            <input type="file" class="dropify" @change="(e) => handleFileChange(e, 'profilePhoto')" />
                        </div>

                        <div>
                            <label class="block mb-1">Driving License</label>
                            <input type="file" class="dropify" @change="(e) => handleFileChange(e, 'drivingLicense')" />
                        </div>

                        <div>
                            <label class="block mb-1">Good Conduct Certificate</label>
                            <input type="file" class="dropify"
                                @change="(e) => handleFileChange(e, 'goodConductCertificate')" />
                        </div>

                        <div>
                            <label class="block mb-1">Aid Certificate</label>
                            <input type="file" class="dropify" @change="(e) => handleFileChange(e, 'aidCertificate')" />
                        </div>

                    </div>

                    <div class="mt-8">
                        <Button label="Create" type="submit" />
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
