@extends('layouts.app')

@section('title', 'Estudios de Imagen - ' . ($sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('/placeholder.svg?height=1080&width=1920&text=Estudios+de+Imagen')] bg-cover bg-center mix-blend-overlay"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-x-ray text-3xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold">
                    Estudios de Imagen
                </h1>
            </div>
            <p class="text-lg md:text-xl mb-8 opacity-90">
                Diagnósticos precisos con tecnología de imagen de última generación
            </p>
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                    {{ $sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz' }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Selector de Sucursal y Filtros -->
<section class="py-8 bg-white border-b">
    <div class="container mx-auto px-4">
        <!-- Selector de Sucursal -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-secondary-950 mb-4">Seleccionar Sucursal:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($sucursales as $suc)
                    <a href="{{ route('catalogo.imagen', array_merge(request()->query(), ['sucursal' => $suc->COD_SUCURSAL])) }}"
                        class="p-4 rounded-lg border-2 transition-all {{ $sucursal === $suc->COD_SUCURSAL ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-600 hover:bg-purple-50' }}">
                        <div class="text-center">
                            <h4 class="font-semibold text-secondary-950">{{ $suc->NOM_SUCURSAL }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $suc->DES_DIRECCION ?? 'Dirección disponible' }}</p>
                            @if($sucursal === $suc->COD_SUCURSAL)
                                <span class="inline-block mt-2 px-3 py-1 bg-purple-600 text-white text-xs rounded-full">
                                    Seleccionada
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Filtros por Tipo de Estudio -->
        @if($tiposEstudio->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-secondary-950 mb-4">Filtrar por Tipo de Estudio:</h3>
                <div class="flex flex-wrap gap-3">
                    <button onclick="filterByTipoEstudio('all')"
                             class="px-4 py-2 rounded-full border-2 transition-colors {{ !$tipo_estudio || $tipo_estudio === 'all' ? 'border-purple-600 bg-purple-600 text-white' : 'border-gray-300 text-gray-700 hover:border-purple-600 hover:text-purple-600' }}">
                        Todos los Estudios
                    </button>
                    @foreach($tiposEstudio as $tipo)
                        <button onclick="filterByTipoEstudio('{{ $tipo['codigo'] }}')"
                                 class="px-4 py-2 rounded-full border-2 transition-colors flex items-center {{ $tipo_estudio === $tipo['codigo'] ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300 text-gray-700 hover:border-blue-600 hover:text-blue-600' }}">
                            <i class="{{ $tipo['icono'] }} mr-2"></i>
                            {{ $tipo['nombre'] }} ({{ $tipo['total'] }})
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Barra de búsqueda -->
        <div class="mb-6">
            <form method="GET" action="{{ route('catalogo.imagen') }}" class="flex gap-4">
                <input type="hidden" name="sucursal" value="{{ $sucursal }}">
                @if($tipo_estudio)
                    <input type="hidden" name="tipo_estudio" value="{{ $tipo_estudio }}">
                @endif
                
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search }}" 
                           placeholder="Buscar estudios de imagen..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
                @if($search)
                    <a href="{{ route('catalogo.imagen', ['sucursal' => $sucursal, 'tipo_estudio' => $tipo_estudio]) }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>
</section>

<!-- Resultados de Búsqueda -->
@if($search)
    <section class="py-4 bg-purple-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-secondary-950">
                        Resultados para: "<span class="text-purple-600">{{ $search }}</span>"
                    </h3>
                    <p class="text-gray-600">{{ $estudios->total() }} estudios encontrados</p>
                </div>
                <a href="{{ route('catalogo.imagen', ['sucursal' => $sucursal, 'tipo_estudio' => $tipo_estudio]) }}"
                    class="text-secondary-950 hover:text-purple-600 font-medium transition-colors">
                    <i class="fas fa-times mr-1"></i>Limpiar búsqueda
                </a>
            </div>
        </div>
    </section>
@endif

<!-- Estudios Destacados -->
@if(isset($estudiosDestacados) && $estudiosDestacados->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold mb-3">ESTUDIOS DESTACADOS</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Estudios Más Solicitados
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Los estudios de imagen más populares y efectivos</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($estudiosDestacados as $estudio)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="relative">
                        <img src="{{ $estudio->IMAGEN_URL ?? '/placeholder.svg?height=200&width=400&text=Estudio+de+Imagen' }}"
                              alt="{{ $estudio->DES_ARTICULO }}"
                              class="w-full h-48 object-cover">
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-star mr-1"></i>Destacado
                            </span>
                        </div>

                        <div class="absolute bottom-4 right-4">
                            <span class="bg-white bg-opacity-90 text-secondary-950 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                <i class="fas fa-x-ray mr-1"></i>
                                {{ $estudio->SUBCATEGORIA ?? 'Imagen' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-secondary-950 mb-2">{{ $estudio->DES_ARTICULO }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($estudio->DES_CORTA ?? 'Estudio de imagen especializado', 100) }}</p>

                        <div class="mb-4">
                            @if($estudio->IND_PROMOCION === 'S' && $estudio->PRECIO_PROMOCION)
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl font-bold text-purple-600">
                                        S/. {{ number_format($estudio->PRECIO_PROMOCION, 2) }}
                                    </span>
                                    <span class="text-lg text-gray-500 line-through">
                                        S/. {{ number_format($estudio->PRECIO_MOSTRAR, 2) }}
                                    </span>
                                </div>
                            @else
                                <span class="text-2xl font-bold text-secondary-950">
                                    S/. {{ number_format($estudio->PRECIO_MOSTRAR, 2) }}
                                </span>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('catalogo.show', ['codArticulo' => $estudio->COD_ARTICULO_SERV, 'sucursal' => $sucursal]) }}"
                                class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg font-semibold text-center transition-colors hover:bg-purple-700">
                                Ver Detalles
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
    </div>
</section>
@endif

<!-- Catálogo de Estudios -->
<section id="estudios" class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                @if($tipo_estudio && $tipo_estudio !== 'all')
                    {{ $tiposEstudio->where('codigo', $tipo_estudio)->first()['nombre'] ?? 'Estudios de Imagen' }}
                @else
                    Estudios de Imagen
                @endif
            </h2>
            <p class="text-gray-600 text-lg">
                Mostrando {{ $estudios->count() }} de {{ $estudios->total() }} estudios disponibles
            </p>
        </div>

        @if($estudios->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                @foreach($estudios as $estudio)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl border border-gray-100 relative transition-all duration-300">
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                            @if($estudio->IND_DESTACADO === 'S')
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star mr-1"></i>Destacado
                                </span>
                            @endif
                            @if($estudio->IND_PROMOCION === 'S')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-fire mr-1"></i>Promoción
                                </span>
                            @endif
                        </div>

                        <div class="relative">
                            <img src="{{ $estudio->IMAGEN_URL ?? '/placeholder.svg?height=160&width=300&text=Estudio+de+Imagen' }}"
                                  alt="{{ $estudio->DES_ARTICULO }}"
                                  class="w-full h-40 object-cover">
                            
                            <!-- Categoría -->
                            <div class="absolute bottom-4 right-4">
                                <span class="bg-white bg-opacity-90 text-secondary-950 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                                    <i class="fas fa-x-ray mr-1"></i>
                                    {{ $estudio->SUBCATEGORIA ?? 'Imagen' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-xs text-secondary-950 bg-purple-50 px-2 py-1 rounded-full">
                                    Código: {{ $estudio->COD_ARTICULO_SERV }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-secondary-950 mb-2">{{ $estudio->DES_ARTICULO }}</h3>
                            <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ Str::limit($estudio->DES_CORTA ?? 'Estudio de imagen especializado', 80) }}</p>

                            <!-- Información del estudio -->
                            <div class="mb-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2 text-purple-600"></i>
                                    <span>{{ $estudio->TIEMPO_ENTREGA ?? 'Inmediato' }}</span>
                                </div>
                                @if($estudio->REQUIERE_ORDEN_MEDICA === 'S')
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-file-medical mr-2 text-purple-600"></i>
                                        <span>Requiere orden médica</span>
                                    </div>
                                @endif
                                @if($estudio->REQUIERE_CITA === 'S')
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-check mr-2 text-purple-600"></i>
                                        <span>Requiere cita previa</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Precio -->
                            <div class="mb-4">
                                @if($estudio->IND_PROMOCION === 'S' && $estudio->PRECIO_PROMOCION)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl font-bold text-purple-600">
                                            S/. {{ number_format($estudio->PRECIO_PROMOCION, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500 line-through">
                                            S/. {{ number_format($estudio->PRECIO_MOSTRAR, 2) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-purple-600 font-semibold">
                                        Ahorro: S/. {{ number_format($estudio->PRECIO_MOSTRAR - $estudio->PRECIO_PROMOCION, 2) }}
                                    </div>
                                @else
                                    <span class="text-xl font-bold text-secondary-950">
                                        S/. {{ number_format($estudio->PRECIO_MOSTRAR, 2) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex gap-2">
                                <a href="{{ route('catalogo.show', ['codArticulo' => $estudio->COD_ARTICULO_SERV, 'sucursal' => $sucursal]) }}"
                                    class="flex-1 bg-purple-600 text-white py-2 px-4 rounded-lg font-semibold text-sm text-center transition-colors hover:bg-purple-700">
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

            <!-- Paginación -->
            <div class="flex justify-center">
                <div class="pagination-custom">
                    {{ $estudios->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-x-ray text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron estudios</h3>
                <p class="text-gray-500 mb-4">
                    No hay estudios de imagen disponibles con los filtros seleccionados
                </p>
                <a href="{{ route('catalogo.imagen', ['sucursal' => $sucursal]) }}"
                    class="bg-purple-600 text-white px-6 py-3 rounded-lg transition-colors hover:bg-purple-700">
                    Ver todos los estudios
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Información Importante -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-secondary-950 mb-4">¿Por qué elegir nuestros estudios de imagen?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-microscope text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Tecnología Avanzada</h3>
                <p class="text-gray-600">Equipos de última generación para diagnósticos precisos</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Especialistas Certificados</h3>
                <p class="text-gray-600">Radiólogos con amplia experiencia en diagnóstico por imagen</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Resultados Rápidos</h3>
                <p class="text-gray-600">Entrega de resultados en el menor tiempo posible</p>
            </div>
            <div class="text-center">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-primary-950"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Seguridad Garantizada</h3>
                <p class="text-gray-600">Protocolos de seguridad y protección radiológica</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-purple-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Necesitas un estudio de imagen?</h2>
        <p class="text-xl mb-8 opacity-90">Agenda tu cita o solicita información</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+51993521429" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone mr-2"></i>Llamar Ahora
            </a>
            <a href="https://wa.me/51993521429?text=Hola,%20necesito%20información%20sobre%20estudios%20de%20imagen" target="_blank" class="bg-purple-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-900 transition-colors">
                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
            </a>
            <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="bg-secondary-950 text-white px-8 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                <i class="fas fa-calendar-check mr-2"></i>Citas Online
            </a>
        </div>
    </div>
</section>

<script>
function filterByTipoEstudio(tipo) {
    const url = new URL(window.location);
    if (tipo === 'all') {
        url.searchParams.delete('tipo_estudio');
    } else {
        url.searchParams.set('tipo_estudio', tipo);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>

<style>
.pagination-custom .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination-custom .page-link {
    background-color: white;
    border: 1px solid #d1d5db;
    color: #0d3049;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-custom .page-link:hover {
    background-color: #9333ea;
    color: white;
    border-color: #9333ea;
}

.pagination-custom .page-item.active .page-link {
    background-color: #9333ea;
    border-color: #9333ea;
    color: white;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
