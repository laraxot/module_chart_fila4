import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import { fileURLToPath } from 'node:url'
import { resolve } from 'node:path'

const __dirname = fileURLToPath(new URL('.', import.meta.url))

export default defineConfig({
  build: {
    outDir: './resources/dist',
    emptyOutDir: false,
    manifest: 'manifest.json',
  },
  plugins: [
    laravel({
      publicDirectory: '../../../public_html',
      buildDirectory: 'assets/chart',
      input: [
        resolve(__dirname, 'resources/css/app.css'),
        resolve(__dirname, 'resources/js/app.js'),
        resolve(__dirname, 'resources/js/filament-chart-js-plugins.js'),
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
})
