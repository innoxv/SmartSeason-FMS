import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            buildDirectory: 'build',
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: ['resources/css/app.css', 'resources/js/app.js'],
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
            },
        },
    },
    server: {
        host: true,
    },
});