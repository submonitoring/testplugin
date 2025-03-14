<?php

namespace App\Filament\Imports;

use App\Models\Currency;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CurrencyImporter extends Importer
{
    protected static ?string $model = Currency::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('currency')
                ->rules(['max:255']),
            ImportColumn::make('symbol')
                ->rules(['max:255']),
            ImportColumn::make('currency_code')
                ->rules(['max:255']),
            ImportColumn::make('numeric')
                ->rules(['max:255']),
            ImportColumn::make('decimal')
                ->rules(['max:255']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('created_by')
                ->rules(['max:255']),
            ImportColumn::make('updated_by')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Currency
    {
        // return Currency::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Currency();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your currency import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
