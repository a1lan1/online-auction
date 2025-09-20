<script setup lang="ts">
import Button from 'primevue/button'

interface Props {
  title?: string;
  color?: string;
  loading: boolean;
  disabled: boolean;
}

withDefaults(defineProps<Props>(), {
  title: 'Place Bid',
  color: 'success',
  loading: false,
  disabled: false
})
</script>

<template>
  <Button
    type="submit"
    :loading="loading"
    :disabled="disabled"
    :severity="color"
    class="h-10 rounded-md px-6 py-2 font-bold transition-transform duration-150 ease-in-out active:scale-95"
  >
    {{ title }}
  </Button>
</template>
