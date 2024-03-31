import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        host: "localhost",
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',
                'resources/js/Scripts/QuestionsCheckbox.jsx',

                ],
            ssr: 'resources/js/ssr.jsx',
            refresh: true,

        }),
        react(),
    ],

});
