<?php

namespace App\Filament\Imports;

use App\Models\BusinessPartnerCustomer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BusinessPartnerCustomerImporter extends Importer
{
    protected static ?string $model = BusinessPartnerCustomer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('sort')
                ->rules(['max:255']),
            ImportColumn::make('business_partner_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('sales_organization_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('distribution_channel_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('division_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('account_assignment_group_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('tax_classification_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('currency_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('payment_term_id')
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

    public function resolveRecord(): ?BusinessPartnerCustomer
    {
        // return BusinessPartnerCustomer::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new BusinessPartnerCustomer();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your business partner customer import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
