@extends('layouts.app')

@section('title', $especialidad['nombre'] . ' - ' . ($sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz'))

@section('content')
<!-- Hero Section -->
<section class="relative text-white py-16" style="background: linear-gradient(135deg, {{ $especialidad['color'] }} 0%, #0d3049 100%);">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 opacity-90" style="background: linear-gradient(135deg, {{ $especialidad['color'] }} 0%, #0d3049 100%);"></div>
        <div class="absolute inset-0 bg-[url('/placeholder.svg?height=1080&width=1920&text={{ urlencode($especialidad['nombre']) }}')] bg-cover bg-center mix-blend-overlay"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm opacity-80">
                    <li><a href="{{ route('catalogo.index') }}" class="hover:text-white">Inicio</a></li>
                    <li><i class="fas fa-chevron-right mx-2"></i></li>
                    <li><a href="{{ route('catalogo.especialidades') }}" class="hover:text-white">Especialidades</a></li>
                    <li><i class="fas fa-chevron-right mx-2"></i></li>
                    <li class="text-white font-semibold">{{ $especialidad['nombre'] }}</li>
                </ol>
            </nav>

            <div class="flex items-center mb-6">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-6">
                    <i class="{{ $especialidad['icono'] }} text-4xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-2">
                        {{ $especialidad['nombre'] }}
                    </h1>
                    <p class="text-lg md:text-xl opacity-90">
                        {{ $especialidad['descripcion'] }}
                    </p>
                </div>
            </div>
            
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                    {{ $sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz' }} - {{ $servicios->count() }} servicios disponibles
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Selector de Sucursal -->
<section class="py-8 bg-white border-b">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-secondary-950 mb-4">Seleccionar Sucursal:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($sucursales as $suc)
                    <a href="{{ route('catalogo.especialidad-detalle', ['codEspecialidad' => $especialidad['codigo'], 'sucursal' => $suc->COD_SUCURSAL]) }}"
                        class="p-4 rounded-lg border-2 transition-all {{ $sucursal === $suc->COD_SUCURSAL ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:border-blue-600 hover:bg-blue-50' }}">
                        <div class="text-center">
                            <h4 class="font-semibold text-secondary-950">{{ $suc->NOM_SUCURSAL }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $suc->CIUDAD }}</p>
                            @if($sucursal === $suc->COD_SUCURSAL)
                                <span class="inline-block mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded-full">
                                    Seleccionada
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Servicios de la Especialidad -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Servicios de {{ $especialidad['nombre'] }}
            </h2>
            <p class="text-gray-600 text-lg">
                {{ $servicios->count() }} servicios disponibles en esta especialidad
            </p>
        </div>

        @if($servicios->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($servicios as $servicio)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl border border-gray-100 relative transition-all duration-300">
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                            @if($servicio['destacado'])
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star mr-1"></i>Destacado
                                </span>
                            @endif
                            @if($servicio['promocion'])
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-fire mr-1"></i>Promoción
                                </span>
                            @endif
                        </div>

                        <div class="relative">
                            <img src="{{ $servicio['image'] }}"
                                  alt="{{ $servicio['nombre'] }}"
                                  class="w-full h-40 object-cover">
                            
                            <!-- Categoría -->
                            <div class="absolute bottom-4 right-4">
                                <span class="bg-white bg-opacity-90 text-secondary-950 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                    <i class="{{ $servicio['icono_especialidad'] }} mr-1"></i>
                                    {{ $servicio['nombre_categoria'] }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-xs text-secondary-950 bg-blue-50 px-2 py-1 rounded-full">
                                    Código: {{ $servicio['codigo'] }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-secondary-950 mb-2">{{ $servicio['nombre'] }}</h3>
                            <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ Str::limit($servicio['descripcion'], 80) }}</p>

                            <!-- Información del servicio -->
                            <div class="mb-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2" style="color: {{ $especialidad['color'] }};"></i>
                                    <span>{{ $servicio['duracion_estimada'] }}</span>
                                </div>
                                @if($servicio['requiere_cita'])
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-check mr-2" style="color: {{ $especialidad['color'] }};"></i>
                                        <span>Requiere cita previa</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Precio -->
                            <div class="mb-4">
                                @if($servicio['promocion'] && $servicio['precio_promocion'])
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl font-bold" style="color: {{ $especialidad['color'] }};">
                                            {{ $servicio['moneda'] }} {{ number_format($servicio['precio_promocion'], 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500 line-through">
                                            {{ $servicio['moneda'] }} {{ number_format($servicio['precio'], 2) }}
                                        </span>
                                    </div>
                                    <div class="text-sm font-semibold" style="color: {{ $especialidad['color'] }};">
                                        Ahorro: {{ $servicio['moneda'] }} {{ number_format($servicio['precio'] - $servicio['precio_promocion'], 2) }}
                                    </div>
                                @else
                                    <span class="text-xl font-bold text-secondary-950">
                                        {{ $servicio['moneda'] }} {{ number_format($servicio['precio'], 2) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex gap-2">
                                <a href="{{ route('catalogo.show', ['codArticulo' => $servicio['codigo'], 'sucursal' => $sucursal]) }}"
                                    class="flex-1 text-white py-2 px-4 rounded-lg font-semibold text-sm text-center transition-colors hover:opacity-90"
                                    style="background-color: {{ $especialidad['color'] }};">
                                    <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                                </a>
                                <a href="https://citasweb.clinicalaluz.pe/"
                                    target="_blank"
                                   class="bg-secondary-950 text-white py-2 px-4 rounded-lg transition-colors hover:bg-opacity-90">
                                    <i class="fas fa-calendar-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <i class="{{ $especialidad['icono'] }} text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron servicios</h3>
                <p class="text-gray-500 mb-4">
                    No hay servicios disponibles para esta especialidad en la sucursal seleccionada
                </p>
                <a href="{{ route('catalogo.especialidades', ['sucursal' => $sucursal]) }}"
                    class="text-white px-6 py-3 rounded-lg transition-colors hover:opacity-90"
                    style="background-color: {{ $especialidad['color'] }};">
                    Ver Otras Especialidades
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Médicos de la Especialidad -->
@if($medicos->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-secondary-950 mb-4">Nuestros Especialistas</h2>
            <p class="text-gray-600 text-lg">Médicos especializados en {{ $especialidad['nombre'] }}</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($medicos as $medico)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="p-6 text-center">
                        <img src="{{ $medico['imagen'] }}" 
                             alt="{{ $medico['nombre'] }}"
                             class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        <h3 class="text-xl font-bold text-secondary-950 mb-2">{{ $medico['nombre'] }}</h3>
                        <p class="text-gray-600 mb-2">{{ $medico['especialidad'] }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $medico['experiencia'] }} de experiencia</p>
                        <a href="https://citasweb.clinicalaluz.pe/" 
                           target="_blank"
                           class="text-white px-6 py-2 rounded-lg font-semibold transition-colors hover:opacity-90"
                           style="background-color: {{ $especialidad['color'] }};">
                            <i class="fas fa-calendar-check mr-2"></i>Agendar Cita
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-16 text-white" style="background-color: {{ $especialidad['color'] }};">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Necesitas atención en {{ $especialidad['nombre'] }}?</h2>
        <p class="text-xl mb-8 opacity-90">Agenda tu cita con nuestros especialistas</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+51993521429" class="bg-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
               style="color: {{ $especialidad['color'] }};">
                <i class="fas fa-phone mr-2"></i>Llamar Ahora
            </a>
            <a href="https://wa.me/51993521429?text=Hola,%20necesito%20información%20sobre%20{{ urlencode($especialidad['nombre']) }}" 
               target="_blank" 
               class="bg-white bg-opacity-20 text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-30 transition-colors">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </a>
            <a href="https://citasweb.clinicalaluz.pe/" 
               target="_blank" 
               class="bg-secondary-950 text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                <i class="fas fa-calendar-check mr-2"></i>Citas Online
            </a>
        </div>
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
