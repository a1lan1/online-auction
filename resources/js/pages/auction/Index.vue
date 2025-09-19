<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import auctionRoutes from '@/routes/auctions'
import type { Auction, BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'

interface Props {
  auctions: Auction[];
}

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Auctions',
    href: auctionRoutes.index().url
  }
]
</script>

<template>
  <Head title="Auctions" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-y-auto p-4">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">
          Auctions
        </h1>
      </div>

      <div
        v-if="auctions.length > 0"
        class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
      >
        <Link
          v-for="auction in auctions"
          :key="auction.id"
          :href="auctionRoutes.show(auction.id).url"
          class="block transform rounded-xl border bg-card text-card-foreground shadow-sm transition-transform hover:scale-[1.02] hover:shadow-md"
        >
          <div class="p-6">
            <h2 class="text-xl font-semibold tracking-tight">
              {{ auction.name }}
            </h2>
            <div class="mt-3 space-y-1 text-sm text-muted-foreground">
              <p><strong>Starts:</strong> {{ new Date(auction.starts_at).toLocaleString() }}</p>
              <p><strong>Ends:</strong> {{ new Date(auction.ends_at).toLocaleString() }}</p>
            </div>
          </div>
        </Link>
      </div>
      <div
        v-else
        class="flex h-full flex-1 items-center justify-center rounded-xl border-2 border-dashed"
      >
        <p class="text-lg font-medium text-muted-foreground">
          No active auctions found.
        </p>
      </div>
    </div>
  </AppLayout>
</template>
