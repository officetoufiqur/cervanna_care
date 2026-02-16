<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit User',
        href: '/user',
    },          
];

interface User {
    id: number;
    name: string;
    email: string;
    profileImage: string;
    role: string;
    is_profile_verified: boolean;
    created_at: string;
    number?: string;
    age?: string;
    gender?: string;
}

const props = defineProps<{
    user: User;
}>()

const form = useForm({

    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    number: props.user.number,
    profileImage: props.user.profileImage,
    role: props.user.role,
    age: props.user.age,
    gender: props.user.gender,
    is_profile_verified: props.user.is_profile_verified,
    created_at: props.user.created_at,
});

const submit = () => {
    form.put('/user/update/' + props.user.id);
}

</script>

<template>

    <Head title="User Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">User Update</h1>
                <LinkButton :label="'Back'" :url="'/all-user'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-1 gap-5">
                        <div class="space-y-4">
                                <div>
                                    <InputLabel forr="name" :label="'Name'" v-model="form.name" type="text"
                                        :placeholder="'Name'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="email" :label="'Email'" v-model="form.email" type="text"
                                        :placeholder="'Email'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.email">{{ form.errors.email }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="number" :label="'Number'" v-model="form.number" type="text"
                                        :placeholder="'Number'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.number">{{ form.errors.number }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="age" :label="'Age'" v-model="form.age" type="text"
                                        :placeholder="'Age'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.age">{{ form.errors.age }}</span>
                                </div>
                                <div class="mt-5 mb-8">
                                    <h1 class="text-sm font-medium mb-2">Gender</h1>

                                    <select
                                        class="form-control"
                                        name="gender"
                                        id="gender"
                                        v-model="form.gender"
                                    >
                                        <option value="" :selected="true">Select Gender</option>
                                        <option :value="'Male'">Male</option>
                                        <option :value="'Female'">Female</option>
                                        <option :value="'Other'">Other</option>
                                    </select>

                                    <span
                                        class="text-red-500 text-sm"
                                        v-if="form.errors.gender"
                                    >
                                        {{ form.errors.gender }}
                                    </span>
                                </div>
             
                                <div class="mt-5 mb-8">
                                    <h1 class="text-sm font-medium mb-2">Profile Verified</h1>

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