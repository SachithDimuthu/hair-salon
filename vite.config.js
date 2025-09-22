import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Production optimizations
        minify: 'esbuild',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['lodash', 'axios'],
                    alpine: ['alpinejs'],
                },
            },
        },
        // Generate sourcemaps for debugging in staging
        sourcemap: process.env.NODE_ENV !== 'production',
        // Asset optimization
        assetsInlineLimit: 4096,
        // Chunk size warnings
        chunkSizeWarningLimit: 1000,
    },
    // Production server settings
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    // CSS optimizations
    css: {
        devSourcemap: true,
    },
});
