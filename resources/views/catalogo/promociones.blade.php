@extends('layouts.app')

@section('title', 'Promociones Especiales - Clínica La Luz')

@section('content')
<!-- Hero Section con imagen de fondo -->
<section class="relative bg-gradient-to-r from-primary-950 to-secondary-950 text-white py-16 md:py-24">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-950 to-secondary-950 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('/placeholder.svg?height=1080&width=1920')] bg-cover bg-center mix-blend-overlay"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Promociones Especiales
                <span class="block text-2xl md:text-3xl font-normal mt-2">Clínica La Luz - Sede San Juan</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Cuidamos tu salud con los mejores especialistas y tecnología de vanguardia
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#promociones" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    VER PROMOCIONES
                </a>
                <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="bg-white text-primary-950 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    AGENDAR CITA
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Promociones Destacadas - Grid Layout -->
<section id="promociones" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-red-100 text-primary-950 rounded-full text-sm font-semibold mb-3">OFERTAS EXCLUSIVAS</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Promociones Especiales
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Aprovecha nuestras ofertas exclusivas en servicios médicos de alta calidad con los mejores especialistas</p>
        </div>
        
        <!-- Grid de Promociones - Diseño Asimétrico -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Promoción Grande (Chequeo Médico) -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden md:col-span-2 lg:row-span-2 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex flex-col lg:flex-row h-full">
                    <div class="lg:w-1/2 relative">
                        <img src="/images/medicina general1.JPG?height=600&width=600" alt="Chequeo Médico Completo" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-primary-950 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-fire mr-1"></i>MÁS POPULAR
                        </div>
                    </div>
                    <div class="lg:w-1/2 p-6 lg:p-8 flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-secondary-950 mb-2">Chequeo Médico General I</h3>
                            <p class="text-gray-600 mb-6">Evaluación completa de tu salud con los mejores especialistas</p>
                            
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Consulta médica general</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Perfil lipídico completo</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Glucosa</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Hemograma completo</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                        <span>Urea y creatinina</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-3xl font-bold text-primary-950">S/. 124</span>
                                    <span class="text-lg text-gray-500 line-through ml-2">S/. 150</span>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    17% DSCTO
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="btn-primary text-white py-3 px-4 rounded-lg font-semibold text-center transition-colors">
                                    <i class="fas fa-calendar-plus mr-2"></i>Agendar
                                </a>
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Chequeo%20Médico%20General%20I" target="_blank" class="bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>Consultar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Promoción Cardiología -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative">
                    <img src="/images/Check Cardio Completo.jpeg?height=300&width=500" alt="Cardiología" class="w-full h-48 object-cover">
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
                        </ul>
                    </div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-primary-950">S/. 300</span>
                            <span class="text-sm text-gray-500 line-through ml-2">S/. 380</span>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                            21% DSCTO
                        </span>
                    </div>
                    
                    <a href="tel:+51993521429" class="w-full bg-secondary-950 text-white py-2 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                        <i class="fas fa-phone mr-2"></i>Llamar para reservar
                    </a>
                </div>
            </div>
            
            <!-- Promoción Ginecología -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative">
                    <img src="/images/Ginecología.jpeg?height=300&width=500" alt="Ginecología" class="w-full h-48 object-cover">
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
            
            <!-- Promoción Neurología -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="relative">
                    <img src="/images/neurologico.webp?height=300&width=500" alt="Neurología" class="w-full h-48 object-cover">
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
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                <span>Evaluación cognitiva</span>
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
            
            <!-- Promoción Pediátrica -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden md:col-span-2 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="flex flex-col md:flex-row h-full">
                    <div class="md:w-2/5 relative">
                        <img src="/images/pediatria.png?height=400&width=500" alt="Consulta Pediátrica" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-baby mr-1"></i>PEDIATRÍA
                        </div>
                    </div>
                    <div class="md:w-3/5 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-secondary-950 mb-2">Control Pediátrico Completo</h3>
                            <p class="text-gray-600 mb-4">Cuidamos la salud de los más pequeños con especialistas en pediatría</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <h4 class="font-semibold text-secondary-950 mb-2">Incluye:</h4>
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Consulta pediátrica</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Control de crecimiento</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                            <span>Evaluación nutricional</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <h4 class="font-semibold text-secondary-950 mb-2">Beneficios:</h4>
                                    <ul class="space-y-1 text-sm">
                                        <li class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-2 text-xs"></i>
                                            <span>Ambiente amigable</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-2 text-xs"></i>
                                            <span>Pediatras especializados</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="fas fa-star text-yellow-500 mr-2 text-xs"></i>
                                            <span>Seguimiento personalizado</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-3xl font-bold text-primary-950">S/. 80</span>
                                <span class="text-lg text-gray-500 line-through ml-2">S/. 120</span>
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold ml-2">
                                    33% DSCTO
                                </span>
                            </div>
                            <a href="tel:+51993521429" class="bg-primary-950 text-white py-2 px-6 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                                <i class="fas fa-phone mr-2"></i>Llamar para reservar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botón para ver más promociones -->
        <div class="text-center mt-10">
            <a href="#" class="inline-flex items-center justify-center border-2 border-secondary-950 text-secondary-950 px-8 py-3 rounded-lg font-semibold hover:bg-secondary-950 hover:text-white transition-colors">
                Ver todas las promociones
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Sección de Paquetes Preventivos con Tabs -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1 bg-blue-100 text-secondary-950 rounded-full text-sm font-semibold mb-3">PAQUETES PREVENTIVOS</span>
            <h2 class="text-3xl md:text-4xl font-bold text-secondary-950 mb-4">
                Cuida tu salud con nuestros paquetes
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Diseñados por especialistas para cubrir tus necesidades específicas de salud</p>
        </div>
        
        <!-- Tabs de Categorías -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-4 mb-8" id="paquetes-tabs">
                <button class="tab-btn active px-6 py-3 rounded-full font-semibold transition-colors" data-tab="general">
                    <i class="fas fa-user-md mr-2"></i>General
                </button>
                <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-colors" data-tab="mujer">
                    <i class="fas fa-female mr-2"></i>Mujer
                </button>
                <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-colors" data-tab="hombre">
                    <i class="fas fa-male mr-2"></i>Hombre
                </button>
                <button class="tab-btn px-6 py-3 rounded-full font-semibold transition-colors" data-tab="senior">
                    <i class="fas fa-user-friends mr-2"></i>Adulto Mayor
                </button>
            </div>
            
            <!-- Contenido de los Tabs -->
            <div class="tab-content active" id="tab-general">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Paquete Básico -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="bg-secondary-950 text-white p-6 text-center">
                            <h3 class="text-xl font-bold mb-1">Paquete Básico</h3>
                            <div class="text-3xl font-bold">S/. 199</div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Consulta médica general</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Hemograma completo</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Glucosa</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Perfil lipídico</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Examen de orina</span>
                                </li>
                            </ul>
                            <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Paquete%20Básico" target="_blank" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-green-700 transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>Consultar
                            </a>
                        </div>
                    </div>
                    
                    <!-- Paquete Completo -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-primary-950 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl relative">
                        <div class="absolute top-0 right-0 bg-primary-950 text-white px-4 py-1 rounded-bl-lg text-sm font-semibold">
                            RECOMENDADO
                        </div>
                        <div class="bg-primary-950 text-white p-6 text-center">
                            <h3 class="text-xl font-bold mb-1">Paquete Completo</h3>
                            <div class="text-3xl font-bold">S/. 349</div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Todo lo del paquete básico</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Electrocardiograma</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Radiografía de tórax</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluación nutricional</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Consulta con especialista</span>
                                </li>
                            </ul>
                            <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="w-full bg-primary-950 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                <i class="fas fa-calendar-check mr-2"></i>Agendar
                            </a>
                        </div>
                    </div>
                    
                    <!-- Paquete Premium -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="bg-gradient-to-r from-secondary-950 to-primary-950 text-white p-6 text-center">
                            <h3 class="text-xl font-bold mb-1">Paquete Premium</h3>
                            <div class="text-3xl font-bold">S/. 599</div>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Todo lo del paquete completo</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Ecografía abdominal</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Prueba de esfuerzo</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluación oftalmológica</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span>Evaluación dermatológica</span>
                                </li>
                            </ul>
                            <a href="tel:+51993521429" class="w-full bg-secondary-950 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                <i class="fas fa-phone mr-2"></i>Llamar para reservar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-content hidden" id="tab-mujer">
                <!-- Contenido para mujeres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Paquete Ginecológico -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Ginecológico" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Ginecológico</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 280</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta ginecológica</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Papanicolaou</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Ecografía transvaginal</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Examen de mamas</span>
                                    </li>
                                </ul>
                                
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Paquete%20Ginecológico" target="_blank" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>Consultar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paquete Mamografía -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Mamografía" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Mamografía</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 320</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta especializada</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Mamografía bilateral</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Ecografía de mamas</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Informe médico detallado</span>
                                    </li>
                                </ul>
                                
                                <a href="tel:+51993521429" class="w-full bg-primary-950 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-phone mr-2"></i>Llamar para reservar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-content hidden" id="tab-hombre">
                <!-- Contenido para hombres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Paquete Urológico -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Urológico" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Urológico</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 260</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta urológica</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Ecografía prostática</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Antígeno prostático (PSA)</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Examen de orina</span>
                                    </li>
                                </ul>
                                
                                <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="w-full bg-secondary-950 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-calendar-check mr-2"></i>Agendar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paquete Cardiovascular -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Cardiovascular" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Cardiovascular</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 350</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta cardiológica</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Electrocardiograma</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Ecocardiograma</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Perfil lipídico completo</span>
                                    </li>
                                </ul>
                                
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Paquete%20Cardiovascular" target="_blank" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>Consultar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-content hidden" id="tab-senior">
                <!-- Contenido para adultos mayores -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Paquete Geriátrico -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Geriátrico" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Geriátrico</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 290</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta geriátrica</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Evaluación cognitiva</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Electrocardiograma</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Perfil bioquímico</span>
                                    </li>
                                </ul>
                                
                                <a href="tel:+51993521429" class="w-full bg-primary-950 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-opacity-90 transition-colors">
                                    <i class="fas fa-phone mr-2"></i>Llamar para reservar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paquete Osteoporosis -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="flex flex-col md:flex-row h-full">
                            <div class="md:w-2/5 relative">
                                <img src="/placeholder.svg?height=400&width=400" alt="Paquete Osteoporosis" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-3/5 p-6">
                                <h3 class="text-xl font-bold text-secondary-950 mb-2">Paquete Osteoporosis</h3>
                                <div class="text-2xl font-bold text-primary-950 mb-4">S/. 320</div>
                                
                                <ul class="space-y-2 mb-6">
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Consulta traumatológica</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Densitometría ósea</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Radiografía de columna</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span>Análisis de calcio y vitamina D</span>
                                    </li>
                                </ul>
                                
                                <a href="https://wa.me/51993521429?text=Hola,%20me%20interesa%20el%20Paquete%20Osteoporosis" target="_blank" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center block hover:bg-green-700 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i>Consultar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Información de Contacto -->
<section class="py-16 bg-gradient-to-r from-primary-950 to-secondary-950 text-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">¿Necesitas más información?</h2>
                <p class="text-xl mb-8 opacity-90">
                    Nuestro equipo de atención al cliente está listo para resolver todas tus dudas
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Visítanos</h3>
                            <p>Av. Gran Chimú 085, Zárate - San Juan de Lurigancho</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Llámanos</h3>
                            <p>+51 993 521 429</p>
                            <p>+51 (01) 459-0000</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-2">Horario de Atención</h3>
                            <p>Lunes a Sábado: 7:00 am - 9:00 pm</p>
                            <p>Domingos: 7:00 am - 7:00 pm</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="https://wa.me/51993521429" target="_blank" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                    <a href="https://citasweb.clinicalaluz.pe/" target="_blank" class="bg-white text-primary-950 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-calendar-check mr-2"></i>Agendar Cita
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h3 class="text-2xl font-bold text-secondary-950 mb-6">Solicita información</h3>
                <form>
                    <div class="space-y-4">
                        <div>
                            <label for="nombre" class="block text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" id="nombre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950">
                        </div>
                        <div>
                            <label for="telefono" class="block text-gray-700 mb-2">Teléfono</label>
                            <input type="tel" id="telefono" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950">
                        </div>
                        <div>
                            <label for="servicio" class="block text-gray-700 mb-2">Servicio de interés</label>
                            <select id="servicio" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950">
                                <option value="">Selecciona un servicio</option>
                                <option value="chequeo">Chequeo Médico</option>
                                <option value="cardiologia">Cardiología</option>
                                <option value="ginecologia">Ginecología</option>
                                <option value="neurologia">Neurología</option>
                                <option value="pediatria">Pediatría</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div>
                            <label for="mensaje" class="block text-gray-700 mb-2">Mensaje</label>
                            <textarea id="mensaje" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary-950 text-white py-3 px-6 rounded-lg font-semibold hover:bg-opacity-90 transition-colors">
                            Enviar solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Funcionalidad para los tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remover clase active de todos los botones
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('bg-primary-950');
                btn.classList.remove('text-white');
                btn.classList.add('bg-gray-100');
                btn.classList.add('text-gray-700');
            });
            
            // Agregar clase active al botón clickeado
            button.classList.add('active');
            button.classList.add('bg-primary-950');
            button.classList.add('text-white');
            button.classList.remove('bg-gray-100');
            button.classList.remove('text-gray-700');
            
            // Ocultar todos los contenidos
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            
            // Mostrar el contenido correspondiente
            const tabId = button.getAttribute('data-tab');
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('active');
        });
    });
    
    // Activar el primer tab por defecto
    document.querySelector('.tab-btn.active').classList.add('bg-primary-950');
    document.querySelector('.tab-btn.active').classList.add('text-white');
    document.querySelector('.tab-btn.active').classList.remove('bg-gray-100');
    document.querySelector('.tab-btn.active').classList.remove('text-gray-700');
});
</script>

<style>
/* Estilos para los tabs */
.tab-btn {
    background-color: #f3f4f6;
    color: #4b5563;
}

.tab-btn.active {
    background-color: #b11a1a;
    color: white;
}

/* Animaciones para las tarjetas */
.transform {
    transition: all 0.3s ease;
}

/* Estilos para las listas de características */
.fas.fa-check-circle {
    color: #10b981;
}

/* Estilos para los botones */
.btn-primary {
    background-color: #b11a1a;
}
.btn-primary:hover {
    background-color: #8b1515;
}

/* Transiciones suaves */
.transition-all {
    transition: all 0.3s ease;
}

/* Animación para las tarjetas al pasar el mouse */
.hover\:-translate-y-1:hover {
    transform: translateY(-4px);
}
</style>
@endsection
