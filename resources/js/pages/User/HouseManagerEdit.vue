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
        title: 'Edit Specialist',
        href: '/specialist',
    },          
];

interface specialist {
    id: number;
    name?: string;
    role?: string;
    subRole?: string;
    education?: string;
    location?: string;
    preferredRole?: string;
    languages?: string;
    number?: string;
    preferred?: string;

    house_manager: {
        experience?: string;
        isMother?: boolean;
        ageOfKids?: string;
        salaryRange?: string;
        isHandelingPet?: boolean;
        preferBeingA?: string;
        firstAidCertificate?: string;
        goodConductCertificate: string;
    }

    is_profile_completed: boolean;
    is_profile_verified: boolean;
    created_at: string;
}


const props = defineProps<{
    specialist: specialist;
}>()

const form = useForm({

    name: props.specialist.name,
    role: props.specialist.role,
    subRole: props.specialist.subRole,
    education: props.specialist.education,
    location: props.specialist.location,
    preferredRole: props.specialist.preferredRole,
    languages: props.specialist.languages,
    number: props.specialist.number,
    preferred: props.specialist.preferred,

    experience: props.specialist.house_manager.experience,
    salaryRange: props.specialist.house_manager.salaryRange,
    isMother: props.specialist.house_manager.isMother,
    ageOfKids: props.specialist.house_manager.ageOfKids,
    isHandelingPet: props.specialist.house_manager.isHandelingPet,
    preferBeingA: props.specialist.house_manager.preferBeingA,
    firstAidCertificate: props.specialist.house_manager.firstAidCertificate,
    goodConductCertificate: props.specialist.house_manager.goodConductCertificate,

    is_profile_completed: props.specialist.is_profile_completed,
    is_profile_verified: props.specialist.is_profile_verified,
    created_at: props.specialist.created_at,
});
 

const submit = () => {
    form.put('/specialist/update/' + props.specialist.id);
}

onMounted(() => {
    $('#firstAidCertificate').dropify({
        defaultFile: props.specialist.house_manager.firstAidCertificate,
        height: 120,
        messages: {
            default: 'Drag and drop a file here or click',
            replace: 'Drag and drop or click to replace',
            remove: 'Remove',
            error: 'Ooops, something wrong happened.'
        }
    });
});
onMounted(() => {
    $('#goodConductCertificate').dropify({
        defaultFile: props.specialist.house_manager.goodConductCertificate,
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
                                    <InputLabel forr="education" :label="'Education'" v-model="form.education" type="text"
                                        :placeholder="'Education'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.education">{{ form.errors.education }}</span>
                                </div>
                                <div>   
                                    <InputLabel forr="experience" :label="'Experience'" v-model="form.experience" type="text"
                                        :placeholder="'Experience'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.experience">{{ form.errors.experience }}</span>
                                </div>
                                <div>   
                                    <InputLabel forr="location" :label="'location'" v-model="form.location" type="text"
                                        :placeholder="'location'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.location">{{ form.errors.location }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="preferredRole" :label="'preferredRole'" v-model="form.preferredRole" type="text"
                                        :placeholder="'preferredRole'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.preferredRole">{{ form.errors.preferredRole }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="languages" :label="'languages'" v-model="form.languages" type="text"
                                        :placeholder="'languages'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.languages">{{ form.errors.languages }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="phone" :label="'phone'" v-model="form.number" type="text"
                                        :placeholder="'phone'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="salaryRange" :label="'salaryRange'" v-model="form.salaryRange" type="text"
                                        :placeholder="'salaryRange'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.salaryRange">{{ form.errors.salaryRange }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="preferred" :label="'preferred'" v-model="form.preferred" type="text"
                                        :placeholder="'preferred'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.preferred">{{ form.errors.preferred }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="isMother" :label="'Is Mother'" v-model="form.isMother" type="text"
                                        :placeholder="'Is Mother'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.isMother">{{ form.errors.isMother }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="ageOfKids" :label="'ageOfKids'" v-model="form.ageOfKids" type="text"
                                        :placeholder="'ageOfKids'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.ageOfKids">{{ form.errors.ageOfKids }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="isHandelingPet" :label="'isHandelingPet'" v-model="form.isHandelingPet" type="text"
                                        :placeholder="'isHandelingPet'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.isHandelingPet">{{ form.errors.isHandelingPet }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="preferBeingA" :label="'preferBeingA'" v-model="form.preferBeingA" type="text"
                                        :placeholder="'preferBeingA'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.preferBeingA">{{ form.errors.preferBeingA }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="firstAidCertificate" id="firstAidCertificate" :label="'First Aid Certificate'" @input="form.firstAidCertificate = $event.target.files[0]" type="file"
                                        :placeholder="'Enter image URL'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.firstAidCertificate">{{ form.errors.firstAidCertificate }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="goodConductCertificate" id="goodConductCertificate" :label="'Good Conduct Certificate'" @input="form.goodConductCertificate = $event.target.files[0]" type="file"
                                        :placeholder="'Enter image URL'" readonly/>
                                    <span class="text-red-500 text-sm" v-if="form.errors.goodConductCertificate">{{ form.errors.goodConductCertificate }}</span>
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