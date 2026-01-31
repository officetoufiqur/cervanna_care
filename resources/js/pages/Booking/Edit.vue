<script setup lang="ts">
import Button from '@/components/admin/Button.vue';
import InputLabel from '@/components/admin/InputLabel.vue';
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Booking',
        href: '/booking',
    },          
];

interface Booking {
    id: number;
    specialist_id: number;
    booking_person_id: number;
    patient_name: string;
    patient_age: string;
    patient_gender: string;
    relationship_to_booking_person: string;
    price_id: string;
    booking_amount: string;
    patient_have_any_conditions: string;
    patient_currently_on_medication: string;
    patient_have_any_known_allergies: string;
    mobility_status_of_patient: string;
    care_start_date: string;
    care_end_date: string;
    location_of_care: string;
    emergency_contact_name: string;
    emergency_contact_number: string;
    primary_doctor_name: string;
    primary_doctor_number: string;
    primary_hospital: string;
    patient_currently_on_medication_data: string;
    patient_have_any_known_allergies_details: string;
    booking_status: string;
}

const props = defineProps<{
    booking: Booking;
}>()

const form = useForm({

    id: props.booking.id,
    specialist_id: props.booking.specialist.name,
    booking_person_id: props.booking.user.name,
    patient_name: props.booking.patient_name,
    patient_age: props.booking.patient_age,
    patient_gender: props.booking.patient_gender,
    relationship_to_booking_person: props.booking.relationship_to_booking_person,
    price_id: props.booking.price.name,
    booking_amount: props.booking.booking_amount,
    patient_have_any_conditions: props.booking.patient_have_any_conditions,
    patient_currently_on_medication: props.booking.patient_currently_on_medication,
    patient_have_any_known_allergies: props.booking.patient_have_any_known_allergies,
    mobility_status_of_patient: props.booking.mobility_status_of_patient,
    care_start_date: props.booking.care_start_date,
    care_end_date: props.booking.care_end_date,
    location_of_care: props.booking.location_of_care,
    emergency_contact_name: props.booking.emergency_contact_name,
    emergency_contact_number: props.booking.emergency_contact_number,
    primary_doctor_name: props.booking.primary_doctor_name,
    primary_doctor_number: props.booking.primary_doctor_number,
    primary_hospital: props.booking.primary_hospital,
    patient_currently_on_medication_data: props.booking.patient_currently_on_medication_data,
    patient_have_any_known_allergies_details: props.booking.patient_have_any_known_allergies_details,
    booking_status: props.booking.booking_status,
});

const submit = () => {
    form.put('/booking/update/' + props.booking.id);
}

</script>

<template>

    <Head title="Booking Update" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-medium mb-4">Booking Update</h1>
                <LinkButton :label="'Back'" :url="'/booking'" />
            </div>

            <div class="border border-gray-200 p-10 mt-3 shadow rounded">
                <form @submit.prevent="submit">
                   <div class="space-y-3 grid grid-cols-2 gap-5">
                        <div class="space-y-4">
                                <div>
                                    <InputLabel forr="specialist_id" :label="'Specialist'" v-model="form.specialist_id" type="text"
                                        :placeholder="'Specialist'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.specialist_id">{{ form.errors.specialist_id }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="patient_name" :label="'Patient Name'" v-model="form.patient_name" type="text"
                                        :placeholder="'Patient Name'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.patient_name">{{ form.errors.patient_name }}</span>
                                </div>

                                <div>
                                    <InputLabel forr="relationship_to_booking_person" :label="'Relationship to Booking Person'" v-model="form.relationship_to_booking_person" type="text"
                                        :placeholder="'Relationship to Booking Person'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.relationship_to_booking_person">{{ form.errors.relationship_to_booking_person }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="price_id" :label="'Price'" v-model="form.price_id" type="text"
                                        :placeholder="'Price'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.price_id">{{ form.errors.price_id }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="booking_amount" :label="'Booking Amount'" v-model="form.booking_amount" type="text"
                                        :placeholder="'Booking Amount'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.booking_amount">{{ form.errors.booking_amount }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="patient_have_any_known_allergies" :label="'Patient Have Any Known Allergies'" v-model="form.patient_have_any_known_allergies" type="text"
                                        :placeholder="'Patient Have Any Known Allergies'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.patient_have_any_known_allergies">{{ form.errors.patient_have_any_known_allergies }}</span>
                                </div>
                                <div>
                                    <InputLabel forr="care_start_date" :label="'Care Start Date'" v-model="form.care_start_date" type="text"
                                        :placeholder="'Care Start Date'" />
                                    <span class="text-red-500 text-sm" v-if="form.errors.care_start_date">{{ form.errors.care_start_date }}</span>
                                </div>
                            <div>
                                <InputLabel forr="patient_currently_on_medication" :label="'Patient Currently On Medication'" v-model="form.patient_currently_on_medication" type="text"
                                    :placeholder="'Patient Currently On Medication'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_currently_on_medication">{{ form.errors.patient_currently_on_medication }}</span>
                            </div>
                            <div>
                                <InputLabel forr="location_of_care" :label="'Location of Care'" v-model="form.location_of_care" type="text"
                                    :placeholder="'Location of Care'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.location_of_care">{{ form.errors.location_of_care }}</span>
                            </div>
                            <div>
                                <InputLabel forr="primary_doctor_name" :label="'Primary Doctor Name'" v-model="form.primary_doctor_name" type="text"
                                    :placeholder="'Primary Doctor Name'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.primary_doctor_name">{{ form.errors.primary_doctor_name }}</span>
                            </div>
                            <div>
                                <InputLabel forr="patient_currently_on_medication_data" :label="'Patient Currently On Medication Data'" v-model="form.patient_currently_on_medication_data" type="text"
                                    :placeholder="'Patient Currently On Medication Data'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_currently_on_medication_data">{{ form.errors.patient_currently_on_medication_data }}</span>
                            </div>
                        </div> 
                        <div class="space-y-4">
                            <div>
                                <InputLabel forr="booking_person_id" :label="'Booking Person'" v-model="form.booking_person_id" type="text"
                                    :placeholder="'Booking Person'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.booking_person_id">{{ form.errors.booking_person_id }}</span>
                            </div>
                            <div>
                                <InputLabel forr="patient_age" :label="'Patient Age'" v-model="form.patient_age" type="text"
                                    :placeholder="'Patient Age'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_age">{{ form.errors.patient_age }}</span>
                            </div>
                            <div>
                                <InputLabel forr="patient_gender" :label="'Patient Gender'" v-model="form.patient_gender" type="text"
                                    :placeholder="'Patient Gender'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_gender">{{ form.errors.patient_gender }}</span>
                            </div>
                            <div>
                                <InputLabel forr="patient_have_any_conditions" :label="'Patient Have Any Conditions'" v-model="form.patient_have_any_conditions" type="text"
                                    :placeholder="'Patient Have Any Conditions'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_have_any_conditions">{{ form.errors.patient_have_any_conditions }}</span>
                            </div>
                            <div>
                                <InputLabel forr="mobility_status_of_patient" :label="'Mobility Status of Patient'" v-model="form.mobility_status_of_patient" type="text"
                                    :placeholder="'Mobility Status of Patient'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.mobility_status_of_patient">{{ form.errors.mobility_status_of_patient }}</span>
                            </div>
                            <div>
                                <InputLabel forr="care_end_date" :label="'Care End Date'" v-model="form.care_end_date" type="text"
                                    :placeholder="'Care End Date'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.care_end_date">{{ form.errors.care_end_date }}</span>
                            </div>
                            <div>
                                <InputLabel forr="emergency_contact_name" :label="'Emergency Contact Name'" v-model="form.emergency_contact_name" type="text"
                                    :placeholder="'Emergency Contact Name'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.emergency_contact_name">{{ form.errors.emergency_contact_name }}</span>
                            </div>
                            <div>
                                <InputLabel forr="emergency_contact_number" :label="'Emergency Contact Number'" v-model="form.emergency_contact_number" type="text"
                                    :placeholder="'Emergency Contact Number'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.emergency_contact_number">{{ form.errors.emergency_contact_number }}</span>
                            </div>
                            <div>
                                <InputLabel forr="primary_doctor_number" :label="'Primary Doctor Number'" v-model="form.primary_doctor_number" type="text"
                                    :placeholder="'Primary Doctor Number'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.primary_doctor_number">{{ form.errors.primary_doctor_number }}</span>
                            </div>
                            <div>
                                <InputLabel forr="primary_hospital" :label="'Primary Hospital'" v-model="form.primary_hospital" type="text"
                                    :placeholder="'Primary Hospital'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.primary_hospital">{{ form.errors.primary_hospital }}</span>
                            </div>
                            <div>
                                <InputLabel forr="patient_have_any_known_allergies_details" :label="'Patient Have Any Known Allergies Details'" v-model="form.patient_have_any_known_allergies_details" type="text"
                                    :placeholder="'Patient Have Any Known Allergies Details'" />
                                <span class="text-red-500 text-sm" v-if="form.errors.patient_have_any_known_allergies_details">{{ form.errors.patient_have_any_known_allergies_details }}</span>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 mb-8">
                        <select className="form-control" name="booking_status" id="booking_status" v-model="form.booking_status">
                            <option value="">Select Booking Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <span class="text-red-500 text-sm" v-if="form.errors.booking_status">{{ form.errors.booking_status }}</span>
                    </div>
                    <Button :label="`Update`" :type="`submit`" />
                </form>
            </div>

        </div>
    </AppLayout>
</template>