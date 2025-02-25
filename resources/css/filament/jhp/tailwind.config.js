import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Jhp/**/*.php',
        './resources/views/filament/jhp/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
