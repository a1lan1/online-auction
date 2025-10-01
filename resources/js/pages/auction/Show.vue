<script setup lang="ts">
import LotStatusTag from '@/components/auction/LotStatusTag.vue'
import { Avatar, AvatarImage } from '@/components/ui/avatar'
import AppLayout from '@/layouts/AppLayout.vue'
import auctions from '@/routes/auctions'
import lots from '@/routes/lots'
import type { Auction, BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import Card from 'primevue/card'

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
      <div class="flex rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
        <Avatar
          size="xlarge"
          class="mr-2 rounded-lg"
        >
          <AvatarImage
            size="xlarge"
            :src="auction.owner.avatar_url"
            :alt="auction.owner.name"
          />
        </Avatar>

        <h1 class="text-2xl font-semibold tracking-tight">
          {{ auction.name }}
        </h1>
      </div>

      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">
          Lots
        </h2>
      </div>

      <div
        v-if="auction.lots && auction.lots.length > 0"
        class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4"
      >
        <Link
          v-for="lot in auction.lots"
          :key="lot.id"
          :href="lots.show(lot.id).url"
        >
          <Card class="transform rounded-xl border text-card-foreground shadow-sm transition-transform hover:scale-[1.02] hover:shadow-md">
            <template #header>
              <img
                class="rounded-t-xl"
                :alt="lot.title"
                :src="lot.image_url"
              >
            </template>

            <template #title>
              <div class="truncate">
                {{ lot.title }}
              </div>
            </template>

            <template #subtitle>
              <LotStatusTag :status="lot.status" />
            </template>

            <template #content>
              <p class="m-0">
                {{ lot.description }}
              </p>
            </template>

            <template #footer>
              <div class="mt-3 flex items-center justify-between">
                <div class="space-y-1 text-sm text-muted-foreground">
                  <p>
                    Starting Price: <span class="font-semibold text-foreground">${{ lot.starting_price }}</span>
                  </p>
                  <p>
                    Current Price: <span class="font-semibold text-foreground">${{ lot.current_price }}</span>
                  </p>
                </div>

                <div class="space-y-1 text-sm text-muted-foreground">
                  <p><strong>Starts:</strong> {{ lot.starts_at }}</p>
                  <p><strong>Ends:</strong> {{ lot.ends_at }}</p>
                </div>
              </div>
            </template>
          </Card>
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
