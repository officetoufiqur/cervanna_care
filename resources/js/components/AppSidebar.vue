<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import { Sidebar, SidebarContent, SidebarHeader, SidebarMenu, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Book, CalendarCheckIcon, CogIcon, ConstructionIcon, HandHeartIcon, HeartHandshakeIcon, InfoIcon, LayoutGrid, MessageCircleQuestionIcon, SquareUserRoundIcon, UserRoundCheckIcon } from 'lucide-vue-next';
import CogUser from './admin/icon/CogUser.vue';

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutGrid,
  },
  {
    title: 'Banner',
    icon: ConstructionIcon,
    subMenu: [
      {
        title: 'Hero Banner',
        href: '/banners',
      },
      {
        title: 'News Letter',
        href: '/news-letters',
      },
    ],
  },
  {
    title: 'Services',
    href: '/services',
    icon: CogUser,
  },
  {
    title: 'Works',
    href: '/works',
    icon: CogIcon,
  },
  {
    title: 'About',
    href: '/about',
    icon: InfoIcon,
  },
  {
    title: 'Our Core',
    href: '/our-cores',
    icon: HandHeartIcon,
  },
  {
    title: 'Our Foundation',
    href: '/foundation',
    icon: HeartHandshakeIcon,
  },
  {
    title: 'FAQs',
    href: '/faqs',
    icon: MessageCircleQuestionIcon,
  },
  {
    title: 'Chooses',
    href: '/chooses',
    icon: UserRoundCheckIcon,
  },
  {
    title: 'Events',
    href: '/events',
    icon: CalendarCheckIcon,
  },
  {
    title: 'Booking',
    icon: Book,
    subMenu: [
    {
     title: 'Price',
     href: '/price',
    },
    {
     title: 'Booking',
     href: '/booking',
    },
    {
     title: 'Plan',
     href: '/plan',
    },
    ]
  },
  {
    title: 'User Management',
    icon: SquareUserRoundIcon,
    subMenu: [
      {
        title: 'User',
        href: '/all-user',
      },
      {
        title: 'Specialist',
        href: '/all-specialist',
      },
      {
        title: 'Agency & Institution',
        href: '/all-agency',
      },
    ]
  },

  {
    title: 'Contact',
    icon: SquareUserRoundIcon,
    subMenu: [
      {
        title: 'Get in Touch',
        href: '/contacts',
      },
    ]
  },
  {
    title: 'Subscribe',
    href: '/subscribe',
    icon: SquareUserRoundIcon,
  }
];

</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <div class="mt-1 group/sidebar-wrapper" data-collapsible="icon">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <Link href="dashboard">
                        <div class="flex gap-2">
                            <div class="flex aspect-square size-9 items-center justify-center rounded-md mt-3">
                                <img class="w-14" src="/assets/images/fabicon.png" alt="icon">
                            </div>
                            <div class="grid flex-1 text-left text-sm mt-4">
                                <img class="w-28" src="/assets/images/logo2.png" alt="">
                            </div>
                        </div>
                        </Link>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
        </div>

        <SidebarContent class="mt-2">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <!-- <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter> -->
    </Sidebar>
    <slot />
</template>
