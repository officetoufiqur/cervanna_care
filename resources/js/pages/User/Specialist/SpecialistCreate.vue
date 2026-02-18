<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Specialist',
        href: '/specialist',
    },
];

const form = useForm({

    name: '',
    email: '',
    password: '',
    role: 'specialist',
    experience: '',
    location: '',
    subRole: '',
    education: '',
    number: '',

});


const submit = () => {
    form.post('/specialist/store');
}

</script>

<template>

    <Head title="Specialist Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Create Specialist</h1>
                <LinkButton :label="'Back'" :url="'/all-specialist'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                            <div class="mt-5 mb-8">
                                <h1 class="text-sm font-medium mb-2">Specialist</h1>

                                <select
                                    class="form-control"
                                    name="subRole"
                                    id="subRole"
                                    v-model="form.subRole"
                                    required
                                >
                                    <option value="" :selected="true">Select Specialist</option>
                                    <option :value="'house-manager'">House Manager </option>
                                    <option :value="'nurse'">Nurse</option>
                                    <option :value="'physiotherapist'">physiotherapist</option>
                                    <option :value="'nurse-aide-or-assistant'">Nurse Aide or Assistant</option>
                                    <option :value="'special-need-caregivers'">Special Need Caregivers</option>
                                </select>

                                <span
                                    class="text-red-500 text-sm"
                                    v-if="form.errors.subRole"
                                >
                                    {{ form.errors.subRole }}
                                </span>
                            </div>
                            <div>
                                <InputLabel forr="name" :label="'Name'" v-model="form.name" type="text"
                                    :placeholder="'Name'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                            </div>

                            <div>
                                <InputLabel forr="number" :label="'Number'" v-model="form.number" type="text"
                                    :placeholder="'Number'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                            </div>

                            <div>
                                <InputLabel forr="email" :label="'Email'" v-model="form.email" type="text"
                                    :placeholder="'Email'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</span>
                            </div>

                            <div class="relative">
                                <InputLabel forr="password" :label="'Password'" v-model="form.password" type="password"
                                    :placeholder="'Password'" />
                                <EyeIcon class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" /> 
                                <span class="text-red-500 text-sm" v-if="form.errors.password">{{ form.errors.password }}</span>
                            </div>

                            <div class="mt-5 mb-8">
                                <h1 class="text-sm font-medium mb-2">Experience</h1>

                                <select
                                    class="form-control"
                                    name="experience"
                                    id="experience"
                                    v-model="form.experience"
                                    required
                                >
                                    <option value="" :selected="true">Select Experience</option>
                                    <option :value="'1'">1 Year</option>
                                    <option :value="'2'">2 Years</option>
                                    <option :value="'3'">3 Years</option>
                                    <option :value="'4'">4 Years</option>
                                    <option :value="'5+'">More Than 5 Years</option>
                                </select>

                                <span
                                    class="text-red-500 text-sm"
                                    v-if="form.errors.experience"
                                >
                                    {{ form.errors.experience }}
                                </span>
                            </div>

                            <div>
                                <InputLabel forr="location" :label="'Location'" v-model="form.location" type="text"
                                    :placeholder="'Location'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.location">{{ form.errors.location }}</span>
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-end mt-5">
                        <Button :label="`Create Specialist`" :type="`submit`" />
                    </div>
                </form>
            </div>

        </div>
    </AppLayout>
</template>
