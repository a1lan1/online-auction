<script setup lang="ts">
import CurrencyTag from '@/components/auction/CurrencyTag.vue'
import dashboardRoutes from '@/routes/dashboard'
import type { ActionHistoryData, PaginatedResponse } from '@/types'
import { Link, router } from '@inertiajs/vue3'
import { ArrowUpRight, Calendar } from 'lucide-vue-next'
import Card from 'primevue/card'
import Chip from 'primevue/chip'
import Column from 'primevue/column'
import DataTable, { type DataTablePageEvent, type DataTableSortEvent } from 'primevue/datatable'

const props = defineProps<{
  actionHistory: PaginatedResponse<ActionHistoryData>;
}>()

const onHistoryPage = (event: DataTablePageEvent) => {
  router.get(
    dashboardRoutes.index().url,
    {
      history_page: event.page + 1,
      history_sort_by: props.actionHistory.meta.history_sort_by,
      history_sort_order: props.actionHistory.meta.history_sort_order
    },
    { preserveState: true, preserveScroll: true, only: ['actionHistory'] }
  )
}

const onHistorySort = (event: DataTableSortEvent) => {
  router.get(
    dashboardRoutes.index().url,
    {
      history_sort_by: event.sortField as string,
      history_sort_order: event.sortOrder === 1 ? 'asc' : 'desc'
    },
    { preserveState: true, preserveScroll: true, only: ['actionHistory'] }
  )
}
</script>

<template>
  <Card>
    <template #content>
      <DataTable
        lazy
        paginator
        size="small"
        :value="props.actionHistory.data"
        :rows="props.actionHistory.meta.per_page"
        :total-records="props.actionHistory.meta.total"
        :first="(props.actionHistory.meta.current_page - 1) * props.actionHistory.meta.per_page"
        paginator-template="PrevPageLink CurrentPageReport NextPageLink"
        current-page-report-template="{first} to {last} of {totalRecords}"
        @page="onHistoryPage"
        @sort="onHistorySort"
      >
        <Column header="Action">
          <template #body>
            <div class="flex items-center gap-3">
              <Chip label="Placed a bid" />
            </div>
          </template>
        </Column>

        <Column
          header="Lot"
          field="lot_title"
        >
          <template #body="{ data }">
            <div class="flex items-center gap-2">
              <ArrowUpRight class="h-4 w-4" />
              <Link
                :href="data.lot_url"
                class="truncate font-semibold hover:underline"
                style="max-width: 40ch"
              >
                {{ data.lot_title }}
              </Link>
            </div>
          </template>
        </Column>

        <Column
          header="Amount"
          field="amount"
          sortable
        >
          <template #body="{ data }">
            <div class="flex items-center gap-2">
              <CurrencyTag :amount="data.amount" />
            </div>
          </template>
        </Column>

        <Column
          field="created_at"
          header="Date"
          sortable
        >
          <template #body="{ data }">
            <div class="flex items-center gap-2">
              <Calendar class="h-4 w-4" />
              <span class="text-sm">{{ data.created_at }}</span>
            </div>
          </template>
        </Column>
      </DataTable>
    </template>
  </Card>
</template>
