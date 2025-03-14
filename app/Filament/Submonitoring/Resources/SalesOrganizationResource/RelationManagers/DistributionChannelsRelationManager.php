<?php

namespace App\Filament\Submonitoring\Resources\SalesOrganizationResource\RelationManagers;

use App\Filament\Submonitoring\Resources\DistributionChannelResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Guava\FilamentModalRelationManagers\Concerns\CanBeEmbeddedInModals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DistributionChannelsRelationManager extends RelationManager
{
    protected static string $relationship = 'distributionChannels';

    use CanBeEmbeddedInModals;

    public static function getNavigationLabel(): string
    {
        return 'Distribution Channels';
    }

    public function form(Form $form): Form
    {
        return DistributionChannelResource::form($form);
    }

    public function table(Table $table): Table
    {
        return DistributionChannelResource::table($table)
            ->recordTitleAttribute('distribution_channel_name')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query->where('is_active', true))
                    // ->recordSelectSearchColumns(['name_1', 'name_4', 'address_number'])
                    ->preloadRecordSelect()
                    ->multiple(),
            ])
            ->actions([
                ActionGroup::make([
                    ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\DetachAction::make(),
                        Tables\Actions\EditAction::make(),
                    ])->dropdown(false),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
