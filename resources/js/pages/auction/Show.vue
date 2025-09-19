<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import auctions from '@/routes/auctions'
import lots from '@/routes/lots'
import { type Auction, type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'

interface Props {
  auction: Auction;
}

const props = defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Auctions',
    href: auctions.index().url
  },
  {
    title: props.auction.name,
    href: lots.show(props.auction.id).url
  }
]
</script>

<template>
  <Head :title="auction.name" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-y-auto p-4">
      <div class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
        <h1 class="text-2xl font-semibold tracking-tight">
          {{ auction.name }}
        </h1>
        <div class="mt-3 space-y-1 text-sm text-muted-foreground">
          <p><strong>Starts:</strong> {{ new Date(auction.starts_at).toLocaleString() }}</p>
          <p><strong>Ends:</strong> {{ new Date(auction.ends_at).toLocaleString() }}</p>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
          Lots
        </h2>
      </div>

      <div
        v-if="auction.lots && auction.lots.length > 0"
        class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
      >
        <Link
          v-for="lot in auction.lots"
          :key="lot.id"
          :href="lots.show(lot.id).url"
          class="block transform rounded-xl border bg-card text-card-foreground shadow-sm transition-transform hover:scale-[1.02] hover:shadow-md"
        >
          <div class="p-6">
            <h3 class="text-lg font-semibold tracking-tight">
              {{ lot.title }}
            </h3>
            <div class="mt-3 space-y-1 text-sm text-muted-foreground">
              <p>
                Starting Price: <span class="font-semibold text-foreground">${{ lot.starting_price }}</span>
              </p>
              <p>
                Current Price: <span class="font-semibold text-foreground">${{ lot.current_price }}</span>
              </p>
            </div>
          </div>
        </Link>
      </div>
      <div
        v-else
        class="flex h-full min-h-64 flex-1 items-center justify-center rounded-xl border-2 border-dashed"
      >
        <p class="text-lg font-medium text-muted-foreground">
          No lots found for this auction.
        </p>
      </div>
    </div>
  </AppLayout>
</template>
