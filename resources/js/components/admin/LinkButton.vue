<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps < {
    label?: string
    url?: string
} > ()
</script>
<template>
    <Link :href="url || '#'"
        class="bg-[#72275B] hover:bg-[#56284F] px-6 py-2 text-white rounded-md cursor-pointer">
        {{ label }}
    </Link>
</template>