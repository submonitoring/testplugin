<?php

namespace App\Filament\Submonitoring\Resources;

use App\Filament\Exports\MaterialTypeExporter;
use App\Filament\Imports\MaterialTypeImporter;
use App\Filament\Submonitoring\Clusters\MmBasicSettings;
use App\Filament\Submonitoring\Resources\MaterialTypeResource\Pages;
use App\Filament\Submonitoring\Resources\MaterialTypeResource\RelationManagers;
use App\Filament\Submonitoring\Widgets\MyTableWidgetChart;
use App\Models\MaterialType;
use App\Models\NumberRange;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Awcodes\Shout\Components\Shout;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use CodeWithDennis\SimpleAlert\Components\Forms\SimpleAlert;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad as FieldsSignaturePad;
use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Guava\FilamentModalRelationManagers\Actions\Table\RelationManagerAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use LaraZeus\Accordion\Forms\Accordion;
use LaraZeus\Accordion\Forms\Accordions;
use LaraZeus\Delia\Filament\Actions\BookmarkHeaderAction;
use LaraZeus\InlineChart\Tables\Columns\InlineChart;
use LaraZeus\MatrixChoice\Components\Matrix;
use LaraZeus\Popover\Tables\PopoverColumn;
use LaraZeus\Quantity\Components\Quantity;
use MohamedSabil83\FilamentHijriPicker\Forms\Components\HijriDatePicker;
use Novadaemon\FilamentCombobox\Combobox;
use Parallax\FilamentComments\Tables\Actions\CommentsAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use RalphJSmit\Filament\Components\Forms\Sidebar;
use Rupadana\FilamentSlider\Components\Concerns\InputSliderBehaviour;
use Rupadana\FilamentSlider\Components\InputSlider;
use Rupadana\FilamentSlider\Components\InputSliderGroup;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Schmeits\FilamentCharacterCounter\Forms\Components\TextInput;
use TomatoPHP\FilamentApi\Traits\InteractWithAPI;
use TomatoPHP\FilamentBookmarksMenu\Filament\Tables\BookmarkAction;
use ValentinMorice\FilamentSketchpad\FilamentSketchpad;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class MaterialTypeResource extends Resource
{

    use InteractWithAPI;

    protected static ?string $model = MaterialType::class;

    public static function canViewAny(): bool
    {
        return auth()->user()->id == 1;
    }

    protected static ?string $recordTitleAttribute = 'material_type_desc';

    protected static ?string $modelLabel = 'Material Type';

    protected static ?string $pluralModelLabel = 'Material Type';

    protected static ?string $navigationLabel = 'Material Type';

    protected static ?int $navigationSort = 803000000;

    // protected static ?string $navigationIcon = 'heroicon-o-Qisms';

    protected static ?string $cluster = MmBasicSettings::class;

    // protected static ?string $navigationGroup = 'System';

    // protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form

            ->schema(static::MaterialTypeFormSchema());
    }

    public static function MaterialTypeFormSchema(): array
    {
        return [

            PhoneInput::make('phone'),

            FilamentSketchpad::make('example'),

            // FieldsSignaturePad::make('signatures')
            //     ->backgroundColor('white') // Set the background color in case you want to download to jpeg
            //     ->penColor('blue') // Set the pen color
            //     ->strokeMinDistance(2.0) // set the minimum stroke distance (the default works fine)
            //     ->strokeMaxWidth(2.5) // set the max width of the pen stroke
            //     ->strokeMinWidth(1.0) // set the minimum width of the pen stroke
            //     ->strokeDotSize(2.0) // set the stroke dot size.
            //     ->hideDownloadButtons(), // In case you don't want to show the download buttons on the pad, you can hide them by setting this option.


            SignaturePad::make('signature')
                ->label(__('Sign here'))
                ->dotSize(2.0)
                ->lineMinWidth(0.5)
                ->lineMaxWidth(2.5)
                ->throttle(16)
                ->minDistance(5)
                ->velocityFilterWeight(0.7),

            InputSliderGroup::make()
                ->sliders([
                    InputSlider::make('min')
                ])
                ->label('Limit'),

            InputSliderGroup::make()
                ->sliders([
                    InputSlider::make('min'),
                    InputSlider::make('max')->default(50),
                ])
                ->connect([
                    true,
                    false,
                    true
                ]) // array length must be sliders length + 1
                ->range([
                    "min" => 30,
                    "max" => 100
                ])
                ->step(10)
                ->behaviour([
                    InputSliderBehaviour::DRAG,
                    InputSliderBehaviour::TAP
                ])
                ->enableTooltips()
                ->label("Limit"),

            Combobox::make('vegetables')
                ->options([
                    'carrot' => 'Carrot',
                    'potato' => 'Potato',
                    'tomato' => 'Tomato',
                ]),

            HijriDatePicker::make('date_of_birth'),

            Quantity::make('amount_number')
                ->heading('quantity')
                ->default(3)
                ->maxValue(10)
                ->minValue(2)
                // ->stacked()
                ->steps(2)
                // ->label('select quantity')
                ->required()
                ->inlineLabel()
                // ->disabled()
                ->hiddenLabel()
                ->helperText('between 2 and 10')
                ->columnSpan(1),

            Matrix::make('question')
                ->label('Tell us about your mod')
                ->asRadio()
                // or
                ->asCheckbox()
                ->columnData([
                    'c' => 'Create',
                    'r' => 'Read',
                    'u' => 'Update',
                    'd' => 'Delete',
                    'm' => 'Manage',
                    'p' => 'Approve',
                ])
                ->rowData([
                    'users' => 'Users',
                    'companies' => 'Companies',
                    'clients' => 'Clients',
                ])

                //set the row selection optional
                ->rowSelectRequired(false)

                // to disable any options:
                ->disableOptionWhen(fn(string $value): bool => $value === 'm' || $value === 'p' || $value === 'users'),

            Shout::make('so-important')
                ->content('This is a test'),

            SimpleAlert::make('example')
                ->color('purple')
                ->description('This is the description'),

            BarcodeInput::make('barcode')
                ->icon('heroicon-o-arrow-right') // Specify your Heroicon name here
                ->required(),

            SelectTree::make('number_range_id')
                ->relationship('numberRange', 'number_range_name', 'id'),

            Accordions::make('Options')
                ->activeAccordion(2)
                ->isolated()

                ->accordions([
                    Accordion::make('main-data')
                        ->columns()
                        ->label('User Details')
                        ->icon('heroicon-o-arrow-right')
                        ->badge('New Badge')
                        ->badgeColor('info')
                        ->schema([
                            TextInput::make('name')->required(),
                            TextInput::make('email')->required(),
                        ]),
                ]),

            Sidebar::make([
                // Components for the main section here

                Section::make('Material Type')
                    ->schema([

                        Grid::make(4)
                            ->schema([

                                TextInput::make('material_type')
                                    ->label('Material Type')
                                    ->required()
                                    ->unique(MaterialType::class, ignoreRecord: true),

                            ]),

                        Grid::make(4)
                            ->schema([

                                TextInput::make('material_type_desc')
                                    ->label('Desc')
                                    ->required(),

                            ]),

                    ])
                    ->compact(),

                Section::make('Number Range')
                    ->schema([

                        Grid::make(4)
                            ->schema([

                                Select::make('number_range_id')
                                    ->label('Number Range')
                                    ->options(NumberRange::whereIsActive(1)->pluck('number_range_name', 'id')),

                            ]),

                    ])
                    ->compact(),
            ], [
                // Components for the sidebar section here

                Section::make('Status')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                ToggleButtons::make('is_active')
                                    ->label('Active?')
                                    ->boolean()
                                    ->grouped()
                                    ->default(true),

                            ]),
                    ])->collapsible()
                    ->compact(),
            ]),



        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // InlineChart::make('last activities')
                //     ->chart(MyTableWidgetChart::class)
                //     ->maxWidth(350) // int, default 200
                //     ->maxHeight(90) // int, default 50
                //     ->description('description')
                //     ->toggleable(),

                ColumnGroup::make('Material Type', [

                    PopoverColumn::make('material_type')
                        ->label('Material Type')
                        // ->copyable()
                        // ->copyableState(function ($state) {
                        //     return ($state);
                        // })
                        // ->copyMessage('Tersalin')
                        ->sortable()
                        ->color('pink') // coloring, and its accept a closure too
                        ->trigger('hover') // support click and hover
                        ->placement('right') // for more: https://alpinejs.dev/plugins/anchor#positioning
                        ->offset(10) // int px, for more: https://alpinejs.dev/plugins/anchor#offset
                        ->popOverMaxWidth('none')
                        ->icon('heroicon-o-chevron-right')
                        ->content(fn($record) => new HtmlString($record->material_type . '<br>' . $record->material_type_desc)), // show custom icon,

                    TextColumn::make('material_type_desc')
                        ->label('desc')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),

                ]),

                ColumnGroup::make('Number Range', [

                    TextColumn::make('numberRange.number_range_name')
                        ->label('Number Range')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),

                ]),

                ColumnGroup::make('Status', [

                    // IconColumn::make('is_active')
                    //     ->label('Status')
                    //     ->boolean()
                    //     ->sortable(),

                    ToggleIconColumn::make('is_active')
                        ->label('Status')
                        ->sortable()
                        ->onIcon('heroicon-s-lock-open')
                        ->offIcon('heroicon-o-lock-closed'),

                    BadgeableColumn::make('is_active')
                        ->suffixBadges([
                            Badge::make('hot')
                                ->label('Hot')
                                ->color('danger'),
                        ])
                        ->prefixBadges([
                            Badge::make('brand_name')
                                ->label('brand_name')
                                ->color(function (Model $record) {
                                    return match ($record->is_active) {
                                        1 => 'success',
                                        2 => 'danger',
                                        default => 'warning',
                                    };
                                })
                        ])

                ]),

                ColumnGroup::make('Logs', [

                    TextColumn::make('created_by')
                        ->label('Created by')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),

                    TextColumn::make('updated_by')
                        ->label('Updated by')
                        ->copyable()
                        ->copyableState(function ($state) {
                            return ($state);
                        })
                        ->copyMessage('Tersalin')
                        ->sortable(),

                    TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),

                ]),
            ])
            ->recordUrl(null)
            ->searchOnBlur()
            ->filters([
                QueryBuilder::make()
                    ->constraintPickerColumns(1)
                    ->constraints([

                        TextConstraint::make('material_type')
                            ->label('Material Type')
                            ->nullable(),

                        TextConstraint::make('material_type_desc')
                            ->label('Desc')
                            ->nullable(),

                        SelectConstraint::make('number_range_id')
                            ->label('Number Range')
                            ->options(NumberRange::whereIsActive(1)->pluck('number_range_name', 'id'))
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

                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),

                ImportAction::make()
                    ->label('Import')
                    ->importer(MaterialTypeImporter::class),

                ExportAction::make(),

                // BookmarkHeaderAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

                CommentsAction::make(),

                // BookmarkAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                ExportBulkAction::make()
                    ->label('Export')
                    ->exporter(MaterialTypeExporter::class)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterialTypes::route('/'),
            'create' => Pages\CreateMaterialType::route('/create'),
            'view' => Pages\ViewMaterialType::route('/{record}'),
            'edit' => Pages\EditMaterialType::route('/{record}/edit'),
        ];
    }
}
