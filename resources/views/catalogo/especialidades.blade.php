@extends('layouts.app')

@section('title', 'Especialidades Médicas - ' . ($sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz'))

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 opacity-90"></div>
            <div class="absolute inset-0 bg-[url('/placeholder.svg?height=1080&width=1920&text=Especialidades+Médicas')] bg-cover bg-center mix-blend-overlay"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-md text-3xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold">
                        Especialidades Médicas
                    </h1>
                </div>
                <p class="text-lg md:text-xl mb-8 opacity-90">
                    Atención médica especializada con los mejores profesionales
                </p>
                <div class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                    {{ $sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz' }}
                </div>
            </div>
        </div>
    </section>

    <!-- Selector de Sucursal -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $especialidadesConServicios->count() }}</div>
                    <div class="text-gray-600">Especialidades</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $especialidadesConServicios->sum('total_servicios') }}</div>
                    <div class="text-gray-600">Servicios</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $especialidadesConServicios->sum('servicios_promocion') }}</div>
                    <div class="text-gray-600">En Promoción</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">S/. {{ number_format($especialidadesConServicios->avg('precio_promedio'), 0) }}</div>
                    <div class="text-gray-600">Precio Promedio</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filtros -->
    <section class="py-8 bg-gray-100">
        <div class="container mx-auto px-4">
            <form method="GET" class="flex flex-wrap gap-4 items-center justify-between">
                <!-- Selector de Sucursal -->
                <div class="flex-1 min-w-64">
                    <select name="sucursal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">Todas las sucursales</option>
                        @foreach($sucursales as $suc)
                            <option value="{{ $suc->COD_SUCURSAL }}" {{ $sucursal == $suc->COD_SUCURSAL ? 'selected' : '' }}>
                                {{ $suc->NOM_SUCURSAL }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Selector de Especialidad -->
                <div class="flex-1 min-w-64">
                    <select name="especialidad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">Todas las especialidades</option>
                        @foreach($especialidadesConServicios as $esp)
                            <option value="{{ $esp['codigo'] }}" {{ $especialidadSeleccionada == $esp['codigo'] ? 'selected' : '' }}>
                                {{ $esp['nombre'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Búsqueda -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Buscar servicios..." 
                               class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
            </form>
        </div>
    </section>

    <!-- Especialidades Grid -->
    @if(!$especialidadSeleccionada)
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nuestras Especialidades</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($especialidadesConServicios as $especialidad)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Header con color dinámico -->
                    <div class="p-6" style="background: linear-gradient(135deg, {{ $especialidad['color'] }}, {{ $especialidad['color'] }}dd);">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <i class="{{ $especialidad['icono'] }} text-3xl mb-2"></i>
                                <h3 class="text-xl font-bold">{{ $especialidad['nombre'] }}</h3>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold">{{ $especialidad['total_servicios'] }}</div>
                                <div class="text-sm opacity-90">Servicios</div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="p-6">
                        <!-- Estadísticas -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center">
                                <div class="text-lg font-semibold text-green-600">{{ $especialidad['servicios_promocion'] }}</div>
                                <div class="text-sm text-gray-600">En Promoción</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-semibold text-blue-600">S/. {{ number_format($especialidad['precio_promedio'], 0) }}</div>
                                <div class="text-sm text-gray-600">Precio Promedio</div>
                            </div>
                        </div>

                        <!-- Rango de precios -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Rango de precios:</span>
                                <span class="text-sm font-semibold">S/. {{ number_format($especialidad['precio_min'], 0) }} - S/. {{ number_format($especialidad['precio_max'], 0) }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full" style="background-color: {{ $especialidad['color'] }}; width: 75%;"></div>
                            </div>
                        </div>

                        <!-- Servicios destacados -->
                        @if($especialidad['servicios_destacados']->count() > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-800 mb-3">Servicios destacados:</h4>
                            <div class="space-y-2">
                                @foreach($especialidad['servicios_destacados'] as $servicio)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-700">{{ Str::limit($servicio['nombre'], 25) }}</span>
                                    <div class="flex items-center">
                                        @if($servicio['promocion'])
                                            <span class="text-red-500 line-through text-xs mr-1">S/. {{ number_format($servicio['precio'], 0) }}</span>
                                            <span class="text-green-600 font-semibold">S/. {{ number_format($servicio['precio_promocion'], 0) }}</span>
                                        @else
                                            <span class="text-blue-600 font-semibold">S/. {{ number_format($servicio['precio'], 0) }}</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Botón de acción -->
                        <div class="flex gap-3">
                            <a href="{{ url()->current() }}?sucursal={{ $sucursal }}&especialidad={{ $especialidad['codigo'] }}" 
                               class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                                Ver Servicios
                            </a>
                            <a href="{{ route('catalogo.especialidad-detalle', $especialidad['codigo']) }}?sucursal={{ $sucursal }}" 
                               class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Servicios de Especialidad Seleccionada -->
    @if($especialidadSeleccionada && $servicios->count() > 0)
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold">
                    Servicios de {{ $especialidadesConServicios->where('codigo', $especialidadSeleccionada)->first()['nombre'] ?? $especialidadSeleccionada }}
                </h2>
                <a href="{{ url()->current() }}?sucursal={{ $sucursal }}" 
                   class="text-blue-600 hover:text-blue-800 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Volver a especialidades
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($servicios as $servicio)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($servicio->IMAGEN_URL)
                    <img src="{{ $servicio->IMAGEN_URL }}" alt="{{ $servicio->DES_ARTICULO }}" class="w-full h-48 object-cover">
                    @endif
                    
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2">{{ $servicio->DES_ARTICULO }}</h3>
                        
                        @if($servicio->DES_CORTA)
                        <p class="text-gray-600 text-sm mb-4">{{ $servicio->DES_CORTA }}</p>
                        @endif

                        <div class="flex justify-between items-center mb-4">
                            @if($servicio->IND_PROMOCION === 'S' && $servicio->PRECIO_PROMOCION)
                                <div>
                                    <span class="text-red-500 line-through text-sm">S/. {{ number_format($servicio->PRECIO_MOSTRAR, 2) }}</span>
                                    <span class="text-green-600 font-bold text-lg ml-2">S/. {{ number_format($servicio->PRECIO_PROMOCION, 2) }}</span>
                                </div>
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">PROMOCIÓN</span>
                            @else
                                <span class="text-blue-600 font-bold text-lg">S/. {{ number_format($servicio->PRECIO_MOSTRAR, 2) }}</span>
                            @endif
                        </div>

                        @if($servicio->DURACION_ESTIMADA)
                        <div class="text-sm text-gray-600 mb-2">
                            <i class="fas fa-clock mr-1"></i>{{ $servicio->DURACION_ESTIMADA }}
                        </div>
                        @endif

                        @if($servicio->REQUIERE_CITA === 'S')
                        <div class="text-sm text-orange-600 mb-4">
                            <i class="fas fa-calendar-check mr-1"></i>Requiere cita previa
                        </div>
                        @endif

                        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-calendar-plus mr-2"></i>Agendar Cita
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($servicios->hasPages())
            <div class="mt-8">
                {{ $servicios->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Mensaje si no hay servicios -->
    @if($especialidadSeleccionada && $servicios->count() === 0)
    <section class="py-12">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No se encontraron servicios</h3>
                <p class="text-gray-600 mb-6">No hay servicios disponibles para los filtros seleccionados.</p>
                <a href="{{ url()->current() }}?sucursal={{ $sucursal }}" 
                   class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Ver todas las especialidades
                </a>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
