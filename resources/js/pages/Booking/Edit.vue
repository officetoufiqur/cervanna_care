<script setup lang="ts">
import LinkButton from '@/components/admin/LinkButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Booking Details',
        href: '/booking',
    },
];

interface Booking {
    id: number;
    specialist_id?: number;
    booking_person_id?: number;
    patient_name?: string;
    patient_age?: string;
    patient_gender?: string;
    relationship_to_booking_person?: string;
    price_id?: string;
    booking_amount?: string;
    patient_have_any_conditions?: Array<string>;
    patient_currently_on_medication?: string;
    patient_have_any_known_allergies?: string;
    mobility_status_of_patient?: string;
    care_start_date?: string;
    care_end_date?: string;
    location_of_care?: string;
    emergency_contact_name?: string;
    emergency_contact_number?: string;
    primary_doctor_name?: string;
    primary_doctor_number?: string;
    primary_hospital?: string;
    patient_currently_on_medication_data?: string;
    patient_have_any_known_allergies_details?: string;
    booking_status?: string;
    specialist?: { name: string };
    user?: { name: string };
}

const props = defineProps<{
    booking: Booking;
}>()

const form = useForm({
    booking_status: props.booking.booking_status,
});


const hasCondition = (condition: string) => {
    return props.booking.patient_have_any_conditions?.some(
        (c: string) => c.toLowerCase() === condition.toLowerCase()
    );
};

</script>

<template>
    <Head title="Booking Details" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="pt-10 lg:px-20 px-5 pb-20">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-medium">Booking Details</h1>
                <LinkButton :label="'Back'" :url="'/booking'" />
            </div>

            <div class="bg-white border border-gray-200 p-8 shadow-sm rounded-lg max-w-6xl mx-auto">

                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">1. Patient / Care Recipient Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" :value="booking.patient_name" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <input type="text" :value="booking.patient_age" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-gray-600">
                                    <input type="radio" :checked="booking.patient_gender === 'male'" :disabled="booking.patient_gender !== 'male'" class="text-blue-600 bg-gray-800"> Male
                                </label>
                                <label class="flex items-center gap-2 text-gray-600">
                                    <input type="radio" :checked="booking.patient_gender === 'female'" :disabled="booking.patient_gender !== 'female'" class="text-blue-600 bg-gray-100"> Female
                                </label>
                                <label class="flex items-center gap-2 text-gray-600">
                                    <input type="radio" :checked="booking.patient_gender === 'others'" :disabled="booking.patient_gender !== 'others'" class="text-blue-600 bg-gray-100"> Others
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to Booker</label>
                            <input type="text" :value="booking.relationship_to_booking_person" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 focus:outline-none" />
                        </div>
                    </div>
                </div>
                 <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">2. Specialist & User Info</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded mt-4">
                         <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase">Booked Specialist</span>
                            <span class="text-gray-800 font-medium">{{ booking.specialist?.name }}</span>
                         </div>

                         <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase">Who Booked</span>
                            <span class="text-gray-800 font-medium">{{ booking.user?.name }}</span>
                         </div>
                     </div>
                </div>
                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">3. Health & Medical Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div v-for="condition in ['Diabetes', 'Hypertension', 'Asthma', 'Heart Disease', 'Stroke History', 'Cancer', 'Epilepsy', 'Mental Health Condition', 'Mobility Limitations']" :key="condition" class="flex items-center gap-2">
                                <input
                                type="checkbox"
                                :checked="hasCondition(condition)"
                                :disabled="!hasCondition(condition)"
                                class="rounded border-gray-300 text-blue-600 bg-gray-50"
                                />
                                <span class="text-gray-600">{{ condition }}</span>
                        </div>
                        <!-- <div class="col-span-full mt-2">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Full Condition Record:</label>
                             <textarea readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 text-sm h-20">{{ booking.patient_have_any_conditions }}</textarea>
                        </div> -->
                    </div>
                </div>

                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">4. Medication & Allergies</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Is the patient currently on medication?</label>
                        <div class="flex gap-4 mb-2">
                            <label class="flex items-center gap-2 text-gray-600">
                                <input
                                    type="radio"
                                    name="on_medication"
                                    :checked="booking.patient_currently_on_medication"
                                    :disabled="!booking.patient_currently_on_medication"
                                >
                                Yes
                            </label>

                            <label class="flex items-center gap-2 text-gray-600">
                                <input
                                    type="radio"
                                    name="on_medication"
                                    :checked="!booking.patient_currently_on_medication"
                                    :disabled="booking.patient_currently_on_medication"
                                >
                                No
                            </label>
                        </div>


                        <div v-if="booking.patient_currently_on_medication_data" class="ml-0 md:ml-4">
                            <input type="text" :value="booking.patient_currently_on_medication_data" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 text-sm" placeholder="Medication details" />
                        </div>


                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Does the patient have any known allergies?</label>
                        <input type="text" :value="booking.patient_have_any_known_allergies" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 mb-2" />
                        <div v-if="booking.patient_have_any_known_allergies_details">
                             <input type="text" :value="booking.patient_have_any_known_allergies_details" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600 text-sm" placeholder="Allergy details" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobility status of patient:</label>
                        <div class="flex flex-wrap gap-4">
                            <label v-for="status in ['fully-mobile', 'needs-assistance', 'wheelchair-bound', 'bedridden']" :key="status" class="flex items-center gap-2 text-gray-600">
                                <input type="radio" :checked="booking.mobility_status_of_patient === status" :disabled="booking.mobility_status_of_patient !== status"> {{ status }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-8 border-b border-gray-100 pb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">5. Care Schedule & Environment</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Care Start Date</label>
                             <input type="text" :value="booking.care_start_date" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                        </div>
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Care End Date</label>
                             <input type="text" :value="booking.care_end_date" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                        </div>

                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <input type="text" :value="booking.booking_amount" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                    </div>



                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location of care:</label>
                        <div class="flex gap-4">
                             <label v-for="loc in ['Private Home', 'Hospital', 'Hospice Facility']" :key="loc" class="flex items-center gap-2 text-gray-600">
                                <input type="radio" :checked="booking.location_of_care === loc" :disabled="booking.location_of_care !== loc"> {{ loc }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Care Duration:</label>
                        <div class="flex gap-4">
                             <label v-for="loc in ['Daily', 'Live-in']" :key="loc" class="flex items-center gap-2 text-gray-600">
                                <input type="radio" :checked="booking.location_of_care === loc" :disabled="booking.location_of_care !== loc"> {{ loc }}
                            </label>
                        </div>
                    </div>



                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">6. Emergency & Consent</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact Name</label>
                            <input type="text" :value="booking.emergency_contact_name" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                         </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact Phone</label>
                            <input type="text" :value="booking.emergency_contact_number" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                         </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Doctor Name</label>
                            <input type="text" :value="booking.primary_doctor_name" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                         </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Doctor Contact</label>
                            <input type="text" :value="booking.primary_doctor_number" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                         </div>
                          <div class="col-span-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Primary Hospital</label>
                            <input type="text" :value="booking.primary_hospital" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                         </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                        <input type="text" :value="booking.booking_status" readonly class="w-full bg-gray-50 border border-gray-300 rounded px-3 py-2 text-gray-600" />
                    </div>
                </div>

                <!-- <div class="mt-8 pt-6 border-t border-gray-200">
                    <form @submit.prevent="submit" class="flex items-end gap-4">
                        <div class="flex-grow">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Booking Status</label>
                            <select class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" name="booking_status" id="booking_status" v-model="form.booking_status">
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="text-red-500 text-sm" v-if="form.errors.booking_status">{{ form.errors.booking_status }}</span>
                        </div>
                        <div>
                             <Button :label="`Update Status`" :type="`submit`" />
                        </div>
                    </form>
                </div> -->

            </div>
        </div>
    </AppLayout>
</template>
