<script setup lang="ts">
defineProps<{
  forr?: string;
  label?: string;
}>();

</script>

<template>
  <label :for="forr" class="text-[#5D5D5D] font-medium">{{ label }}</label>
</template>
