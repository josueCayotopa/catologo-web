@extends('layouts.app')

@section('title', $productTransformed['nombre'] . ' - Clínica La Luz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('catalogo.index', ['sucursal' => request('sucursal')]) }}" class="hover:text-primary-950 transition-colors">Inicio</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            @if($productTransformed['especialidad'])
                <li><a href="{{ route('catalogo.index', ['sucursal' => request('sucursal'), 'especialidad' => $productTransformed['cod_especialidad']]) }}" class="hover:text-primary-950 transition-colors">{{ $productTransformed['especialidad'] }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
            @endif
            <li class="text-secondary-950 font-semibold">{{ $productTransformed['nombre'] }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        <!-- Imagen del Servicio -->
        <div class="space-y-4">
            <div class="aspect-square bg-white rounded-xl shadow-lg overflow-hidden border">
                <img src="{{ $productTransformed['image'] }}" 
                     alt="{{ $productTransformed['nombre'] }}" 
                     class="w-full h-full object-cover"
                     onerror="this.src='/placeholder.svg?height=400&width=400&text=Servicio+Médico'">
            </div>
            
            <!-- Información visual adicional -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <i class="fas fa-clock text-2xl text-secondary-950 mb-2"></i>
                    <div class="text-sm font-semibold text-secondary-950">Duración</div>
                    <div class="text-xs text-gray-600">{{ $productTransformed['duracion_estimada'] }}</div>
                </div>
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <i class="fas fa-calendar-check text-2xl text-primary-950 mb-2"></i>
                    <div class="text-sm font-semibold text-primary-950">
                        {{ $productTransformed['requiere_cita'] ? 'Requiere Cita' : 'Sin Cita' }}
                    </div>
                    <div class="text-xs text-gray-600">
                        {{ $productTransformed['requiere_cita'] ? 'Previa reserva' : 'Directo' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Servicio -->
        <div class="space-y-6">
            <div>
                <!-- Especialidad y Categoría -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($productTransformed['especialidad'])
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white"
                              style="background-color: {{ $productTransformed['color_especialidad'] ?? '#6b7280' }}">
                            @if($productTransformed['icono_especialidad'])
                                <i class="{{ $productTransformed['icono_especialidad'] }} mr-2"></i>
                            @endif
                            {{ $productTransformed['especialidad'] }}
                        </span>
                    @endif
                    
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $productTransformed['tipo_servicio'] }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">{{ $productTransformed['nombre'] }}</h1>
                
                <div class="mb-4">
                    <span class="text-sm text-secondary-950 bg-blue-50 px-3 py-1 rounded-full">
                        Código: {{ $productTransformed['codigo'] }}
                    </span>
                </div>
                
                <p class="text-gray-600 text-lg leading-relaxed mb-4">{{ $productTransformed['descripcion'] }}</p>
                
                @if($productTransformed['descripcion_larga'] && $productTransformed['descripcion_larga'] !== $productTransformed['descripcion'])
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-secondary-950 mb-2">Información Adicional:</h3>
                        <p class="text-gray-700">{{ $productTransformed['descripcion_larga'] }}</p>
                    </div>
                @endif
            </div>

            <!-- Precio -->
            <div class="border-t border-b border-gray-200 py-6">
                @if($productTransformed['promocion'] && $productTransformed['precio_promocion'])
                    <div class="flex items-center gap-4 mb-2">
                        <div class="text-4xl font-bold text-primary-950">
                            {{ $productTransformed['moneda'] }} {{ number_format($productTransformed['precio_promocion'], 2) }}
                        </div>
                        <div class="text-2xl text-gray-500 line-through">
                            {{ $productTransformed['moneda'] }} {{ number_format($productTransformed['precio'], 2) }}
                        </div>
                        <span class="bg-primary-950 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-fire mr-1"></i>Promoción
                        </span>
                    </div>
                    <div class="text-green-600 font-semibold">
                        Ahorras: {{ $productTransformed['moneda'] }} {{ number_format($productTransformed['precio'] - $productTransformed['precio_promocion'], 2) }}
                    </div>
                @else
                    <div class="text-4xl font-bold text-primary-950 mb-2">
                        {{ $productTransformed['moneda'] }} {{ number_format($productTransformed['precio'], 2) }}
                    </div>
                @endif
                
                <!-- Estado de disponibilidad -->
                <div class="flex items-center mt-3">
                    @if($productTransformed['disponible'])
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-600 font-semibold">Servicio Disponible</span>
                    @else
                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                        <span class="text-red-600 font-semibold">Temporalmente No Disponible</span>
                    @endif
                </div>
            </div>

            <!-- Información del Servicio -->
            <div class="bg-gradient-to-r from-blue-50 to-red-50 rounded-xl p-6">
                <h3 class="font-bold text-secondary-950 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detalles del Servicio
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-primary-950 mr-3"></i>
                        <span><strong>Duración:</strong> {{ $productTransformed['duracion_estimada'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-primary-950 mr-3"></i>
                        <span><strong>Cita:</strong> {{ $productTransformed['requiere_cita'] ? 'Requerida' : 'No requerida' }}</span>
                    </div>
                    @if($productTransformed['horario_disponible'])
                        <div class="flex items-center">
                            <i class="fas fa-business-time text-primary-950 mr-3"></i>
                            <span><strong>Horario:</strong> {{ $productTransformed['horario_disponible'] }}</span>
                        </div>
                    @endif
                    @if(!empty($productTransformed['dias_disponible']))
                        <div class="flex items-center">
                            <i class="fas fa-calendar-week text-primary-950 mr-3"></i>
                            <span><strong>Días:</strong> {{ implode(', ', $productTransformed['dias_disponible']) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones principales -->
            @if($productTransformed['disponible'])
                <div class="space-y-4">
                    @if($productTransformed['es_emergencia'])
                        <!-- Para emergencias -->
                        <div class="bg-red-100 border border-red-300 rounded-lg p-4">
                            <h4 class="font-bold text-red-800 mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Servicio de Emergencia
                            </h4>
                            <p class="text-red-700 text-sm mb-3">Este servicio está disponible las 24 horas.</p>
                            <a href="tel:{{ $sucursalInfo['telefono'] }}" 
                               class="w-full bg-red-600 text-white py-4 px-6 rounded-xl font-semibold hover:bg-red-700 transition-colors text-center block">
                                <i class="fas fa-phone mr-2"></i>
                                LLAMAR AHORA - EMERGENCIA
                            </a>
                        </div>
                    @elseif($productTransformed['requiere_cita'])
                        <!-- Para servicios que requieren cita -->
                        <div class="flex space-x-4">
                            <a href="https://citasweb.clinicalaluz.pe/" 
                               target="_blank"
                               class="flex-1 btn-primary text-white py-4 px-6 rounded-xl font-semibold transition-colors text-center">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                Agendar Cita Online
                            </a>
                            <button onclick="toggleFavorite()" class="bg-gray-200 text-gray-700 py-4 px-6 rounded-xl hover:bg-gray-300 transition-colors">
                                <i class="far fa-heart" id="favorite-icon"></i>
                            </button>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-secondary-950 mb-2">
                                <i class="fas fa-lightbulb mr-2"></i>
                                ¿Cómo agendar tu cita?
                            </h4>
                            <ol class="text-sm text-gray-700 space-y-1">
                                <li>1. Haz clic en "Agendar Cita Online" o llama por teléfono</li>
                                <li>2. Selecciona fecha y hora disponible</li>
                                <li>3. Proporciona tus datos personales</li>
                                <li>4. Confirma tu cita y recibe la confirmación</li>
                            </ol>
                        </div>
                    @else
                        <!-- Para servicios sin cita -->
                        <div class="bg-green-50 border border-green-300 rounded-lg p-4">
                            <h4 class="font-bold text-green-800 mb-2">
                                <i class="fas fa-check-circle mr-2"></i>
                                Servicio sin Cita Previa
                            </h4>
                            <p class="text-green-700 text-sm mb-3">Puedes acercarte directamente a nuestra sede.</p>
                        </div>
                    @endif
                </div>
            @else
                <!-- Servicio no disponible -->
                <div class="bg-gray-100 rounded-xl p-6 text-center">
                    <i class="fas fa-pause-circle text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Servicio Temporalmente No Disponible</h3>
                    <p class="text-gray-500 mb-4">Este servicio no está disponible en este momento.</p>
                    <button class="bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                        No Disponible
                    </button>
                </div>
            @endif

            <!-- Información de contacto -->
            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                <h3 class="font-bold text-secondary-950 mb-4">
                    <i class="fas fa-hospital mr-2"></i>
                    Información de la Sede
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-primary-950 mr-3"></i>
                        <span class="text-gray-700">{{ $sucursalInfo['direccion'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-primary-950 mr-3"></i>
                        <span class="text-gray-700">{{ $sucursalInfo['telefono'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-user-md text-primary-950 mr-3"></i>
                        <span class="text-gray-700">Atención médica especializada</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-primary-950 mr-3"></i>
                        <span class="text-gray-700">Protocolos de bioseguridad</span>
                    </div>
                </div>
            </div>

            <!-- Botones de contacto -->
            <div class="grid grid-cols-2 gap-4">
                <a href="tel:{{ $sucursalInfo['telefono'] }}" 
                   class="btn-secondary text-white py-3 px-6 rounded-lg font-semibold text-center transition-colors">
                    <i class="fas fa-phone mr-2"></i>Llamar
                </a>
                <a href="https://wa.me/{{ $sucursalInfo['whatsapp'] }}?text=Hola, necesito información sobre {{ $productTransformed['nombre'] }}" 
                   target="_blank"
                   class="bg-green-600 text-white py-3 px-6 rounded-lg font-semibold text-center hover:bg-green-700 transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Servicios Relacionados -->
    @if(!empty($relatedProducts) && $relatedProducts->count() > 0)
        <section class="mt-16">
            <h2 class="text-2xl md:text-3xl font-bold text-secondary-950 mb-8">Servicios Relacionados</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl border border-gray-100 transition-all duration-300">
                        <div class="relative">
                            <img src="{{ $relatedProduct['image'] }}" 
                                 alt="{{ $relatedProduct['nombre'] }}" 
                                 class="w-full h-48 object-cover"
                                 onerror="this.src='/placeholder.svg?height=400&width=400&text=Servicio+Médico'">
                            <div class="absolute bottom-4 right-4">
                                <span class="bg-white bg-opacity-90 text-secondary-950 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $relatedProduct['tipo_servicio'] }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-secondary-950 mb-2">{{ $relatedProduct['nombre'] }}</h3>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($relatedProduct['descripcion'], 80) }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                @if($relatedProduct['promocion'] && $relatedProduct['precio_promocion'])
                                    <div class="flex items-center gap-2">
                                        <span class="text-xl font-bold text-primary-950">
                                            {{ $relatedProduct['moneda'] }} {{ number_format($relatedProduct['precio_promocion'], 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500 line-through">
                                            {{ $relatedProduct['moneda'] }} {{ number_format($relatedProduct['precio'], 2) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xl font-bold text-primary-950">
                                        {{ $relatedProduct['moneda'] }} {{ number_format($relatedProduct['precio'], 2) }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('catalogo.show', ['codArticulo' => $relatedProduct['codigo'], 'sucursal' => request('sucursal')]) }}" 
                                   class="flex-1 btn-primary text-white py-2 px-4 rounded-lg font-semibold text-sm transition-colors text-center">
                                    <i class="fas fa-info-circle mr-2"></i>Ver Detalles
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
        </section>
    @endif
</div>

<script>
function toggleFavorite() {
    const icon = document.getElementById('favorite-icon');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        showNotification('Servicio agregado a favoritos', 'success');
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        showNotification('Servicio removido de favoritos', 'info');
    }
}

// Función para mostrar información adicional
function showServiceInfo() {
    alert('Para más información sobre este servicio, puedes contactarnos directamente.');
}
</script>

<style>
.service-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
