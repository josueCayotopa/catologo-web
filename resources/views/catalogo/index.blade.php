@extends('layouts.app')

@section('title', 'Catálogo de Servicios Médicos - ' . ($sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz'))

@section('content')
<!-- Hero Section -->
<section class="custom-gradient text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            {{ $sucursalActual->NOM_SUCURSAL ?? 'Clínica La Luz' }}
        </h1>
        <p class="text-xl md:text-2xl mb-4 opacity-90">
            Catálogo de Servicios Médicos y Precios
        </p>
        @if($sucursalActual)
            <p class="text-lg mb-8 opacity-80">
                <i class="fas fa-map-marker-alt mr-2"></i>{{ $sucursalActual->DIRECCION }}
                @if($sucursalActual->TELEFONO)
                    <span class="ml-4"><i class="fas fa-phone mr-2"></i>{{ $sucursalActual->TELEFONO }}</span>
                @endif
            </p>
        @endif
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#servicios" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                VER NUESTROS SERVICIOS
            </a>
            <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="btn-secondary text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                AGENDAR CITA
            </a>
        </div>
    </div>
</section>

<!-- Sección de Promociones con Carrusel Mejorado -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-red-100 text-primary-950 rounded-full text-sm font-semibold mb-3">OFERTAS EXCLUSIVAS</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Promociones Destacadas
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Aprovecha nuestras ofertas exclusivas por tiempo limitado</p>
        </div>
        
        <!-- Carrusel de Promociones Mejorado -->
        <div class="relative max-w-5xl mx-auto">
            <!-- Contenedor del Carrusel -->
            <div class="overflow-hidden">
                <div id="promociones-slider" class="flex transition-transform duration-500 ease-in-out">
                    <!-- Slide 1: Chequeo Médico -->
                    <div class="promo-slide min-w-full md:min-w-[50%] lg:min-w-[33.333%] p-3">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative">
                                <img src="/images/general.jpg?height=300&width=500&text=Chequeo+Médico" alt="Chequeo Médico" class="w-full h-48 object-cover">
                                <div class="absolute top-4 left-4 bg-primary-950 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-fire mr-1"></i>POPULAR
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Chequeo Médico General I</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Consulta médica general</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Perfil lipídico</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Glucosa</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Hemograma completo</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-primary-950">S/. 124</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">S/. 150</span>
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        17% DSCTO
                                    </span>
                                </div>
                                
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Chequeo%20Médico%20General%20I" target="_blank" class="w-full bg-primary-950 text-white py-2 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-calendar-plus mr-2"></i>Reservar Ahora
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2: Cardiología -->
                    <div class="promo-slide min-w-full md:min-w-[50%] lg:min-w-[33.333%] p-3">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative">
                                <img src="/images/cardiologia.jpg?height=300&width=500&text=Cardiología" alt="Cardiología" class="w-full h-48 object-cover">
                                <div class="absolute top-4 right-4 bg-white bg-opacity-90 text-primary-950 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-heartbeat mr-1"></i>Cardiología
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Check Cardio Completo</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Consulta especializada</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Electrocardiograma</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Ecocardiograma</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Toma de presión arterial</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-primary-950">S/. 300</span>
                                    </div>
                                </div>
                                
                                <a href="tel:+51993521429" class="w-full bg-secondary-950 text-white py-2 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-phone mr-2"></i>Llamar para reservar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3: Ginecología -->
                    <div class="promo-slide min-w-full md:min-w-[50%] lg:min-w-[33.333%] p-3">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative">
                                <img src="/images/ginecologia.jpg?height=300&width=500&text=Ginecología" alt="Ginecología" class="w-full h-48 object-cover">
                                <div class="absolute top-4 right-4 bg-white bg-opacity-90 text-primary-950 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-female mr-1"></i>Ginecología
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Consulta Ginecológica</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Consulta especializada</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Ecografía transvaginal</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Lectura de resultados</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-primary-950">S/. 240</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">S/. 300</span>
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        20% DSCTO
                                    </span>
                                </div>
                                
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20la%20consulta%20ginecológica" target="_blank" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg font-semibold text-center block hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>Consultar por WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 4: Neurología -->
                    <div class="promo-slide min-w-full md:min-w-[50%] lg:min-w-[33.333%] p-3">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative">
                                <img src="/images/neurocirugia.jpg?height=300&width=500&text=Neurología" alt="Neurología" class="w-full h-48 object-cover">
                                <div class="absolute top-4 right-4 bg-white bg-opacity-90 text-primary-950 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-brain mr-1"></i>Neurología
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Check Neurológico</h3>
                                
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Consulta especializada</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Electroencefalograma</span>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-primary-950">S/. 150</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">S/. 200</span>
                                    </div>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        25% DSCTO
                                    </span>
                                </div>
                                
                                <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="w-full bg-secondary-950 text-white py-2 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-calendar-check mr-2"></i>Agendar cita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controles de Navegación -->
            <button id="prev-slide" class="absolute top-1/2 -left-4 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-100 transition-colors z-10">
                <i class="fas fa-chevron-left text-secondary-950"></i>
            </button>
            <button id="next-slide" class="absolute top-1/2 -right-4 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-100 transition-colors z-10">
                <i class="fas fa-chevron-right text-secondary-950"></i>
            </button>
            
            <!-- Indicadores de Slides -->
            <div class="flex justify-center mt-6 space-x-2">
                <button class="slide-indicator w-3 h-3 rounded-full bg-primary-950 opacity-100" data-slide="0"></button>
                <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 opacity-50" data-slide="1"></button>
                <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 opacity-50" data-slide="2"></button>
                <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 opacity-50" data-slide="3"></button>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="text-center mt-12">
            <p class="text-gray-600 mb-4">¿Necesitas más información sobre nuestras promociones?</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+51993521429" class="bg-primary-950 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-800 transition-colors">
                    <i class="fas fa-phone mr-2"></i>Llamar Ahora
                </a>
                <a href="https://wa.me/51993521429" target="_blank" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                </a>
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
                    <a href="{{ route('catalogo.index', array_merge(request()->query(), ['sucursal' => $suc->COD_SUCURSAL])) }}" 
                       class="p-4 rounded-lg border-2 transition-all {{ $sucursal === $suc->COD_SUCURSAL ? 'border-primary-950 bg-red-50' : 'border-gray-200 hover:border-secondary-950 hover:bg-blue-50' }}">
                        <div class="text-center">
                            <h4 class="font-semibold text-secondary-950">{{ $suc->NOM_SUCURSAL }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $suc->CIUDAD }}</p>
                            @if($sucursal === $suc->COD_SUCURSAL)
                                <span class="inline-block mt-2 px-3 py-1 bg-primary-950 text-white text-xs rounded-full">
                                    Seleccionada
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Filtros por Especialidad - SOLO ESPECIALIDADES DISPONIBLES -->
        @if(!empty($especialidades) && $especialidades->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-secondary-950 mb-4">Filtrar por Especialidad:</h3>
                <div class="flex flex-wrap gap-3">
                    <button onclick="filterByEspecialidad('all')" 
                            class="px-4 py-2 rounded-full border-2 transition-colors {{ !$especialidad || $especialidad === 'all' ? 'border-primary-950 bg-primary-950 text-white' : 'border-gray-300 text-gray-700 hover:border-primary-950 hover:text-primary-950' }}">
                        Todas las Especialidades
                    </button>
                    @foreach($especialidades as $esp)
                        <button onclick="filterByEspecialidad('{{ $esp->COD_ESPECIALIDAD }}')" 
                                class="px-4 py-2 rounded-full border-2 transition-colors flex items-center {{ $especialidad === $esp->COD_ESPECIALIDAD ? 'text-white' : 'text-gray-700 hover:border-secondary-950 hover:text-secondary-950' }}"
                                style="{{ $especialidad === $esp->COD_ESPECIALIDAD ? 'background-color: ' . $esp->COLOR . '; border-color: ' . $esp->COLOR : 'border-color: #d1d5db' }}">
                            @if($esp->ICONO)
                                <i class="{{ $esp->ICONO }} mr-2"></i>
                            @endif
                            {{ $esp->NOM_ESPECIALIDAD }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Resultados de Búsqueda -->
@if($search)
    <section class="py-4 bg-blue-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-secondary-950">
                        Resultados para: "<span class="text-primary-950">{{ $search }}</span>"
                    </h3>
                    <p class="text-gray-600">{{ $products->total() }} servicios encontrados en {{ $sucursalActual->NOM_SUCURSAL ?? 'esta sucursal' }}</p>
                </div>
                <a href="{{ route('catalogo.index', ['sucursal' => $sucursal]) }}" 
                   class="text-secondary-950 hover:text-primary-950 font-medium transition-colors">
                    <i class="fas fa-times mr-1"></i>Limpiar búsqueda
                </a>
            </div>
        </div>
    </section>
@endif

<!-- Catálogo de Servicios Médicos -->
<section id="servicios" class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                @if($especialidad && $especialidad !== 'all')
                    Servicios de {{ $especialidades[$especialidad]->NOM_ESPECIALIDAD ?? 'Especialidad' }}
                @else
                    Nuestros Servicios Médicos
                @endif
            </h2>
            <p class="text-gray-600 text-lg">
                Mostrando {{ $products->count() }} de {{ $products->total() }} servicios disponibles
            </p>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($products as $product)
                    <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl border border-gray-100 relative transition-all duration-300">
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                            @if($product['destacado'])
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-star mr-1"></i>Destacado
                                </span>
                            @endif
                            @if($product['promocion'])
                                <span class="bg-primary-950 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-fire mr-1"></i>Promoción
                                </span>
                            @endif
                        </div>

                        <div class="relative">
                            <img src="{{ $product['image'] }}" 
                                 alt="{{ $product['nombre'] }}" 
                                 class="w-full h-48 object-cover">
                            
                            <!-- Tipo de servicio -->
                            <div class="absolute bottom-4 right-4">
                                <span class="bg-white bg-opacity-90 text-secondary-950 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $product['tipo_servicio'] }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Especialidad -->
                            @if($product['especialidad'])
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                          style="background-color: {{ $product['color_especialidad'] ?? '#6b7280' }}">
                                        @if($product['icono_especialidad'])
                                            <i class="{{ $product['icono_especialidad'] }} mr-1"></i>
                                        @endif
                                        {{ $product['especialidad'] }}
                                    </span>
                                </div>
                            @endif
                            
                            <div class="mb-2">
                                <span class="text-xs text-secondary-950 bg-blue-50 px-2 py-1 rounded-full">
                                    Código: {{ $product['codigo'] }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-secondary-950 mb-2">{{ $product['nombre'] }}</h3>
                            <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ Str::limit($product['descripcion'], 80) }}</p>
                            
                            <!-- Información del servicio -->
                            <div class="mb-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock mr-2 text-primary-950"></i>
                                    <span>Duración: {{ $product['duracion_estimada'] }}</span>
                                </div>
                                @if($product['requiere_cita'])
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-check mr-2 text-primary-950"></i>
                                        <span>Requiere cita previa</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Precio -->
                            <div class="mb-4">
                                @if($product['promocion'] && $product['precio_promocion'])
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-bold text-primary-950">
                                            {{ $product['moneda'] }} {{ number_format($product['precio_promocion'], 2) }}
                                        </span>
                                        <span class="text-lg text-gray-500 line-through">
                                            {{ $product['moneda'] }} {{ number_format($product['precio'], 2) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-green-600 font-semibold">
                                        Ahorro: {{ $product['moneda'] }} {{ number_format($product['precio'] - $product['precio_promocion'], 2) }}
                                    </div>
                                @else
                                    <span class="text-2xl font-bold text-primary-950">
                                        {{ $product['moneda'] }} {{ number_format($product['precio'], 2) }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="flex gap-2">
                                <a href="{{ route('catalogo.show', ['codArticulo' => $product['codigo'], 'sucursal' => $sucursal]) }}" 
                                   class="flex-1 btn-primary text-white py-2 px-4 rounded-lg font-semibold text-sm transition-colors">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                                    </div>
                                </a>
                                <a href="https://citasweb.clinicalaluz.pe/" 
                                   target="_blank"
                                   class="btn-secondary text-white py-2 px-4 rounded-lg transition-colors">
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
                    {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-stethoscope text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">No se encontraron servicios</h3>
                <p class="text-gray-500 mb-4">
                    No hay servicios médicos disponibles con los filtros seleccionados
                </p>
                <a href="{{ route('catalogo.index', ['sucursal' => $sucursal]) }}" 
                   class="btn-secondary text-white px-6 py-3 rounded-lg transition-colors">
                    Ver todos los servicios
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Sección de Características -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-2xl text-primary-950"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Atención Especializada</h3>
                <p class="text-gray-600">Médicos especialistas con amplia experiencia</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-2xl text-secondary-950"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Citas Rápidas</h3>
                <p class="text-gray-600">Agenda tu cita de manera fácil y rápida</p>
            </div>
            <div class="text-center">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-primary-950"></i>
                </div>
                <h3 class="text-xl font-bold text-secondary-950 mb-2">Precios Transparentes</h3>
                <p class="text-gray-600">Conoce el precio exacto antes de tu cita</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('promociones-slider');
    const slides = document.querySelectorAll('.promo-slide');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');
    const indicators = document.querySelectorAll('.slide-indicator');
    
    let currentSlide = 0;
    let slideWidth = 100;
    let slidesToShow = 1;
    
    // Determinar cuántos slides mostrar según el ancho de la pantalla
    function updateSlidesToShow() {
        if (window.innerWidth >= 1024) {
            slidesToShow = 3; // Desktop
        } else if (window.innerWidth >= 768) {
            slidesToShow = 2; // Tablet
        } else {
            slidesToShow = 1; // Mobile
        }
        
        slideWidth = 100 / slidesToShow;
        updateSlider();
    }
    
    // Actualizar la posición del slider
    function updateSlider() {
        if (slider) {
            slider.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
        }
        
        // Actualizar indicadores
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.classList.add('bg-primary-950');
                indicator.classList.remove('bg-gray-300');
                indicator.style.opacity = '1';
            } else {
                indicator.classList.remove('bg-primary-950');
                indicator.classList.add('bg-gray-300');
                indicator.style.opacity = '0.5';
            }
        });
    }
    
    // Event listeners para los botones
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide--;
                updateSlider();
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentSlide < slides.length - slidesToShow) {
                currentSlide++;
                updateSlider();
            }
        });
    }
    
    // Event listeners para los indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateSlider();
        });
    });
    
    // Actualizar al cambiar el tamaño de la ventana
    window.addEventListener('resize', updateSlidesToShow);
    
    // Inicializar
    updateSlidesToShow();
    
    // Auto-play del slider
    setInterval(() => {
        if (currentSlide < slides.length - slidesToShow) {
            currentSlide++;
        } else {
            currentSlide = 0;
        }
        updateSlider();
    }, 5000);
});

// Filter functionality
function filterByEspecialidad(especialidad) {
    const url = new URL(window.location);
    if (especialidad === 'all') {
        url.searchParams.delete('especialidad');
    } else {
        url.searchParams.set('especialidad', especialidad);
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

// Touch/Swipe support for mobile
let startX = 0;
let endX = 0;

const sliderElement = document.getElementById('promociones-slider');
if (sliderElement) {
    sliderElement.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });

    sliderElement.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = startX - endX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            // Swipe left - next slide
            const nextBtn = document.getElementById('next-slide');
            if (nextBtn) nextBtn.click();
        } else {
            // Swipe right - previous slide
            const prevBtn = document.getElementById('prev-slide');
            if (prevBtn) prevBtn.click();
        }
    }
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
    background-color: #0d3049;
    color: white;
    border-color: #0d3049;
}

.pagination-custom .page-item.active .page-link {
    background-color: #b11a1a;
    border-color: #b11a1a;
    color: white;
}

.service-card:hover {
    transform: translateY(-5px);
}

/* Estilos para el slider de promociones */
.promo-slide {
    transition: transform 0.5s ease;
}

.slide-indicator {
    transition: opacity 0.3s ease, background-color 0.3s ease;
    cursor: pointer;
}

.slide-indicator:hover {
    opacity: 0.8 !important;
}

/* Animaciones para las tarjetas */
.transform {
    transition: all 0.3s ease;
}

/* Estilos para los botones */
.btn-primary {
    background-color: #b11a1a;
}
.btn-primary:hover {
    background-color: #8b1515;
}

/* Responsive adjustments para el slider */
@media (max-width: 768px) {
    .promo-slide .p-6 {
        padding: 1rem;
    }
    
    .promo-slide h3 {
        font-size: 1rem;
    }
    
    .promo-slide .text-2xl {
        font-size: 1.25rem;
    }
}

@media (max-width: 480px) {
    .promo-slide .p-6 {
        padding: 0.75rem;
    }
    
    .promo-slide h3 {
        font-size: 0.875rem;
    }
}
</style>
@endsection
