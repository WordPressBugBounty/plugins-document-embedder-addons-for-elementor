import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: path.resolve(__dirname, 'build'),
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, '/public/assets/admin/dashboard.js'),
    },
  },
});

// document-embedder-addons-for-elemento-pro/public/assets/admin/index.js
// document-embedder-addons-for-elemento-pro/public/assets/admin/index.css
