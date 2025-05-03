import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',     // نقطة إدخال واحدة تكوّن كل CSS
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
