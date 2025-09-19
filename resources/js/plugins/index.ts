import echo from './echo'
import pinia from './pinia'
import axios from './axios'
import primevue from './primevue'
import type { App } from 'vue'

export function registerPlugins(app: App) {
  app
    .use(echo)
    .use(pinia)
    .use(axios)
    .use(primevue)
}
