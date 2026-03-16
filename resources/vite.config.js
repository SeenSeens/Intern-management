import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
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
    // Thư mục xuất file (Trỏ ra ngoài thư mục assets/frontend của plugin)
    // Giả sử thư mục Vue của bạn nằm ngang hàng với assets
    //outDir: '../assets/frontend',
    emptyOutDir: true, // Xóa file cũ trước khi build file mới
    rollupOptions: {
      output: {
        // Ép Vite xuất ra tên file cố định
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
    host: 'plugin.wordpress.local',
    port: 5173,
    proxy: {
      '^/(wp-json|wp-admin|wp-login.php)': {
        target: 'http://plugin.wordpress.local',
        changeOrigin: true,
        secure: false
      }
    }
  }
})
