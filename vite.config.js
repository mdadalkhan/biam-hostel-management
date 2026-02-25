import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        port: 8080,
        strictPort: true,
        host: 'localhost', 
        hmr: {
            host: 'localhost',
            port: 8080,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});