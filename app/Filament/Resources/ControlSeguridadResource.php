<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlSeguridadResource\Pages;
use App\Models\PlaPersonalSalidaFecha;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class ControlSeguridadResource extends Resource
{
    protected static ?string $model = PlaPersonalSalidaFecha::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Control de Seguridad';
    protected static ?string $modelLabel = 'Control de Acceso';
    protected static ?string $pluralModelLabel = 'Control de Acceso';
    protected static ?string $navigationGroup = 'Seguridad';

    // Todos los usuarios pueden acceder
    public static function canAccess(): bool
    {
        return true;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                PlaPersonalSalidaFecha::query()
                    ->with(['personal', 'usuarioCreador'])
                    ->whereIn('ESTADO_PERMISO', [
                        PlaPersonalSalidaFecha::ESTADO_APROBADO,
                        PlaPersonalSalidaFecha::ESTADO_EN_SALIDA
                    ])
                    ->whereDate('FECHA_SALIDA', '>=', today()->subDays(1))
            )
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->personal->nombre_completo ?? 'Usuario') . '&color=7F9CF5&background=EBF4FF')
                    ->size(50),

                Tables\Columns\TextColumn::make('personal.nombre_completo')
                    ->label('Personal')
                    ->searchable(['NOMBRES', 'APELLIDOS'])
                    ->sortable()
                    ->weight('bold')
                    ->size('lg')
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('personal.AREA')
                    ->label('Área')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('FECHA_SALIDA')
                    ->label('Programado')
                    ->dateTime('H:i')
                    ->description(fn ($record) => $record->FECHA_SALIDA->format('d/m/Y'))
                    ->weight('bold')
                    ->color('warning'),

                Tables\Columns\TextColumn::make('FECHA_SALIDA_REAL')
                    ->label('Salida Real')
                    ->dateTime('H:i')
                    ->placeholder('⏳ Pendiente')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->weight('bold')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-clock')
                    ->description(fn ($record) => $record->FECHA_SALIDA_REAL?->format('d/m/Y')),

                Tables\Columns\TextColumn::make('FECHA_RETORNO_REAL')
                    ->label('Entrada Real')
                    ->dateTime('H:i')
                    ->placeholder('⏳ Pendiente')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->weight('bold')
                    ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-clock')
                    ->description(fn ($record) => $record->FECHA_RETORNO_REAL?->format('d/m/Y')),

                Tables\Columns\BadgeColumn::make('ESTADO_PERMISO')
                    ->label('Estado')
                    ->colors([
                        'success' => PlaPersonalSalidaFecha::ESTADO_APROBADO,
                        'info' => PlaPersonalSalidaFecha::ESTADO_EN_SALIDA,
                    ])
                    ->formatStateUsing(fn ($record) => $record->estado_label)
                    ->size('lg'),

                Tables\Columns\TextColumn::make('MOTIVO_SALIDA')
                    ->label('Motivo')
                    ->limit(25)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 25 ? $state : null;
                    })
                    ->wrap(),

                Tables\Columns\TextColumn::make('tiempo_transcurrido')
                    ->label('Tiempo Fuera')
                    ->getStateUsing(function ($record) {
                        if ($record->FECHA_SALIDA_REAL && !$record->FECHA_RETORNO_REAL) {
                            return $record->FECHA_SALIDA_REAL->diffForHumans(now(), true);
                        }
                        return '-';
                    })
                    ->color('info')
                    ->weight('bold')
                    ->icon('heroicon-o-clock'),
            ])
            ->defaultSort('FECHA_SALIDA', 'asc')
            ->filters([
                Tables\Filters\Filter::make('solo_pendientes_salida')
                    ->label('🟡 Pendientes de Salida')
                    ->query(fn (Builder $query): Builder => 
                        $query->where('ESTADO_PERMISO', PlaPersonalSalidaFecha::ESTADO_APROBADO)
                    )
                    ->default(),

                Tables\Filters\Filter::make('solo_pendientes_entrada')
                    ->label('🔵 Pendientes de Entrada')
                    ->query(fn (Builder $query): Builder => 
                        $query->where('ESTADO_PERMISO', PlaPersonalSalidaFecha::ESTADO_EN_SALIDA)
                    ),

                Tables\Filters\Filter::make('solo_hoy')
                    ->label('📅 Solo Hoy')
                    ->query(fn (Builder $query): Builder => 
                        $query->whereDate('FECHA_SALIDA', today())
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('marcar_salida')
                    ->label('🚪 SALIDA')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('info')
                    ->size('xl')
                    ->button()
                    ->visible(fn ($record) => $record->puedeMarcarSalida())
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Salida')
                    ->modalDescription(fn ($record) => 
                        "👤 Personal: {$record->personal->nombre_completo}\n" .
                        "🏢 Área: {$record->personal->AREA}\n" .
                        "📝 Motivo: {$record->MOTIVO_SALIDA}\n" .
                        "⏰ Hora programada: {$record->FECHA_SALIDA->format('H:i')}\n\n" .
                        "¿Confirmar la SALIDA ahora a las " . now()->format('H:i') . "?"
                    )
                    ->modalSubmitActionLabel('✅ Sí, Marcar Salida')
                    ->action(function ($record) {
                        $record->update([
                            'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_EN_SALIDA,
                            'FECHA_SALIDA_REAL' => now(),
                            'USUARIO_SEGURIDAD_SALIDA' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('🚪 SALIDA REGISTRADA')
                            ->body("👤 {$record->personal->nombre_completo}\n⏰ " . now()->format('H:i:s'))
                            ->success()
                            ->duration(5000)
                            ->send();
                    }),

                Tables\Actions\Action::make('marcar_entrada')
                    ->label('🏠 ENTRADA')
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->color('success')
                    ->size('xl')
                    ->button()
                    ->visible(fn ($record) => $record->puedeMarcarEntrada())
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Entrada')
                    ->modalDescription(fn ($record) => 
                        "👤 Personal: {$record->personal->nombre_completo}\n" .
                        "🚪 Salió a las: {$record->FECHA_SALIDA_REAL->format('H:i')}\n" .
                        "⏱️ Tiempo fuera: " . $record->FECHA_SALIDA_REAL->diffForHumans(now(), true) . "\n\n" .
                        "¿Confirmar la ENTRADA ahora a las " . now()->format('H:i') . "?"
                    )
                    ->modalSubmitActionLabel('🏠 Sí, Marcar Entrada')
                    ->action(function ($record) {
                        $tiempoFuera = $record->FECHA_SALIDA_REAL->diffForHumans(now(), true);
                        
                        $record->update([
                            'ESTADO_PERMISO' => PlaPersonalSalidaFecha::ESTADO_COMPLETADO,
                            'FECHA_RETORNO_REAL' => now(),
                            'USUARIO_SEGURIDAD_ENTRADA' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('🏠 ENTRADA REGISTRADA')
                            ->body("👤 {$record->personal->nombre_completo}\n⏰ " . now()->format('H:i:s') . "\n⏱️ Tiempo fuera: {$tiempoFuera}")
                            ->success()
                            ->duration(5000)
                            ->send();
                    }),
            ])
            ->bulkActions([])
            ->recordUrl(null)
            ->striped()
            ->poll('30s')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControlSeguridads::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
