<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3'
import DataTable, { type DataTablePageEvent, type DataTableSortEvent } from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'
import Card from 'primevue/card'
import dashboardRoutes from '@/routes/dashboard'
import type { DashboardBidData, PaginatedResponse, UserBidStatus } from '@/types'
import CurrencyTag from '@/components/auction/CurrencyTag.vue'

const props = defineProps<{
  myBids: PaginatedResponse<DashboardBidData>;
}>()

const onBidsPage = (event: DataTablePageEvent) => {
  router.get(
    dashboardRoutes.index().url,
    {
      bids_page: event.page + 1,
      bids_sort_by: props.myBids.meta.bids_sort_by,
      bids_sort_order: props.myBids.meta.bids_sort_order
    },
    {
      preserveState: true,
      preserveScroll: true,
      only: ['myBids']
    }
  )
}

const onBidsSort = (event: DataTableSortEvent) => {
  router.get(
    dashboardRoutes.index().url,
    {
      bids_sort_by: event.sortField as string,
      bids_sort_order: event.sortOrder === 1 ? 'asc' : 'desc'
    },
    {
      preserveState: true,
      preserveScroll: true,
      only: ['myBids']
    }
  )
}

const getSeverityForStatus = (status: UserBidStatus) => {
  switch (status) {
  case 'winning':
    return 'success'
  case 'outbid':
    return 'warning'
  case 'won':
    return 'info'
  case 'lost':
    return 'danger'
  default:
    return 'secondary'
  }
}
</script>

<template>
  <Card>
    <template #title>
      <h2 class="text-xl font-bold">
        My Bids
      </h2>
    </template>

    <template #content>
      <DataTable
        lazy
        paginator
        size="small"
        :value="props.myBids.data"
        :rows="props.myBids.meta.per_page"
        :total-records="props.myBids.meta.total"
        :first="(props.myBids.meta.current_page - 1) * props.myBids.meta.per_page"
        paginator-template="PrevPageLink CurrentPageReport NextPageLink"
        current-page-report-template="{first} to {last} of {totalRecords}"
        @page="onBidsPage"
        @sort="onBidsSort"
      >
        <Column
          field="title"
          header="Lot"
          sortable
        >
          <template #body="{ data }">
            <Link
              :href="data.url"
              class="font-semibold hover:underline"
            >
              {{ data.title }}
            </Link>
            <div class="text-sm text-gray-500 dark:text-gray-400">
              in {{ data.auction_name }}
            </div>
          </template>
        </Column>

        <Column
          header="Current Price"
          field="current_price"
          sortable
        >
          <template #body="{ data }">
            <div class="flex items-center gap-2">
              <CurrencyTag :amount="data.current_price" />
            </div>
          </template>
        </Column>

        <Column
          field="ends_at"
          header="Ends"
          sortable
        />

        <Column
          field="user_bid_status"
          header="Status"
          sortable
        >
          <template #body="{ data }">
            <Tag
              :severity="getSeverityForStatus(data.user_bid_status)"
              :value="data.user_bid_status"
            />
          </template>
        </Column>
      </DataTable>
    </template>
  </Card>
</template>
