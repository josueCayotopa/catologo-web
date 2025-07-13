<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogoWebResource\Pages;
use App\Models\CatalogoWeb;
use App\Models\MaeSucursal;
use App\Models\MaeEmpresa;
use App\Models\CveEspecialidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CatalogoWebResource extends Resource
{
    protected static ?string $model = CatalogoWeb::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Catálogo Web';
    protected static ?string $modelLabel = 'Servicio';
    protected static ?string $pluralModelLabel = 'Servicios del Catálogo';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Información Básica')
                ->schema([
                    Grid::make(2)->schema([


                        Select::make('COD_EMPRESA')
                            ->label('Empresa')
                            ->required()
                            ->options(function () {
                                return MaeEmpresa::where('IND_BAJA', 'N')
                                    ->pluck('DES_RAZON_SOCIAL', 'COD_EMPRESA');
                            })
                            ->default('0001')
                            ->searchable(),
                        Select::make('COD_SUCURSAL')
                            ->label('Sucursal')
                            ->required()
                            ->options(function () {
                                return MaeSucursal::where('IND_BAJA', 'N')
                                    ->pluck('NOM_SUCURSAL', 'COD_SUCURSAL');
                            })
                            ->default('004')
                            ->searchable(),
                    ]),

                    TextInput::make('DES_ARTICULO')
                        ->label('Nombre del Servicio')
                        ->required()
                        ->maxLength(200),

                    Textarea::make('DES_CORTA')
                        ->label('Descripción Corta')
                        ->maxLength(500)
                        ->rows(3),

                    Textarea::make('META_DESCRIPCION')
                        ->label('Descripción Detallada')
                        ->maxLength(1000)
                        ->rows(4),
                ]),

            Section::make('Categorización')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('CATEGORIA')
                            ->label('Categoría Principal')
                            ->required()
                            ->options([
                                'CONSULTA' => 'Consultas Médicas',
                                'LABORATORIO' => 'Análisis de Laboratorio',
                                'IMAGEN' => 'Estudios de Imagen',
                                'PROCEDIMIENTO' => 'Procedimientos',
                                'EMERGENCIA' => 'Emergencias',
                                'CIRUGIA' => 'Cirugías',
                                'PAQUETE' => 'Paquetes Médicos'
                            ])
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('SUBCATEGORIA', null)),

                        Select::make('SUBCATEGORIA')
                            ->label('Subcategoría')
                            ->options(function (callable $get) {
                                $categoria = $get('CATEGORIA');
                                return match($categoria) {
                                    'LABORATORIO' => [
                                        'HEMATOLOGIA' => 'Hematología',
                                        'BIOQUIMICA' => 'Bioquímica',
                                        'MICROBIOLOGIA' => 'Microbiología',
                                        'INMUNOLOGIA' => 'Inmunología',
                                        'HORMONAS' => 'Hormonas',
                                        'ORINA' => 'Examen de Orina',
                                        'HECES' => 'Examen de Heces',
                                        'GENETICA' => 'Genética',
                                        'TOXICOLOGIA' => 'Toxicología'
                                    ],
                                    'IMAGEN' => [
                                        'RADIOGRAFIA' => 'Radiografía',
                                        'ECOGRAFIA' => 'Ecografía',
                                        'TOMOGRAFIA' => 'Tomografía',
                                        'RESONANCIA' => 'Resonancia Magnética',
                                        'MAMOGRAFIA' => 'Mamografía',
                                        'DENSITOMETRIA' => 'Densitometría',
                                        'ENDOSCOPIA' => 'Endoscopia'
                                    ],
                                    'CONSULTA' => [
                                        'MEDICINA_GENERAL' => 'Medicina General',
                                        'PEDIATRIA' => 'Pediatría',
                                        'GINECOLOGIA' => 'Ginecología',
                                        'CARDIOLOGIA' => 'Cardiología',
                                        'NEUROLOGIA' => 'Neurología',
                                        'TRAUMATOLOGIA' => 'Traumatología',
                                        'DERMATOLOGIA' => 'Dermatología'
                                    ],
                                    'PAQUETE' => [
                                        'CHEQUEO_BASICO' => 'Chequeo Básico',
                                        'CHEQUEO_COMPLETO' => 'Chequeo Completo',
                                        'CHEQUEO_EJECUTIVO' => 'Chequeo Ejecutivo',
                                        'CHEQUEO_DEPORTIVO' => 'Chequeo Deportivo'
                                    ],
                                    default => []
                                };
                            })
                            ->required()
                            ->reactive(),

                        Select::make('COD_ESPECIALIDAD')
                            ->label('Especialidad Médica')
                            ->options(function () {
                                return CveEspecialidad::where('TIPO_ESTADO', 'ACT')
                                    ->pluck('DES_ESPECIALIDAD', 'COD_ESPECIALIDAD');
                            })
                            ->searchable(),
                    ]),

                ]),

            Section::make('Precios y Promociones')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('PRECIO_MOSTRAR')
                            ->label('Precio Regular')
                            ->required()
                            ->numeric()
                            ->step(0.01)
                            ->prefix('S/.'),

                        TextInput::make('PRECIO_PROMOCION')
                            ->label('Precio Promocional')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('S/.')
                            ->visible(fn (callable $get) => $get('IND_PROMOCION')),

                        Select::make('MONEDA')
                            ->label('Moneda')
                            ->options([
                                'PEN' => 'Soles (S/.)',
                                'USD' => 'Dólares ($)',
                                'EUR' => 'Euros (€)'
                            ])
                            ->default('PEN'),
                    ]),

                    Grid::make(2)->schema([
                        Toggle::make('IND_PROMOCION')
                            ->label('¿Está en Promoción?')
                            ->reactive(),

                        Toggle::make('IND_DESTACADO')
                            ->label('¿Es Destacado?'),
                    ]),

                    Grid::make(2)->schema([
                        DatePicker::make('FECHA_INICIO_PROMO')
                            ->label('Inicio de Promoción')
                            ->visible(fn (callable $get) => $get('IND_PROMOCION')),

                        DatePicker::make('FECHA_FIN_PROMO')
                            ->label('Fin de Promoción')
                            ->visible(fn (callable $get) => $get('IND_PROMOCION')),
                    ]),
                ]),

            Section::make('Configuración del Servicio')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('DURACION_ESTIMADA')
                            ->label('Duración Estimada')
                            ->maxLength(50)
                            ->default('30 min'),

                        Toggle::make('REQUIERE_CITA')
                            ->label('¿Requiere Cita Previa?')
                            ->default(true),

                        Toggle::make('DISPONIBLE')
                            ->label('¿Está Disponible?')
                            ->default(true),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('HORARIO_DISPONIBLE')
                            ->label('Horario Disponible')
                            ->maxLength(100)
                            ->placeholder('Ej: Lunes a Viernes 8:00-18:00'),

                        TagsInput::make('DIAS_DISPONIBLE')
                            ->label('Días Disponibles')
                            ->suggestions(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])
                            ->separator(','), // Asegúrate de que use comas como separador

                    ]),

                    TextInput::make('ORDEN_MOSTRAR')
                        ->label('Orden de Visualización')
                        ->numeric()
                        ->default(999),
                ]),

            // Campos específicos según categoría
            Section::make('Configuración Específica')
                ->schema([
                    // Campos para LABORATORIO
                    Grid::make(2)->schema([
                        Toggle::make('AYUNO_REQUERIDO')
                            ->label('¿Requiere Ayuno?')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'LABORATORIO'),

                        TextInput::make('TIEMPO_ENTREGA')
                            ->label('Tiempo de Entrega')
                            ->maxLength(50)
                            ->placeholder('Ej: 24-48 horas')
                            ->visible(fn (callable $get) => in_array($get('CATEGORIA'), ['LABORATORIO', 'IMAGEN'])),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('TIPO_MUESTRA')
                            ->label('Tipo de Muestra')
                            ->maxLength(100)
                            ->placeholder('Ej: Sangre, Orina, Saliva')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'LABORATORIO'),

                        Textarea::make('PREPARACION_PACIENTE')
                            ->label('Preparación del Paciente')
                            ->maxLength(500)
                            ->rows(3)
                            ->visible(fn (callable $get) => in_array($get('CATEGORIA'), ['LABORATORIO', 'IMAGEN'])),
                    ]),

                    // Campos para IMAGEN
                    Grid::make(2)->schema([
                        Toggle::make('REQUIERE_ORDEN_MEDICA')
                            ->label('¿Requiere Orden Médica?')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'IMAGEN'),

                        Toggle::make('USA_CONTRASTE')
                            ->label('¿Usa Contraste?')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'IMAGEN'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('RESTRICCIONES_EDAD')
                            ->label('Restricciones de Edad')
                            ->maxLength(100)
                            ->placeholder('Ej: Mayores de 18 años')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'IMAGEN'),

                        TextInput::make('RESTRICCIONES_GENERO')
                            ->label('Restricciones de Género')
                            ->maxLength(50)
                            ->placeholder('Ej: Solo mujeres')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'IMAGEN'),
                    ]),

                    // Campos para CONSULTA
                    Grid::make(2)->schema([
                        Select::make('MODALIDAD_CONSULTA')
                            ->label('Modalidad de Consulta')
                            ->options([
                                'PRESENCIAL' => 'Presencial',
                                'VIRTUAL' => 'Virtual',
                                'AMBAS' => 'Presencial y Virtual'
                            ])
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'CONSULTA'),

                        TagsInput::make('PROCEDIMIENTOS_INCLUIDOS')
                            ->label('Procedimientos Incluidos')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'CONSULTA'),
                    ]),

                    // Campos para PAQUETES
                    Repeater::make('SERVICIOS_INCLUIDOS')
                        ->label('Servicios Incluidos en el Paquete')
                        ->schema([
                            TextInput::make('servicio')
                                ->label('Nombre del Servicio')
                                ->required(),
                            TextInput::make('precio_individual')
                                ->label('Precio Individual')
                                ->numeric()
                                ->prefix('S/.'),
                        ])
                        ->visible(fn (callable $get) => $get('CATEGORIA') === 'PAQUETE')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['servicio'] ?? null),

                    Grid::make(2)->schema([
                        TextInput::make('DESCUENTO_PAQUETE')
                            ->label('Descuento del Paquete (%)')
                            ->numeric()
                            ->suffix('%')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'PAQUETE'),

                        TextInput::make('AHORRO_TOTAL')
                            ->label('Ahorro Total')
                            ->numeric()
                            ->prefix('S/.')
                            ->visible(fn (callable $get) => $get('CATEGORIA') === 'PAQUETE'),
                    ]),
                ]),

            Section::make('Multimedia y SEO')
                ->schema([
                    FileUpload::make('IMAGEN_URL')
                        ->label('Imagen del Servicio')
                        ->image()
                        ->directory('servicios')
                        ->maxSize(2048),

                    // TagsInput::make('PALABRAS_CLAVE')
                    //     ->label('Palabras Clave (SEO)')
                    //     ->placeholder('Agregar palabras clave separadas por comas'),

                    Grid::make(2)->schema([
                        TextInput::make('STOCK_DISPONIBLE')
                            ->label('Stock Disponible')
                            ->numeric()
                            ->default(999)
                            ->visible(fn (callable $get) => in_array($get('CATEGORIA'), ['LABORATORIO', 'IMAGEN', 'PROCEDIMIENTO'])),

                        Select::make('ESTADO')
                            ->label('Estado')
                            ->options([
                                'A' => 'Activo',
                                'I' => 'Inactivo',
                                'P' => 'Pendiente'
                            ])
                            ->default('A')
                            ->required(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                ImageColumn::make('IMAGEN_URL')
                    ->label('Imagen')
                    ->circular()
                    ->size(40),

                TextColumn::make('DES_ARTICULO')
                    ->label('Servicio')
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                BadgeColumn::make('CATEGORIA')
                    ->label('Categoría')
                    ->colors([
                        'success' => 'CONSULTA',
                        'warning' => 'LABORATORIO',
                        'info' => 'IMAGEN',
                        'danger' => 'PROCEDIMIENTO',
                        'secondary' => 'EMERGENCIA',
                        'primary' => 'PAQUETE'
                    ]),

                BadgeColumn::make('SUBCATEGORIA')
                    ->label('Subcategoría')
                    ->colors([
                        'success' => static fn ($state): bool => str_contains($state, 'MEDICINA'),
                        'warning' => static fn ($state): bool => str_contains($state, 'HEMATOLOGIA'),
                        'info' => static fn ($state): bool => str_contains($state, 'RADIOGRAFIA'),
                    ])
                    ->sortable(),

                TextColumn::make('sucursal.NOM_SUCURSAL')
                    ->label('Sucursal')
                    ->sortable()
                    ->limit(20)
                    ->toggleable(),

                TextColumn::make('PRECIO_MOSTRAR')
                    ->label('Precio')
                    ->money('PEN')
                    ->sortable(),

                TextColumn::make('PRECIO_PROMOCION')
                    ->label('Precio Promo')
                    ->money('PEN')
                    ->toggleable()
                    ->placeholder('Sin promoción'),

                BooleanColumn::make('IND_PROMOCION')
                    ->label('Promoción')
                    ->trueIcon('heroicon-o-fire')
                    ->falseIcon('heroicon-o-x-mark'),

                BooleanColumn::make('IND_DESTACADO')
                    ->label('Destacado')
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-x-mark'),

                BooleanColumn::make('DISPONIBLE')
                    ->label('Disponible')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                BadgeColumn::make('ESTADO')
                    ->label('Estado')
                    ->colors([
                        'success' => 'A',
                        'danger' => 'I',
                        'warning' => 'P'
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'A' => 'Activo',
                        'I' => 'Inactivo',
                        'P' => 'Pendiente',
                        default => $state,
                    }),

                TextColumn::make('ORDEN_MOSTRAR')
                    ->label('Orden')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('CATEGORIA')
                    ->label('Categoría')
                    ->options([
                        'CONSULTA' => 'Consultas Médicas',
                        'LABORATORIO' => 'Análisis de Laboratorio',
                        'IMAGEN' => 'Estudios de Imagen',
                        'PROCEDIMIENTO' => 'Procedimientos',
                        'EMERGENCIA' => 'Emergencias',
                        'CIRUGIA' => 'Cirugías',
                        'PAQUETE' => 'Paquetes Médicos'
                    ]),

                SelectFilter::make('SUBCATEGORIA')
                    ->label('Subcategoría')
                    ->options([
                        'HEMATOLOGIA' => 'Hematología',
                        'BIOQUIMICA' => 'Bioquímica',
                        'RADIOGRAFIA' => 'Radiografía',
                        'ECOGRAFIA' => 'Ecografía',
                        'MEDICINA_GENERAL' => 'Medicina General',
                        'PEDIATRIA' => 'Pediatría'
                    ]),

                SelectFilter::make('COD_SUCURSAL')
                    ->label('Sucursal')
                    ->relationship('sucursal', 'NOM_SUCURSAL'),

                SelectFilter::make('COD_ESPECIALIDAD')
                    ->label('Especialidad')
                    ->relationship('especialidad', 'DES_ESPECIALIDAD'),

                Filter::make('promociones')
                    ->label('Solo Promociones')
                    ->query(fn (Builder $query): Builder => $query->where('IND_PROMOCION', 'S')),

                Filter::make('destacados')
                    ->label('Solo Destacados')
                    ->query(fn (Builder $query): Builder => $query->where('IND_DESTACADO', 'S')),

                Filter::make('disponibles')
                    ->label('Solo Disponibles')
                    ->query(fn (Builder $query): Builder => $query->where('DISPONIBLE', 'S'))
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    BulkAction::make('activar')
                        ->label('Activar Servicios')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['ESTADO' => 'A', 'DISPONIBLE' => 'S']);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('desactivar')
                        ->label('Desactivar Servicios')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['DISPONIBLE' => 'N']);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('destacar')
                        ->label('Marcar como Destacados')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['IND_DESTACADO' => 'S']);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('promocionar')
                        ->label('Activar Promoción')
                        ->icon('heroicon-o-fire')
                        ->color('info')
                        ->form([
                            TextInput::make('precio_promocion')
                                ->label('Precio Promocional')
                                ->required()
                                ->numeric()
                                ->step(0.01)
                                ->prefix('S/.'),
                            DatePicker::make('fecha_inicio')
                                ->label('Fecha de Inicio')
                                ->required(),
                            DatePicker::make('fecha_fin')
                                ->label('Fecha de Fin')
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update([
                                    'IND_PROMOCION' => 'S',
                                    'PRECIO_PROMOCION' => $data['precio_promocion'],
                                    'FECHA_INICIO_PROMO' => $data['fecha_inicio'],
                                    'FECHA_FIN_PROMO' => $data['fecha_fin'],
                                ]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('ORDEN_MOSTRAR', 'asc');
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
            'index' => Pages\ListCatalogoWebs::route('/'),
            'create' => Pages\CreateCatalogoWeb::route('/create'),

            'edit' => Pages\EditCatalogoWeb::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('ESTADO', 'A')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }
}
