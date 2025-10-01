<script setup lang="ts">
import ActionHistoryTable from '@/components/dashboard/ActionHistoryTable.vue'
import MyBidsTable from '@/components/dashboard/MyBidsTable.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import dashboardRoutes from '@/routes/dashboard'
import type { ActionHistoryData, BreadcrumbItem, DashboardBidData, PaginatedResponse } from '@/types'
import { Head } from '@inertiajs/vue3'
import { History, List } from 'lucide-vue-next'
import Tab from 'primevue/tab'
import TabList from 'primevue/tablist'
import TabPanel from 'primevue/tabpanel'
import TabPanels from 'primevue/tabpanels'
import Tabs from 'primevue/tabs'
import { ref } from 'vue'

const props = defineProps<{
  myBids: PaginatedResponse<DashboardBidData>;
  actionHistory: PaginatedResponse<ActionHistoryData>;
}>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboardRoutes.index().url
  }
]

const activeTab = ref('my-bids')
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4">
      <Tabs :value="activeTab">
        <TabList>
          <Tab value="my-bids">
            <div class="flex items-center gap-2">
              <List class="size-5" /><span>My Bids</span>
            </div>
          </Tab>
          <Tab value="action-history">
            <div class="flex items-center gap-2">
              <History class="size-5" /><span>Action History</span>
            </div>
          </Tab>
        </TabList>
        <TabPanels>
          <TabPanel value="my-bids">
            <MyBidsTable :my-bids="props.myBids" />
          </TabPanel>
          <TabPanel value="action-history">
            <ActionHistoryTable :action-history="props.actionHistory" />
          </TabPanel>
        </TabPanels>
      </Tabs>
    </div>
  </AppLayout>
</template>
