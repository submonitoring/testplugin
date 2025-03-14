<?php

namespace App\Filament\Jhpadmin\Widgets;

use App\Filament\Exports\BusinessPartnerExporter;
use App\Filament\Imports\BusinessPartnerImporter;
use App\Filament\Submonitoring\Resources\BusinessPartnerResource\RelationManagers\BusinessPartnerCompaniesRelationManager;
use App\Filament\Submonitoring\Resources\BusinessPartnerResource\RelationManagers\BusinessPartnerCustomersRelationManager;
use App\Filament\Submonitoring\Resources\BusinessPartnerResource\RelationManagers\BusinessPartnerVendorsRelationManager;
use App\Models\BusinessPartner as ModelsBusinessPartner;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Guava\FilamentModalRelationManagers\Actions\Table\RelationManagerAction;

class BusinessPartner extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModelsBusinessPartner::where('is_active', 1),
            )
            ->columns([
                ColumnGroup::make('Business Partner', [
                    TextColumn::make('bp_number')
                        ->label('BP Number')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),

                    TextColumn::make('name_1')
                        ->label('Name')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),
                ]),
            ])
            ->recordUrl(null)
            ->searchOnBlur()
            ->defaultPaginationPageOption(1)
            ->filters([
                QueryBuilder::make()
                    ->constraintPickerColumns(1)
                    ->constraints([

                        TextConstraint::make('bp_number')
                            ->label('BP Number')
                            ->icon(false),

                        TextConstraint::make('name_1')
                            ->label('Name')
                            ->icon(false)
                            ->nullable(),

                        BooleanConstraint::make('is_active')
                            ->label('Status')
                            ->icon(false)
                            ->nullable(),

                        TextConstraint::make('created_by')
                            ->label('Created by')
                            ->icon(false)
                            ->nullable(),

                        TextConstraint::make('updated_by')
                            ->label('Updated by')
                            ->icon(false)
                            ->nullable(),

                        DateConstraint::make('created_at')
                            ->icon(false)
                            ->nullable(),

                        DateConstraint::make('updated_at')
                            ->icon(false)
                            ->nullable(),

                    ])
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->deferFilters()
            ->headerActions([
                Tables\Actions\CreateAction::make(),

                ImportAction::make()
                    ->label('Import')
                    ->importer(BusinessPartnerImporter::class),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make(),
                    ])->dropdown(false),
                ]),

                RelationManagerAction::make('createbpcomp')
                    ->label('Company')
                    ->icon('heroicon-m-arrow-right-end-on-rectangle')
                    ->button()
                    ->outlined()
                    ->modalWidth('full')
                    ->modalSubmitActionLabel('Save')
                    ->relationManager(BusinessPartnerCompaniesRelationManager::make()),

                RelationManagerAction::make('createbpcust')
                    ->label('Customer')
                    ->icon('heroicon-m-arrow-right-end-on-rectangle')
                    ->button()
                    ->outlined()
                    ->modalWidth('full')
                    ->modalSubmitActionLabel('Save')
                    ->hidden(fn($record) => !in_array('1', $record->bp_role_id))
                    ->relationManager(BusinessPartnerCustomersRelationManager::make()),

                RelationManagerAction::make('createbpvend')
                    ->label('Vendor')
                    ->icon('heroicon-m-arrow-right-end-on-rectangle')
                    ->button()
                    ->outlined()
                    ->modalWidth('full')
                    ->modalSubmitActionLabel('Save')
                    ->hidden(fn($record) => !in_array('2', $record->bp_role_id))
                    ->relationManager(BusinessPartnerVendorsRelationManager::make()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                ExportBulkAction::make()
                    ->label('Export')
                    ->exporter(BusinessPartnerExporter::class)
            ]);
    }
}
