import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    publicDir: 'public',
    server: {
        host: "localhost",
        port: 80, // Use the same port as your Laragon web application
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',
                'resources/js/Scripts/QuestionsCheckbox.jsx',
                'resources/js/Pages/SCORM/SCORMCreator.jsx',

                ],
            ssr: 'resources/js/ssr.jsx',
            refresh: true,

        }),
        react(),
    ],

});
