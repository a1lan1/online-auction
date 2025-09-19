import type { App } from 'vue'
import axios from './axios'
import echo from './echo'
import pinia from './pinia'
import primevue from './primevue'

export function registerPlugins(app: App) {
  app
    .use(echo)
    .use(pinia)
    .use(axios)
    .use(primevue)
}
