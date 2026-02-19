<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import NavUser from '@/components/NavUser.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { usePage, router } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';
import { computed, ref } from 'vue';

withDefaults(defineProps<{
  breadcrumbs?: BreadcrumbItemType[];
}>(), {
  breadcrumbs: () => []
});

const notification = ref(false);

const toggleNotification = () => {
  notification.value = !notification.value
}

const page = usePage();

// All notifications
const notifications = computed(() => page.props.notifications ?? [])

// Unread count only
const unreadCount = computed(() =>
  notifications.value.filter((n: any) => !n.read_at).length
)

// Mark as read
const markAsRead = (id: string) => {
  router.post(`/notifications/${id}/read`, {}, {
    preserveScroll: true,
    onSuccess: () => {
      notification.value = false
    }
  })
}
</script>

<template>
  <header
    class="flex justify-between h-15 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-15 md:px-4">

    <div class="flex items-center gap-2">
      <SidebarTrigger class="-ml-1" />
      <template v-if="breadcrumbs && breadcrumbs.length > 0">
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </template>
    </div>

    <div class="flex items-center">
      <div class="mr-3 relative">

        <!-- Bell Icon -->
        <a class="cursor-pointer relative" @click="toggleNotification">
          <Bell class="text-[#56274E] lg:text-2xl text-xl" />

          <!-- Unread Badge -->
          <span v-if="unreadCount > 0"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
            {{ unreadCount }}
          </span>
        </a>

        <!-- Dropdown -->
        <div v-show="notification"
          class="z-50 mt-3 w-80 absolute border text-base shadow bg-white divide-y divide-gray-100 rounded-xl right-0">

          <ul class="py-2 max-h-96 overflow-y-auto">

            <template v-if="notifications.length">

              <li
                v-for="notif in notifications"
                :key="notif.id"
                @click="markAsRead(notif.id)"
                class="px-4 py-3 text-sm cursor-pointer transition hover:bg-gray-100"
                :class="{
                  'bg-purple-50 font-semibold text-gray-900': !notif.read_at,
                  'text-gray-500': notif.read_at
                }"
              >
                {{ notif.data?.title ?? 'Notification' }}

                <p class="text-xs text-gray-400 mt-1">
                  {{ new Date(notif.created_at).toLocaleString() }}
                </p>
              </li>

            </template>

            <template v-else>
              <li>
                <p class="px-4 py-3 text-sm text-gray-500 text-center">
                  No notifications found
                </p>
              </li>
            </template>

          </ul>
        </div>

      </div>

      <NavUser />
    </div>
  </header>
</template>
