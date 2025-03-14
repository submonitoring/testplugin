<?php

namespace App\Filament\Imports;

use App\Models\DivisionSalesOrganization;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DivisionSalesOrganizationImporter extends Importer
{
    protected static ?string $model = DivisionSalesOrganization::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('division_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('sales_organization_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('isactive')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('created_by')
                ->rules(['max:255']),
            ImportColumn::make('updated_by')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?DivisionSalesOrganization
    {
        // return DivisionSalesOrganization::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new DivisionSalesOrganization();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your division sales organization import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
