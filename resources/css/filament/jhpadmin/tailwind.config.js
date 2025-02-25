import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Jhpadmin/**/*.php',
        './resources/views/filament/jhpadmin/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
