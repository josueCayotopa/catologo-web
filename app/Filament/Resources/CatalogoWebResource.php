<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogoWebResource\Pages;
use App\Filament\Resources\CatalogoWebResource\RelationManagers;
use App\Models\CatalogoWeb;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Fieldset;

class CatalogoWebResource extends Resource
{
    protected static ?string $model = CatalogoWeb::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Catálogo Web';
    protected static ?string $modelLabel = 'Producto del Catálogo';
    protected static ?string $pluralModelLabel = 'Productos del Catálogo';
    protected static ?string $navigationGroup = 'Gestión de Productos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Información del Producto')
                    ->tabs([
                        // TAB 1: INFORMACIÓN BÁSICA
                        Tabs\Tab::make('Información Básica')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Datos Principales')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('COD_EMPRESA')
                                                    ->label('Empresa')
                                                    ->options([
                                                        '0001' => 'Clínica La Luz'
                                                    ])
                                                    ->default('0001')
                                                    ->required(),
                                                Forms\Components\Select::make('COD_SUCURSAL')
                                                    ->label('Sucursal')
                                                    ->options(function () {
                                                        return DB::table('MAE_SUCURSAL')
                                                            ->where('IND_BAJA', 'N')   
                                                            ->pluck('NOM_SUCURSAL', 'COD_SUCURSAL')
                                                            ->toArray();
                                                    })
                                                    ->searchable()
                                                    ->required(),
                                            ]),
                                        Forms\Components\TextInput::make('DES_ARTICULO')
                                            ->label('Nombre del Producto/Servicio')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('DES_CORTA')
                                            ->label('Descripción Corta')
                                            ->maxLength(500)
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Clasificación y Categorización')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('COD_ESPECIALIDAD')
                                                    ->label('Especialidad')
                                                    ->options(function () {
                                                        return DB::table('CVE_ESPECIALIDAD')
                                                            ->where('TIPO_ESTADO', 'ACT')
                                                            ->pluck('DES_ESPECIALIDAD', 'COD_ESPECIALIDAD')
                                                            ->toArray();
                                                    })
                                                    ->searchable()
                                                    ->nullable(),
                                                Forms\Components\Select::make('CATEGORIA')
                                                    ->label('Categoría')
                                                    ->options([
                                                        'CONSULTA' => 'Consultas Médicas',
                                                        'LABORATORIO' => 'Análisis de Laboratorio',
                                                        'IMAGEN' => 'Estudios de Imagen',
                                                        'PROCEDIMIENTO' => 'Procedimientos',
                                                        'EMERGENCIA' => 'Emergencias',
                                                        'CIRUGIA' => 'Cirugías',
                                                        'CERTIFICADO' => 'Certificados',
                                                        'PAQUETE' => 'Paquetes'
                                                    ])
                                                    ->searchable()
                                                    ->nullable(),
                                            ]),
                                        Forms\Components\Select::make('TIPO_SERVICIO')
                                            ->label('Tipo de Servicio')
                                            ->options([
                                                'Consulta Médica' => 'Consulta Médica',
                                                'Servicio Médico' => 'Servicio Médico',
                                                'Análisis' => 'Análisis',
                                                'Estudio' => 'Estudio',
                                                'Procedimiento' => 'Procedimiento',
                                                'Certificado' => 'Certificado',
                                                'Paquete' => 'Paquete',
                                                'Emergencia' => 'Emergencia'
                                            ])
                                            ->searchable()
                                            ->nullable(),
                                        Forms\Components\Textarea::make('PALABRAS_CLAVE')
                                            ->label('Palabras Clave para Búsqueda')
                                            ->helperText('Palabras separadas por espacios para mejorar la búsqueda')
                                            ->maxLength(500)
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // TAB 2: PRECIOS Y PROMOCIONES
                        Tabs\Tab::make('Precios y Promociones')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make('Configuración de Precios')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('PRECIO_MOSTRAR')
                                                    ->label('Precio Regular')
                                                    ->numeric()
                                                    ->prefix('S/.')
                                                    ->step(0.01)
                                                    ->required(),
                                                Forms\Components\Select::make('COD_MONEDA')
                                                    ->label('Moneda')
                                                    ->options([
                                                        'PEN' => 'Soles (PEN)',
                                                        'USD' => 'Dólares (USD)',
                                                        'EUR' => 'Euros (EUR)',
                                                    ])
                                                    ->default('PEN')
                                                    ->required(),
                                                Forms\Components\TextInput::make('PRECIO_PROMOCION')
                                                    ->label('Precio de Promoción')
                                                    ->numeric()
                                                    ->prefix('S/.')
                                                    ->step(0.01),
                                            ]),
                                    ]),

                                Section::make('Configuración de Promociones')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Toggle::make('IND_PROMOCION')
                                                    ->label('En Promoción')
                                                    ->helperText('Se mostrará con badge de promoción')
                                                    ->reactive(),
                                                Forms\Components\Toggle::make('IND_DESTACADO')
                                                    ->label('Producto Destacado')
                                                    ->helperText('Se mostrará con badge especial'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('FECHA_INICIO_PROMO')
                                                    ->label('Inicio de Promoción')
                                                    ->visible(fn (Forms\Get $get): bool => $get('IND_PROMOCION')),
                                                Forms\Components\DatePicker::make('FECHA_FIN_PROMO')
                                                    ->label('Fin de Promoción')
                                                    ->visible(fn (Forms\Get $get): bool => $get('IND_PROMOCION')),
                                            ]),
                                    ]),
                            ]),

                        // TAB 3: DISPONIBILIDAD Y CARACTERÍSTICAS
                        Tabs\Tab::make('Disponibilidad')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Section::make('Estado y Disponibilidad')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('ESTADO')
                                                    ->label('Estado')
                                                    ->options([
                                                        'A' => 'Activo',
                                                        'I' => 'Inactivo',
                                                    ])
                                                    ->default('A')
                                                    ->required(),
                                                Forms\Components\Select::make('DISPONIBLE')
                                                    ->label('Disponible')
                                                    ->options([
                                                        'S' => 'Sí',
                                                        'N' => 'No',
                                                    ])
                                                    ->default('S'),
                                                Forms\Components\Select::make('REQUIERE_CITA')
                                                    ->label('Requiere Cita')
                                                    ->options([
                                                        'S' => 'Sí',
                                                        'N' => 'No',
                                                    ])
                                                    ->default('S'),
                                            ]),
                                    ]),

                                Section::make('Características del Servicio')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('DURACION_ESTIMADA')
                                                    ->label('Duración Estimada')
                                                    ->placeholder('Ej: 30 min, 1 hora, 2 horas')
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('ORDEN_MOSTRAR')
                                                    ->label('Orden de Visualización')
                                                    ->numeric()
                                                    ->default(1)
                                                    ->helperText('Menor número = mayor prioridad'),
                                            ]),
                                        Forms\Components\TextInput::make('HORARIO_DISPONIBLE')
                                            ->label('Horario Disponible')
                                            ->placeholder('Ej: Lunes a Viernes 8:00-18:00')
                                            ->maxLength(200)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('DIAS_DISPONIBLE')
                                            ->label('Días Disponibles')
                                            ->multiple()
                                            ->options([
                                                'LUNES' => 'Lunes',
                                                'MARTES' => 'Martes',
                                                'MIERCOLES' => 'Miércoles',
                                                'JUEVES' => 'Jueves',
                                                'VIERNES' => 'Viernes',
                                                'SABADO' => 'Sábado',
                                                'DOMINGO' => 'Domingo',
                                            ])
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Control de Stock (Opcional)')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('STOCK_DISPONIBLE')
                                                    ->label('Stock Disponible')
                                                    ->numeric()
                                                    ->default(999)
                                                    ->helperText('999 = Sin límite'),
                                                Forms\Components\TextInput::make('STOCK_MINIMO')
                                                    ->label('Stock Mínimo')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),
                                    ]),
                            ]),

                        // TAB 4: IMAGEN Y SEO
                        Tabs\Tab::make('Imagen y SEO')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Imagen del Producto')
                                    ->schema([
                                        Forms\Components\FileUpload::make('IMAGEN_URL')
                                            ->label('Imagen del Producto')
                                            ->image()
                                            ->directory('productos')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                                '4:3',
                                                '16:9',
                                            ])
                                            ->maxSize(2048)
                                            ->helperText('Tamaño máximo: 2MB. Formatos: JPG, PNG, WebP')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Optimización SEO')
                                    ->schema([
                                        Forms\Components\TextInput::make('URL_AMIGABLE')
                                            ->label('URL Amigable')
                                            ->placeholder('ej: consulta-cardiologia-lima')
                                            ->maxLength(200)
                                            ->helperText('Solo letras, números y guiones')
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('META_DESCRIPCION')
                                            ->label('Meta Descripción')
                                            ->maxLength(300)
                                            ->rows(3)
                                            ->helperText('Descripción para motores de búsqueda (máx. 300 caracteres)')
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('META_KEYWORDS')
                                            ->label('Meta Keywords')
                                            ->maxLength(200)
                                            ->helperText('Palabras clave separadas por comas')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('IMAGEN_URL')
                    ->label('Imagen')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('COD_ARTICULO_SERV')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('DES_ARTICULO')
                    ->label('Producto/Servicio')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 40 ? $state : null;
                    })
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('sucursal_nombre')
                    ->label('Sucursal')
                    ->getStateUsing(function ($record) {
                        return DB::table('MAE_SUCURSAL')
                            ->where('COD_SUCURSAL', $record->COD_SUCURSAL)
                            ->value('NOM_SUCURSAL');
                    })
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('CATEGORIA')
                    ->label('Categoría')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CONSULTA' => 'success',
                        'LABORATORIO' => 'info',
                        'IMAGEN' => 'warning',
                        'PROCEDIMIENTO' => 'primary',
                        'EMERGENCIA' => 'danger',
                        'CIRUGIA' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'CONSULTA' => 'Consulta',
                        'LABORATORIO' => 'Laboratorio',
                        'IMAGEN' => 'Imagen',
                        'PROCEDIMIENTO' => 'Procedimiento',
                        'EMERGENCIA' => 'Emergencia',
                        'CIRUGIA' => 'Cirugía',
                        default => $state ?? 'Sin categoría',
                    }),
                Tables\Columns\TextColumn::make('especialidad_nombre')
                    ->label('Especialidad')
                    ->getStateUsing(function ($record) {
                        return DB::table('CVE_ESPECIALIDAD')
                            ->where('COD_ESPECIALIDAD', $record->COD_ESPECIALIDAD)
                            ->value('DES_ESPECIALIDAD');
                    })
                    ->badge()
                    ->color('success')
                    ->limit(20),
                Tables\Columns\TextColumn::make('PRECIO_MOSTRAR')
                    ->label('Precio')
                    ->money('PEN')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('PRECIO_PROMOCION')
                    ->label('Precio Promo')
                    ->money('PEN')
                    ->color('danger')
                    ->weight('bold')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('DISPONIBLE')
                    ->label('Disponible')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\IconColumn::make('IND_DESTACADO')
                    ->label('Destacado')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                Tables\Columns\IconColumn::make('IND_PROMOCION')
                    ->label('Promoción')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
                    ->falseIcon('heroicon-o-fire')
                    ->trueColor('danger')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('ESTADO')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A' => 'success',
                        'I' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'A' => 'Activo',
                        'I' => 'Inactivo',
                    }),
                Tables\Columns\TextColumn::make('DURACION_ESTIMADA')
                    ->label('Duración')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ORDEN_MOSTRAR')
                    ->label('Orden')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('FECHA_CREACION')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('COD_SUCURSAL')
                    ->label('Sucursal')
                    ->options(function () {
                        return DB::table('MAE_SUCURSAL')
                            ->where('IND_BAJA', 'N')
                            ->pluck('NOM_SUCURSAL', 'COD_SUCURSAL')
                            ->toArray();
                    })
                    ->multiple(),
                SelectFilter::make('COD_ESPECIALIDAD')
                    ->label('Especialidad')
                    ->options(function () {
                        return DB::table('CVE_ESPECIALIDAD')
                            ->where('TIPO_ESTADO', 'ACT')
                            ->pluck('DES_ESPECIALIDAD', 'COD_ESPECIALIDAD')
                            ->toArray();
                    })
                    ->multiple(),
                SelectFilter::make('CATEGORIA')
                    ->label('Categoría')
                    ->options([
                        'CONSULTA' => 'Consultas Médicas',
                        'LABORATORIO' => 'Análisis de Laboratorio',
                        'IMAGEN' => 'Estudios de Imagen',
                        'PROCEDIMIENTO' => 'Procedimientos',
                        'EMERGENCIA' => 'Emergencias',
                        'CIRUGIA' => 'Cirugías',
                        'CERTIFICADO' => 'Certificados',
                        'PAQUETE' => 'Paquetes'
                    ])
                    ->multiple(),
                SelectFilter::make('ESTADO')
                    ->label('Estado')
                    ->options([
                        'A' => 'Activo',
                        'I' => 'Inactivo',
                    ]),
                Filter::make('disponibles')
                    ->label('Solo Disponibles')
                    ->query(fn (Builder $query): Builder => $query->where('DISPONIBLE', 'S')),
                Filter::make('destacados')
                    ->label('Solo Destacados')
                    ->query(fn (Builder $query): Builder => $query->where('IND_DESTACADO', 'S')),
                Filter::make('promociones')
                    ->label('Solo Promociones')
                    ->query(fn (Builder $query): Builder => $query->where('IND_PROMOCION', 'S')),
                Filter::make('precio_rango')
                    ->form([
                        Forms\Components\TextInput::make('precio_desde')
                            ->label('Precio desde')
                            ->numeric()
                            ->prefix('S/.'),
                        Forms\Components\TextInput::make('precio_hasta')
                            ->label('Precio hasta')
                            ->numeric()
                            ->prefix('S/.'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['precio_desde'],
                                fn (Builder $query, $precio): Builder => $query->where('PRECIO_MOSTRAR', '>=', $precio),
                            )
                            ->when(
                                $data['precio_hasta'],
                                fn (Builder $query, $precio): Builder => $query->where('PRECIO_MOSTRAR', '<=', $precio),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('warning')
                    ->action(function ($record) {
                        $newRecord = $record->replicate();
                        $newRecord->COD_ARTICULO_SERV = null; // Se generará automáticamente
                        $newRecord->DES_ARTICULO = $record->DES_ARTICULO . ' (Copia)';
                        $newRecord->save();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activar')
                        ->label('Activar Seleccionados')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['ESTADO' => 'A']);
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('desactivar')
                        ->label('Desactivar Seleccionados')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['ESTADO' => 'I']);
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('destacar')
                        ->label('Marcar como Destacados')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['IND_DESTACADO' => 'S']);
                            });
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('promocionar')
                        ->label('Marcar en Promoción')
                        ->icon('heroicon-o-fire')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['IND_PROMOCION' => 'S']);
                            });
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('ORDEN_MOSTRAR', 'asc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto-refresh cada 30 segundos
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
