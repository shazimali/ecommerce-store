import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            base: '/build/',
        }),
    ],
    server: {
        hmr: {
            host: 'everydayplastic.co',
            protocol: 'wss',
        },
        watch: {
            usePolling: true,
        },
        https: true,
        strictPort: true,
        port: 5173,
    },
});
