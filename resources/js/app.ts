import { initializeTheme } from '@/composables/useAppearance'
import { registerPlugins } from '@/plugins'
import { createInertiaApp } from '@inertiajs/vue3'
import { configureEcho } from '@laravel/echo-vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import '../css/app.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

configureEcho({
  broadcaster: 'pusher'
})

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),

  resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),

  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) }).use(plugin)

    registerPlugins(app)

    app.mount(el)
  },

  progress: {
    color: '#4B5563'
  }
})

// This will set light / dark mode on page load...
initializeTheme()
