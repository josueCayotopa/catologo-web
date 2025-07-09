@extends('layouts.app')

@section('title', 'Laboratorio Clínico - ' . ($sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-blue-600 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('/placeholder.svg?height=1080&width=1920&text=Laboratorio+Clínico')] bg-cover bg-center mix-blend-overlay"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-flask text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold">
                    Laboratorio Clínico
                </h1>
            </div>
            <p class="text-lg md:text-xl mb-8 opacity-90">
                Análisis clínicos con tecnología de vanguardia y resultados confiables
            </p>
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                    {{ $sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz' }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Selector de Sucursal -->
<section class="py-8 bg-gray-50 border-b">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-secondary-950 mb-4">Seleccionar Sucursal:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($sucursales as $suc)
                    <a href="{{ route('catalogo.laboratorio', array_merge(request()->query(), ['sucursal' => $suc->COD_SUCURSAL])) }}"
                        class="p-4 rounded-lg border-2 transition-all {{ $sucursal === $suc->COD_SUCURSAL ? 'border-green-600 bg-green-50' : 'border-gray-200 hover:border-green-600 hover:bg-green-50' }}">
                        <div class="text-center">
                            <h4 class="font-semibold text-secondary-950">{{ $suc->NOM_SUCURSAL }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $suc->DES_DIRECCION ?? 'Dirección disponible' }}</p>
                            @if($sucursal === $suc->COD_SUCURSAL)
                                <span class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded-full">
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

<!-- Filtros por Categoría de Laboratorio -->
@if($tiposAnalisis->count() > 0)
<section class="py-8 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-lg font-semibold text-secondary-950 mb-4">Filtrar por Tipo de Análisis:</h3>
        <div class="flex flex-wrap gap-3">
            <button onclick="filterByCategoria('all')" 
                    class="px-4 py-2 rounded-full border-2 transition-colors {{ !$tipo_analisis || $tipo_analisis === 'all' ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-700 hover:border-green-600' }}">
                Todos los Análisis
            </button>
            @foreach($tiposAnalisis as $categoria_lab)
                <button onclick="filterByCategoria('{{ $categoria_lab['codigo'] }}')" 
                        class="px-4 py-2 rounded-full border-2 transition-colors {{ $tipo_analisis === $categoria_lab['codigo'] ? 'border-green-600 bg-green-600 text-white' : 'border-gray-300 text-gray-700 hover:border-green-600' }}">
                    <i class="{{ $categoria_lab['icono'] }} mr-2"></i>{{ $categoria_lab['nombre'] }} ({{ $categoria_lab['total'] }})
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Paquetes de Laboratorio Destacados -->
@if($paquetesLab->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold mb-3">PAQUETES ESPECIALES</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Paquetes de Laboratorio
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Análisis completos con precios especiales para tu comodidad
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($paquetesLab as $paquete)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-secondary-950">{{ $paquete['nombre'] }}</h3>
                            @if($paquete['promocion'])
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    OFERTA
                                </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ $paquete['descripcion'] }}</p>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold text-secondary-950 mb-2">Incluye:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                @foreach($paquete['incluye'] as $item)
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-600 mr-2"></i>{{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <div class="font-semibold text-secondary-950">{{ $paquete['tiempo_entrega'] }}</div>
                                <div class="text-gray-600">Tiempo de entrega</div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <div class="font-semibold {{ $paquete['ayuno_requerido'] ? 'text-orange-600' : 'text-green-600' }}">
                                    {{ $paquete['ayuno_requerido'] ? 'Sí' : 'No' }}
                                </div>
                                <div class="text-gray-600">Requiere ayuno</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-4">
                            @if($paquete['promocion'])
                                <div>
                                    <span class="text-2xl font-bold text-green-600">S/. {{ number_format($paquete['precio_promocion'], 2) }}</span>
                                    <span class="text-lg text-gray-500 line-through ml-2">S/. {{ number_format($paquete['precio'], 2) }}</span>
                                </div>
                            @else
                                <span class="text-2xl font-bold text-secondary-950">S/. {{ number_format($paquete['precio'], 2) }}</span>
                            @endif
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="https://citasweb.clinicalaluz.pe/" target="_blank"
                                class="flex-1 text-center py-2 px-4 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                <i class="fas fa-calendar-plus mr-2"></i>Agendar
                            </a>
                            <a href="https://wa.me/51993521429?text=Hola,%20necesito%20información%20sobre%20el%20paquete%20{{ urlencode($paquete['nombre']) }}" target="_blank"
                                class="bg-secondary-950 text-white py-2 px-4 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Procedimientos de Laboratorio -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mb-3">ANÁLISIS CLÍNICOS</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Procedimientos de Laboratorio
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Análisis especializados con equipos de última generación
            </p>
        </div>

        <!-- Barra de búsqueda -->
        <div class="max-w-md mx-auto mb-8">
            <form method="GET" class="relative">
                <input type="hidden" name="sucursal" value="{{ $sucursal }}">
                @if($tipo_analisis)
                    <input type="hidden" name="tipo_analisis" value="{{ $tipo_analisis }}">
                @endif
                <input type="text" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Buscar análisis..." 
                       class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-700">
                    <i class="fas fa-search text-lg"></i>
                </button>
            </form>
        </div>

        @if($procedimientos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($procedimientos as $procedimiento)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-flask text-green-600"></i>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-500 uppercase tracking-wide">
                                            {{ $procedimiento->SUBCATEGORIA ?? 'Laboratorio' }}
                                        </span>
                                    </div>
                                </div>
                                @if($procedimiento->IND_PROMOCION === 'S')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        PROMO
                                    </span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-bold text-secondary-950 mb-2 line-clamp-2">{{ $procedimiento->DES_ARTICULO }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $procedimiento->DES_CORTA ?? 'Análisis de laboratorio especializado' }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 mb-4 text-xs">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-semibold text-secondary-950">{{ $procedimiento->TIEMPO_ENTREGA ?? '24-48 hrs' }}</div>
                                    <div class="text-gray-600">Entrega</div>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <div class="font-semibold {{ $procedimiento->AYUNO_REQUERIDO === 'S' ? 'text-orange-600' : 'text-green-600' }}">
                                        {{ $procedimiento->AYUNO_REQUERIDO === 'S' ? 'Sí' : 'No' }}
                                    </div>
                                    <div class="text-gray-600">Ayuno</div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if($procedimiento->IND_PROMOCION === 'S' && $procedimiento->PRECIO_PROMOCION)
                                    <div>
                                        <span class="text-xl font-bold text-green-600">S/. {{ number_format($procedimiento->PRECIO_PROMOCION, 2) }}</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">S/. {{ number_format($procedimiento->PRECIO_MOSTRAR, 2) }}</span>
                                    </div>
                                @else
                                    <span class="text-xl font-bold text-secondary-950">S/. {{ number_format($procedimiento->PRECIO_MOSTRAR, 2) }}</span>
                                @endif
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('catalogo.show', ['codArticulo' => $procedimiento->COD_ARTICULO_SERV, 'sucursal' => $sucursal]) }}"
                                    class="flex-1 text-center py-2 px-3 text-sm bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                                    <i class="fas fa-info-circle mr-1"></i>Ver Detalles
                                </a>
                                <a href="https://citasweb.clinicalaluz.pe/" target="_blank"
                                    class="bg-secondary-950 text-white py-2 px-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-calendar-plus text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-12">
                {{ $procedimientos->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-flask text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron análisis</h3>
                <p class="text-gray-500 mb-4">
                    No hay procedimientos de laboratorio disponibles con los filtros seleccionados
                </p>
                <a href="{{ route('catalogo.laboratorio', ['sucursal' => $sucursal]) }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg transition-colors hover:bg-green-700">
                    Ver Todos los Análisis
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Información Adicional -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-secondary-950 mb-4">¿Por qué elegir nuestro laboratorio?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-microscope text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Tecnología Avanzada</h3>
                <p class="text-gray-600">Equipos de última generación para resultados precisos</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Resultados Rápidos</h3>
                <p class="text-gray-600">Entrega de resultados en tiempos óptimos</p>
            </div>
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Certificación</h3>
                <p class="text-gray-600">Laboratorio certificado con estándares internacionales</p>
            </div>
            <div class="text-center">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-2xl text-primary-950"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Personal Especializado</h3>
                <p class="text-gray-600">Profesionales altamente capacitados</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-green-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Necesitas realizar análisis clínicos?</h2>
        <p class="text-xl mb-8 opacity-90">Agenda tu cita o consulta nuestros paquetes especiales</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+51993521429" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-2"></i>Llamar Ahora
            </a>
            <a href="https://wa.me/51993521429?text=Hola,%20necesito%20información%20sobre%20análisis%20de%20laboratorio" target="_blank" class="bg-green-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-900 transition-colors">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </a>
            <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="bg-secondary-950 text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                <i class="fas fa-calendar-check mr-2"></i>Citas Online
            </a>
        </div>
    </div>
</section>

<script>
function filterByCategoria(categoria) {
    const url = new URL(window.location);
    if (categoria === 'all') {
        url.searchParams.delete('tipo_analisis');
    } else {
        url.searchParams.set('tipo_analisis', categoria);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
