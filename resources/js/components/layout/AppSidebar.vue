<script setup lang="ts">
import LotSearch from '@/components/LotSearch.vue'
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  useSidebar
} from '@/components/ui/sidebar'
import auctionRoutes from '@/routes/auctions'
import { index as dashboardRoute } from '@/routes/dashboard'
import { type NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'

const { open } = useSidebar()

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboardRoute(),
    icon: LayoutGrid
  }
]

const footerNavItems: NavItem[] = [
  {
    title: 'Github Repo',
    href: 'https://github.com/a1lan1/online-auction',
    icon: Folder
  },
  {
    title: 'PrimeVue',
    href: 'https://primevue.org',
    icon: BookOpen
  }
]
</script>

<template>
  <Sidebar
    collapsible="icon"
    variant="inset"
  >
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton
            size="lg"
            as-child
          >
            <Link :href="auctionRoutes.index()">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <div
        v-if="open"
        class="mb-4 px-4"
      >
        <LotSearch />
      </div>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
