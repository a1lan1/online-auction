<script setup lang="ts">
import { onMounted } from 'vue'
import confetti from 'canvas-confetti'
import type { Lot } from '@/types'

const props = defineProps<{
  lot: Lot
}>()

const launchConfetti = () => {
  const duration = 5 * 1000
  const animationEnd = Date.now() + duration

  const defaults = {
    startVelocity: 30,
    spread: 360,
    ticks: 500,
    zIndex: 0,
    gravity: 1,
    colors: [
      '#63b163',
      '#0988b6',
      '#FF1493',
      '#c75f15',
      '#b60909',
      '#ffffff'
    ]
  }

  function randomInRange(min: number, max: number): number {
    return Math.random() * (max - min) + min
  }

  const interval = setInterval(() => {
    const timeLeft = animationEnd - Date.now()

    if (timeLeft <= 0) {
      return clearInterval(interval)
    }

    const particleCount = 50 * (timeLeft / duration)

    // Left side confetti
    confetti(
      Object.assign({}, defaults, {
        particleCount,
        origin: { x: randomInRange(0.1, 0.4), y: Math.random() - 0.2 }
      })
    )

    // Right side confetti
    confetti(
      Object.assign({}, defaults, {
        particleCount,
        origin: { x: randomInRange(0.6, 0.9), y: Math.random() - 0.2 }
      })
    )
  }, 250)
}

onMounted(() => {
  if (props.lot.winner) {
    launchConfetti()
  }
})
</script>

<template>
  <div class="rounded-xl border bg-card p-6 text-center text-card-foreground shadow-sm">
    <h2 class="text-2xl font-bold text-primary">
      Auction Finished!
    </h2>
    <div
      v-if="lot.winner"
      class="mt-4"
    >
      <p class="text-lg text-muted-foreground">
        The winner is:
      </p>
      <p class="text-3xl font-bold text-foreground">
        {{ lot.winner.name }}
      </p>
      <p class="mt-2 text-lg text-muted-foreground">
        with a final bid of
      </p>
      <p class="text-3xl font-bold text-primary">
        ${{ lot.current_price }}
      </p>
    </div>
    <div
      v-else
      class="mt-4"
    >
      <p class="text-lg text-muted-foreground">
        This auction ended without a winner.
      </p>
    </div>
  </div>
</template>
