import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Submonitoring/**/*.php',
        './resources/views/filament/submonitoring/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
