<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catálogo de Productos - Clínica La Luz')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Configuración personalizada de Tailwind con tus colores -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            950: '#b11a1a', // Tu color primario
                        },
                        secondary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#0d3049', // Tu color secundario
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .star-rating {
            color: #fbbf24;
        }
        .custom-gradient {
            background: linear-gradient(135deg, #b11a1a 0%, #0d3049 100%);
        }
        .search-container {
            position: relative;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            max-height: 300px;
            overflow-y: auto;
            z-index: 50;
            display: none;
        }
        .search-results.show {
            display: block;
        }
        .btn-primary {
            background-color: #b11a1a;
            border-color: #b11a1a;
        }
        .btn-primary:hover {
            background-color: #991b1b;
            border-color: #991b1b;
        }
        .btn-secondary {
            background-color: #0d3049;
            border-color: #0d3049;
        }
        .btn-secondary:hover {
            background-color: #075985;
            border-color: #075985;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header Superior -->
    <div class="bg-primary-950 text-white text-sm py-2">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-2 md:mb-0">
                    <span><i class="fas fa-map-marker-alt mr-1"></i>Sede en Lima, Chiclayo y Tacna</span>
                    <span><i class="fas fa-envelope mr-1"></i>atencionalpaciente@clinicalaluz.com.pe</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span><i class="fas fa-phone mr-1"></i>Para casos de Lima llamar: (01) 613 9292</span>
                    <div class="flex space-x-2">
                        <a href="#" class="hover:text-gray-200 transition-colors"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-gray-200 transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-gray-200 transition-colors"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="hover:text-gray-200 transition-colors"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Principal -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('catalogo.index') }}" class="flex items-center">
                       
                        <div>
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Clínica La Luz" class="h-10">
                        </div>
                    </a>
                </div>
                
                <!-- Buscador -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="search-container w-full">
                        <form action="{{ route('catalogo.index') }}" method="GET" class="relative">
                            <input type="text" 
                                   name="search" 
                                   id="searchInput"
                                   value="{{ request('search') }}"
                                   placeholder="Buscar productos, códigos, medicamentos..." 
                                   class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950 focus:border-transparent">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-secondary-950 hover:text-primary-950 transition-colors">
                                <i class="fas fa-search text-lg"></i>
                            </button>
                        </form>
                        <div id="searchResults" class="search-results"></div>
                    </div>
                </div>
                
                <nav class="hidden lg:flex space-x-6">
                    <a href="{{ route('catalogo.index') }}" class="text-secondary-950 hover:text-primary-950 font-medium transition-colors">
                        Inicio
                    </a>
                    <a href="/promociones" class="text-secondary-950 hover:text-primary-950 font-medium transition-colors">
                        Promociones
                    </a>
                    <a href="#" class="text-secondary-950 hover:text-primary-950 font-medium transition-colors">
                        Especialidades
                    </a>
                    <a href="#" class="text-secondary-950 hover:text-primary-950 font-medium transition-colors">
                        Nosotros
                    </a>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <button class="md:hidden text-secondary-950 hover:text-primary-950 transition-colors" onclick="toggleMobileSearch()">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                    {{-- <button class="text-secondary-950 hover:text-primary-950 relative transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-primary-950 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button> --}}
                    <a href="https://citasweb.clinicalaluz.pe/ " class="btn-primary text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-calendar-plus mr-2"></i>AGENDAR CITA
                    </a>
                </div>
            </div>
            
            <!-- Buscador móvil -->
            <div id="mobileSearch" class="md:hidden pb-4 hidden">
                <form action="{{ route('catalogo.index') }}" method="GET" class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar productos..." 
                           class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-950">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-secondary-950">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary-950 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="mb-6">
                           <img src="{{ asset('images/logo1.png') }}" alt="Logo">
                    </div>
                    <p class="text-gray-300">8 sedes para cuidar tu salud en todo el Perú.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Especialidades</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Cardiología</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Neurología</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pediatría</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Ginecología</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Servicios</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Emergencias 24h</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Laboratorio</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Imágenes</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Farmacia</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contacto</h4>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i>(01) 613 9292</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@clinicaluz.com</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 Clínica La Luz. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        function addToCart(productCode, productName) {
            // Mostrar notificación más elegante
            showNotification(`${productName} agregado al carrito!`, 'success');
        }

        function filterProducts(category) {
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        function toggleMobileSearch() {
            const mobileSearch = document.getElementById('mobileSearch');
            mobileSearch.classList.toggle('hidden');
        }

        function showNotification(message, type = 'info') {
            // Crear notificación toast
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full`;
            
            if (type === 'success') {
                notification.classList.add('bg-green-500');
            } else if (type === 'error') {
                notification.classList.add('bg-red-500');
            } else {
                notification.classList.add('bg-blue-500');
            }
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Mostrar notificación
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Ocultar después de 3 segundos
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Búsqueda en tiempo real (opcional)
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const query = e.target.value;
            if (query.length > 2) {
                console.log('Buscando:', query);
            }
        });
    </script>
</body>
</html>