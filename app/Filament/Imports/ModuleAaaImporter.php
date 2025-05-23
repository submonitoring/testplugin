<?php

namespace App\Filament\Imports;

use App\Models\ModuleAaa;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ModuleAaaImporter extends Importer
{
    protected static ?string $model = ModuleAaa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('module_aaa')
                ->rules(['max:255']),
            ImportColumn::make('module_aaa_name')
                ->rules(['max:255']),
            ImportColumn::make('application_name_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('created_by')
                ->rules(['max:255']),
            ImportColumn::make('updated_by')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?ModuleAaa
    {
        // return ModuleAaa::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ModuleAaa();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your module aaa import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
