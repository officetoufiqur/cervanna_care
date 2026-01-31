<script setup lang="ts">
const props = defineProps<{
  title: string;
  value?: string | number;
}>();
</script>

<template>
  <div class="relative rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
    <div class="flex h-[9rem] w-full items-center justify-center gap-5">
      <div class="icon bg-[#56284f] px-4 py-4 text-white rounded-md">
        <slot name="icon" />
      </div>
      <div>
        <h1 class="text-2xl font-semibold text-gray-800">{{ props.value }}</h1>
        <p>{{ props.title }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.icon {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
