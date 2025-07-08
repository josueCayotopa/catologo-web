<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaPersonalSalidaResource\Pages;
use App\Models\PlaPersonalSalida;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use App\Models\PlaPersonal;
use App\Models\PlaCargos;
use App\Models\MaeAreas;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PlaPersonalSalidaResource extends Resource
{
    protected static ?string $model = PlaPersonalSalida::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Personal Salidas';
    protected static ?string $modelLabel = 'Personal Salida';
    protected static ?string $pluralModelLabel = 'Personal Salidas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Buscar personal (opcional)')
                ->schema([
                    Select::make('COD_PERSONAL_TEMP')
                        ->label('Buscar en base de datos')
                        ->options(function () {
                            return PlaPersonal::all()->mapWithKeys(function ($p) {
                                $nombreCompleto = $p->NOM_TRABAJADOR . ' ' . $p->APE_PATERNO . ' ' . $p->APE_MATERNO;
                                return [$p->COD_PERSONAL => $nombreCompleto];
                            });
                        })
                        ->searchable()
                        ->placeholder('Buscar trabajador...')
                        ->reactive()
                        ->afterStateUpdated(function ($state, \Filament\Forms\Set $set) {
                            if ($state) {
                                $p = PlaPersonal::where('COD_PERSONAL', $state)->first();
                                if ($p) {
                                    $set('NOMBRES', $p->NOM_TRABAJADOR);
                                    $set('APELLIDOS', trim($p->APE_PATERNO . ' ' . $p->APE_MATERNO));
                                }
                            }
                        }),
                ]),

            Fieldset::make('Datos del trabajador')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('NOMBRES')
                            ->label('Nombres')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('APELLIDOS')
                            ->label('Apellidos')
                            ->required()
                            ->maxLength(100),
                    ]),

                    Grid::make(2)->schema([
                        Select::make('AREA')
                            ->label('Área')
                            ->options(function () {
                                return MaeAreas::all()->mapWithKeys(function ($a) {
                                    return [$a->DES_AREAS => $a->DES_AREAS];
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->placeholder('Seleccionar área...')
                            ->required(),

                        Select::make('CARGO')
                            ->label('Cargo')
                            ->options(function () {
                                return PlaCargos::all()->mapWithKeys(function ($c) {
                                    return [$c->DES_CARGO => $c->DES_CARGO];
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->placeholder('Seleccionar cargo...')
                            ->required(),
                    ]),

                    Select::make('ESTADO')
                        ->label('Estado')
                        ->options([
                            'A' => 'Activo',
                            'I' => 'Inactivo',
                        ])
                        ->default('A'),
                ]),

            // Campos ocultos que se llenan automáticamente
            Hidden::make('USUARIO_CREA')
                ->default(fn () => auth()->id()),
            
            Hidden::make('EMAIL_USUARIO_CREA')
                ->default(fn () => auth()->user()?->email),
                
            Hidden::make('FECHA_REGISTRO')
                ->default(fn () => now()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('NOMBRES')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('APELLIDOS')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('AREA')
                    ->label('Área')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('CARGO')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('usuarioCreador.name')
                    ->label('Creado por')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('EMAIL_USUARIO_CREA')
                    ->label('Email Creador')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('FECHA_REGISTRO')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('ESTADO')
                    ->label('Estado')
                    ->colors([
                        'success' => 'A',
                        'danger' => 'I',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'A' => 'Activo',
                        'I' => 'Inactivo',
                        default => $state,
                    }),
            ])
            ->defaultSort('FECHA_REGISTRO', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('ESTADO')
                    ->label('Estado')
                    ->options([
                        'A' => 'Activo',
                        'I' => 'Inactivo',
                    ]),
                
                Tables\Filters\SelectFilter::make('AREA')
                    ->label('Área')
                    ->options(function () {
                        return MaeAreas::pluck('DES_AREAS', 'DES_AREAS')->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePlaPersonalSalidas::route('/'),
        ];
    }
}