<script setup>
import { useRoute } from 'vue-router'
import InventoryItemsTab from '@/views/pages/inventory/InventoryItemsTab.vue'

const route = useRoute()
const activeTab = ref(route.params.tab)

// tabs
const tabs = [
  {
    title: 'Inventory Items',
    icon: 'bx-products',
    tab: 'inventory',
  },
]
</script>

<template>
  <div>
    <VTabs
      v-model="activeTab"
      show-arrows
    >
      <VTab
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
      >
        <VIcon
          size="20"
          start
          :icon="item.icon"
        />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />

    <VWindow
      v-model="activeTab"
      class="mt-5 disable-tab-transition"
    >   
      <VWindowItem value="inventory">
        <InventoryItemsTab />
      </VWindowItem>
    </VWindow>
  </div>
</template>
