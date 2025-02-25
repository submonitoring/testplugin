import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                `resources/css/filament/submonitoring/theme.css`,
                `resources/css/filament/jhp/theme.css`,
                `resources/css/filament/jhpadmin/theme.css`,
                `resources/css/filament/login/theme.css`,
            ],
            refresh: true,
        }),
    ],
});
