<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import { SidebarTrigger } from '@/components/ui/sidebar'
import { login, register, telescope } from '@/routes'
import type { BreadcrumbItemType } from '@/types'
import { Link } from '@inertiajs/vue3'
import Button from 'primevue/button'

withDefaults(
  defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
  }>(),
  {
    breadcrumbs: () => []
  }
)

function openInNewTab(url: string) {
  window.open(url, '_blank')
}
</script>

<template>
  <header class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
    <SidebarTrigger class="-ml-1" />

    <nav class="flex w-full items-center justify-between">
      <Breadcrumbs
        v-if="breadcrumbs.length > 0"
        :breadcrumbs="breadcrumbs"
      />

      <Button
        v-if="$page.props.auth.user"
        size="small"
        color="secondary"
        label="Telescope"
        @click="openInNewTab(telescope().url)"
      />
      <div
        v-else
        class="gap-2"
      >
        <Link
          :href="login()"
          class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
        >
          Log in
        </Link>
        <Link
          :href="register()"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
          Register
        </Link>
      </div>
    </nav>
  </header>
</template>
