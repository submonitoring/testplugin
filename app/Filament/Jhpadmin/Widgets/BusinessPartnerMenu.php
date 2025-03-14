<?php

namespace App\Filament\Jhpadmin\Widgets;

use App\Filament\Jhpadmin\Resources\BusinessPartnerResource;
use App\Models\BusinessPartner;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Support\Enums\ActionSize;
use Filament\Widgets\Widget;

class BusinessPartnerMenu extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.jhpadmin.widgets.business-partner-menu';

    protected ?string $heading = 'Analytics';

    protected ?string $description = 'An overview of some analytics.';

    protected function getHeading(): ?string
    {
        return 'Business Partner';
    }

    protected function getDescription(): ?string
    {
        return 'Business Partner Menu';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Placeholder::make('')
                    ->content('Business Partner Menu'),

                Actions::make([
                    Action::make('createbp')
                        ->label('Create BP')
                        ->icon('heroicon-o-user-plus')
                        ->size(ActionSize::ExtraSmall)
                        ->url(BusinessPartnerResource::getUrl('create')),

                    Action::make('changebp')
                        ->label('Change BP')
                        ->icon('heroicon-o-pencil')
                        ->size(ActionSize::ExtraSmall)
                        ->form([
                            Select::make('id')
                                ->label('Business Partner')
                                ->searchable(['search_term', 'search_term2'])
                                ->options(BusinessPartner::all()->pluck('name_1', 'id'))
                                ->native(false)
                                ->live(),

                        ]),
                    // ->modalSubmitAction(function (Get $get) {

                    //     $bpid = $get('id');

                    //     return (redirect()->route('filament.jhpadmin.business-partner.resources.business-partners.edit', 1));
                    // }),
                    // ->action(fn() => redirect()->route('filament.jhpadmin.business-partner.resources.business-partners.edit', $this->data['id'])),

                    Action::make('listbp')
                        ->label('List BP')
                        ->icon('heroicon-o-user-group')
                        ->size(ActionSize::ExtraSmall)
                        ->url(BusinessPartnerResource::getUrl()),
                ]),
            ]);
    }
}
