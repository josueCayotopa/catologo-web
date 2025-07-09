<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaPersonalSalidaFechaResource\Pages;
use App\Models\PlaPersonalSalidaFecha;
use App\Models\PlaPersonalSalida;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class PlaPersonalSalidaFechaResource extends Resource
{
    protected static ?string $model = PlaPersonalSalidaFecha::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Control de Permisos';
    protected static ?string $modelLabel = 'Permiso de Salida';
    protected static ?string $pluralModelLabel = 'Permisos de Salida';


    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos del Permiso')
                ->schema([
                    Forms\Components\Select::make('PERSONAL_ID')
                        ->label('Personal')
                        ->options(function () {
                            return PlaPersonalSalida::where('ESTADO', 'A')
                                ->get()
                                ->mapWithKeys(function ($personal) {
                                    return [$personal->ID => $personal->nombre_completo . ' - ' . $personal->AREA];
                                });
                        })
                        ->searchable()
                        ->required()
                        ->preload(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DateTimePicker::make('FECHA_SALIDA')
                            ->label('Fecha y Hora de Salida Programada')
                            ->required()
                            ->minDate(now())
                            ->seconds(true),

                        Forms\Components\DateTimePicker::make('FECHA_RETORNO')
                            ->label('Fecha y Hora de Retorno Programada')
                            ->required()
                            ->after('FECHA_SALIDA')
                            ->seconds(true),
                    ]),

                    Forms\Components\Textarea::make('MOTIVO_SALIDA')
                        ->label('Motivo de la Salida')
                        ->required()
                        ->maxLength(255)
                        ->rows(3),

                    Forms\Components\Textarea::make('OBSERVACION')
                        ->label('Observaciones Adicionales')
                        ->maxLength(255)
                        ->rows(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('personal.nombre_completo')
                    ->label('Personal')
                    ->searchable(['NOMBRES', 'APELLIDOS'])
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('personal.AREA')
                    ->label('Área')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('FECHA_SALIDA')
                    ->label('Salida Programada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('FECHA_RETORNO')
                    ->label('Retorno Programado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('ESTADO_PERMISO')
                    ->label('Estado')
                    ->colors([
                        'warning' => PlaPersonalSalidaFecha::ESTADO_PENDIENTE,
                        'success' => PlaPersonalSalidaFecha::ESTADO_APROBADO,
                        'danger' => PlaPersonalSalidaFecha::ESTADO_RECHAZADO,
                        'info' => PlaPersonalSalidaFecha::ESTADO_EN_SALIDA,
                        'success' => PlaPersonalSalidaFecha::ESTADO_COMPLETADO,
                    ])
                    ->formatStateUsing(fn ($record) => $record->estado_label),

                Tables\Columns\TextColumn::make('FECHA_SALIDA_REAL')
                    ->label('Salida Real')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Pendiente')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->weight(fn ($state) => $state ? 'bold' : 'normal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('FECHA_RETORNO_REAL')
                    ->label('Entrada Real')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Pendiente')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->weight(fn ($state) => $state ? 'bold' : 'normal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('MOTIVO_SALIDA')
                    ->label('Motivo')
                    ->limit(25)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('usuarioCreador.name')
                    ->label('Solicitado por')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('CREATED_AT', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('ESTADO_PERMISO')
                    ->label('Estado')
                    ->options([
                        PlaPersonalSalidaFecha::ESTADO_PENDIENTE => 'Pendiente',
                        PlaPersonalSalidaFecha::ESTADO_APROBADO => 'Aprobado',
                        PlaPersonalSalidaFecha::ESTADO_RECHAZADO => 'Rechazado',
                        PlaPersonalSalidaFecha::ESTADO_EN_SALIDA => 'En Salida',
                        PlaPersonalSalidaFecha::ESTADO_COMPLETADO => 'Completado',
                    ]),

                Tables\Filters\Filter::make('pendientes_aprobacion')
                    ->label('Pendientes de Aprobación')
                    ->query(fn (Builder $query): Builder => 
                        $query->where('ESTADO_PERMISO', PlaPersonalSalidaFecha::ESTADO_PENDIENTE)
                    ),

                Tables\Filters\Filter::make('fecha_hoy')
                    ->label('Solo Hoy')
                    ->query(fn (Builder $query): Builder => 
                        $query->whereDate('FECHA_SALIDA', today())
                    ),
            ])
            ->actions([
                // BOTONES DE APROBACIÓN - Visibles para TODOS los usuarios
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('aprobar')
                        ->label('✅ Aprobar')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->puedeAprobar()) // Sin restricción de permisos
                        ->form([
                            Forms\Components\Textarea::make('observacion_aprobacion')
                                ->label('Observaciones de Aprobación')
                                ->maxLength(500),
                            Forms\Components\TextInput::make('cargo_aprueba')
                                ->label('Cargo del Aprobador')
                                ->default(fn () => auth()->user()->name)
                                ->required(),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_APROBADO,
                                'IND_AUTORIZA' => 'S',
                                'USUARIO_APRUEBA' => auth()->id(),
                                'CARGO_APRUEBA' => $data['cargo_aprueba'],
                                'FECHA_APROBACION' => now(),
                                'OBSERVACION_APROBACION' => $data['observacion_aprobacion'] ?? null,
                            ]);

                            Notification::make()
                                ->title('✅ Permiso Aprobado')
                                ->body("Aprobado por: " . auth()->user()->name)
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('rechazar')
                        ->label('❌ Rechazar')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn ($record) => $record->puedeAprobar()) // Sin restricción de permisos
                        ->form([
                            Forms\Components\Textarea::make('observacion_rechazo')
                                ->label('Motivo del Rechazo')
                                ->required()
                                ->maxLength(500),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_RECHAZADO,
                                'IND_AUTORIZA' => 'R',
                                'USUARIO_APRUEBA' => auth()->id(),
                                'CARGO_APRUEBA' => auth()->user()->name,
                                'FECHA_APROBACION' => now(),
                                'OBSERVACION_APROBACION' => $data['observacion_rechazo'],
                            ]);

                            Notification::make()
                                ->title('❌ Permiso Rechazado')
                                ->body("Rechazado por: " . auth()->user()->name)
                                ->warning()
                                ->send();
                        }),
                ])
                ->label('🔍 Aprobación')
                ->icon('heroicon-o-user-group')
                ->color('warning')
                ->visible(fn ($record) => $record->puedeAprobar()), // Mostrar grupo solo si hay permisos pendientes

                // BOTONES DE CONTROL DE SALIDA - Visibles para TODOS
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('marcar_salida')
                        ->label('🚪 Marcar Salida')
                        ->icon('heroicon-o-arrow-right-on-rectangle')
                        ->color('info')
                        ->size('lg')
                        ->visible(fn ($record) => $record->puedeMarcarSalida())
                        ->requiresConfirmation()
                        ->modalHeading('Confirmar Salida del Personal')
                        ->modalDescription(fn ($record) => 
                            "👤 Personal: {$record->personal->nombre_completo}\n" .
                            "🏢 Área: {$record->personal->AREA}\n" .
                            "📝 Motivo: {$record->MOTIVO_SALIDA}\n\n" .
                            "¿Confirmar la SALIDA ahora?"
                        )
                        ->modalSubmitActionLabel('✅ Sí, Marcar Salida')
                        ->action(function ($record) {
                            $record->update([
                                'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_EN_SALIDA,
                                'FECHA_SALIDA_REAL' => now(),
                                'USUARIO_SEGURIDAD_SALIDA' => auth()->id(),
                            ]);

                            Notification::make()
                                ->title('🚪 Salida Registrada')
                                ->body("👤 {$record->personal->nombre_completo} - ⏰ " . now()->format('H:i'))
                                ->success()
                                ->duration(5000)
                                ->send();
                        }),

                    Tables\Actions\Action::make('marcar_entrada')
                        ->label('🏠 Marcar Entrada')
                        ->icon('heroicon-o-arrow-left-on-rectangle')
                        ->color('success')
                        ->size('lg')
                        ->visible(fn ($record) => $record->puedeMarcarEntrada())
                        ->requiresConfirmation()
                        ->modalHeading('Confirmar Entrada del Personal')
                        ->modalDescription(fn ($record) => 
                            "👤 Personal: {$record->personal->nombre_completo}\n" .
                            "🚪 Salió a las: {$record->FECHA_SALIDA_REAL->format('H:i')}\n" .
                            "⏱️ Tiempo fuera: " . $record->FECHA_SALIDA_REAL->diffForHumans(now(), true) . "\n\n" .
                            "¿Confirmar la ENTRADA ahora?"
                        )
                        ->modalSubmitActionLabel('✅ Sí, Marcar Entrada')
                        ->action(function ($record) {
                            $tiempoFuera = $record->FECHA_SALIDA_REAL->diffForHumans(now(), true);
                            
                            $record->update([
                                'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_COMPLETADO,
                                'FECHA_RETORNO_REAL' => now(),
                                'USUARIO_SEGURIDAD_ENTRADA' => auth()->id(),
                            ]);

                            Notification::make()
                                ->title('🏠 Entrada Registrada')
                                ->body("👤 {$record->personal->nombre_completo} - ⏰ " . now()->format('H:i') . "\n⏱️ Tiempo fuera: {$tiempoFuera}")
                                ->success()
                                ->duration(5000)
                                ->send();
                        }),
                ])
                ->label('🛡️ Control de Acceso')
                ->icon('heroicon-o-shield-check')
                ->size('lg')
                ->color('primary')
                ->visible(fn ($record) => $record->puedeMarcarSalida() || $record->puedeMarcarEntrada()),

                // BOTONES GENERALES
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Acción masiva para aprobar múltiples permisos - TODOS pueden usarla
                    Tables\Actions\BulkAction::make('aprobar_masivo')
                        ->label('✅ Aprobar Seleccionados')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Aprobar Permisos Masivamente')
                        ->modalDescription('¿Estás seguro de aprobar todos los permisos seleccionados?')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->puedeAprobar()) {
                                    $record->update([
                                        'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_APROBADO,
                                        'IND_AUTORIZA' => 'S',
                                        'USUARIO_APRUEBA' => auth()->id(),
                                        'CARGO_APRUEBA' => auth()->user()->name,
                                        'FECHA_APROBACION' => now(),
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("✅ {$count} Permisos Aprobados")
                                ->body("Aprobados por: " . auth()->user()->name)
                                ->success()
                                ->send();
                        }),

                    // Acción masiva para marcar salidas - Solo seguridad
                    Tables\Actions\BulkAction::make('marcar_salidas_masivo')
                        ->label('🚪 Marcar Salidas Seleccionadas')
                        ->icon('heroicon-o-arrow-right-on-rectangle')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Marcar Salidas Masivamente')
                        ->modalDescription('¿Estás seguro de marcar la salida de todos los permisos seleccionados?')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->puedeMarcarSalida()) {
                                    $record->update([
                                        'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_EN_SALIDA,
                                        'FECHA_SALIDA_REAL' => now(),
                                        'USUARIO_SEGURIDAD_SALIDA' => auth()->id(),
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("🚪 {$count} Salidas Registradas")
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete_permisos')),
                ]),
            ])
            ->recordUrl(null)
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePlaPersonalSalidaFechas::route('/'),
        ];
    }

    // TODOS pueden ver todos los permisos
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
        // Removido el filtro por usuario, ahora todos ven todos los permisos
    }
}
