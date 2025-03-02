import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // Assure-toi que ce fichier existe
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: 'public/build', // Génère les fichiers dans public/build/
        manifest: true,
        rollupOptions: {
            input: 'resources/js/app.js',
        },
    },
});
