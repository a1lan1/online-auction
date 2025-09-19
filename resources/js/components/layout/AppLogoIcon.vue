<script setup lang="ts">
import Avatar from 'primevue/avatar'
import type { HTMLAttributes } from 'vue'

defineOptions({
  inheritAttrs: false
})

interface Props {
  className?: HTMLAttributes['class'];
}

withDefaults(defineProps<Props>(), {
  className: 'py-0.5'
})
</script>

<template>
  <Avatar
    :class="className"
    v-bind="$attrs"
    image="/favicon/favicon-96x96.png"
  />
</template>
