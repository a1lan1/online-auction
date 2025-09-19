<script setup lang="ts">
import { ref, watch } from 'vue'

const props = defineProps<{
  digit: number;
}>()

const isFlipping = ref(false)
const currentDigit = ref(props.digit)
const previousDigit = ref(props.digit)

watch(() => props.digit, (newDigit, oldDigit) => {
  if (newDigit === oldDigit) return

  previousDigit.value = oldDigit
  currentDigit.value = newDigit
  isFlipping.value = true
})

function onAnimationEnd() {
  isFlipping.value = false
}
</script>

<template>
  <div
    class="relative h-24 w-16 font-mono text-6xl leading-[6rem] md:h-32 md:w-24 md:text-8xl md:leading-[8rem]"
    style="perspective: 300px"
  >
    <!-- Static Bottom Half -->
    <div class="absolute top-1/2 right-0 left-0 h-1/2 overflow-hidden rounded-b-lg bg-zinc-700 text-center leading-[0] text-zinc-200">
      {{ currentDigit }}
    </div>

    <!-- Static Top Half -->
    <div class="absolute top-0 right-0 left-0 h-1/2 overflow-hidden rounded-t-lg bg-zinc-800 text-center text-zinc-200">
      {{ currentDigit }}
    </div>

    <!-- Flipping Top Half -->
    <div
      :class="[
        'absolute top-0 right-0 left-0 h-1/2 overflow-hidden rounded-t-lg bg-zinc-800 text-center text-zinc-200',
        { 'animate-flip-top': isFlipping },
      ]"
      style="transform-origin: bottom; backface-visibility: hidden"
    >
      {{ previousDigit }}
    </div>

    <!-- Flipping Bottom Half -->
    <div
      :class="[
        'absolute top-1/2 right-0 left-0 h-1/2 overflow-hidden rounded-b-lg bg-zinc-700 text-center leading-[0] text-zinc-200',
        { 'animate-flip-bottom': isFlipping },
      ]"
      style="transform-origin: top; backface-visibility: hidden"
      @animationend="onAnimationEnd"
    >
      {{ previousDigit }}
    </div>
  </div>
</template>

<style scoped>
@keyframes flip-top {
  0% {
    transform: rotateX(0deg);
  }
  100% {
    transform: rotateX(-90deg);
  }
}

@keyframes flip-bottom {
  0% {
    transform: rotateX(90deg);
  }
  100% {
    transform: rotateX(0deg);
  }
}

.animate-flip-top {
  animation: flip-top 0.5s ease-in-out both;
}

.animate-flip-bottom {
  animation: flip-bottom 0.5s ease-in-out both;
}
</style>
