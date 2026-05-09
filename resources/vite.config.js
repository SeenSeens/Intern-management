import { fileURLToPath, URL } from 'node:url'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
  build: {
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: `js/ims-app.js`,
        chunkFileNames: `js/[name].js`,
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'css/ims-style.css';
          }
          return 'media/[name].[ext]';
        }
      }
    }
  },
  server: {
    host: true,
    port: 5173,
    allowedHosts: ['wordpress.local'],
    cors: true,
    proxy: {
      '^/(wp-json|wp-admin|wp-login.php|intern)': {
        target: 'http://wordpress.local',
        changeOrigin: true,
        secure: false
      }
    }
  }
})
