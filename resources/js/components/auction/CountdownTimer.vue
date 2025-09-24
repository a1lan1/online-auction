<script setup lang="ts">
import TimeUnit from '@/components/auction/TimeUnit.vue'
import { useCountdown } from '@/composables/useCountdown'
import { TimeConfigItem } from '@/types'

interface Props {
  date: string;
  type: 'up' | 'down';
}

const props = withDefaults(defineProps<Props>(), {
  date: undefined,
  type: 'down'
})

const { timer, targetDate } = useCountdown(props.date, props.type)

const timeConfig: TimeConfigItem[] = [
  { unit: 'days', limits: [10, 10], prevUnit: 'prevDays' },
  { unit: 'hours', limits: [3, 10], prevUnit: 'prevHours' },
  { unit: 'minutes', limits: [6, 10], prevUnit: 'prevMinutes' },
  { unit: 'seconds', limits: [6, 10], prevUnit: 'prevSeconds' }
]
</script>

<template>
  <div class="flipTimer-wrapper">
    <div
      class="flipTimer"
      :data-flip-date="targetDate.toISOString()"
      :data-flip-type="type"
    >
      <template
        v-for="(config, index) in timeConfig"
        :key="config.unit"
      >
        <TimeUnit
          :label="config.unit"
          :digits="timer[config.unit]"
          :previous-digits="timer[config.prevUnit]"
          :digit-limits="config.limits"
          :show-separator="index < timeConfig.length - 1"
        />
      </template>
    </div>
  </div>
</template>

<style scoped>
.flipTimer-wrapper {
  padding: 40px;
  background-color: #ffffffab;
  border-radius: 20px;
  box-shadow: 0 0.125rem 0.35rem rgba(226, 227, 228, 0.65);
  backdrop-filter: blur(2px);
  -webkit-backdrop-filter: blur(2px);
}

.flipTimer {
  color: #111111;
  font-family: 'Helvetica Neue', Helvetica, sans-serif;
  font-size: 90px;
  font-weight: bold;
  line-height: 100px;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
