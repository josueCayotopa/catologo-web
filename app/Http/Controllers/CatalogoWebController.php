<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CatalogoWeb;
use App\Models\MaeSucursal;
use App\Models\CveEspecialidad;

class CatalogoWebController extends Controller
{
    /**
     * Mostrar el catálogo principal usando CATALOGO_WEB como base
     */
    public function index(Request $request)
    {
        // Parámetros de filtros
        $sucursal = $request->get('sucursal', '004');
        $search = $request->get('search');
        $especialidad = $request->get('especialidad');
        $categoria = $request->get('categoria');
        $precio_min = $request->get('precio_min');
        $precio_max = $request->get('precio_max');
        $solo_promociones = $request->get('promociones');
        $solo_destacados = $request->get('destacados');
        $perPage = 20;

        // Obtener sucursales disponibles
        $sucursales = $this->getSucursalesFromCatalogo();
        $sucursalActual = $sucursales->where('COD_SUCURSAL', $sucursal)->first();

        // Obtener especialidades disponibles en el catálogo
        $especialidades = $this->getEspecialidadesFromCatalogo($sucursal);

        // Obtener categorías disponibles en el catálogo
        $categorias = $this->getCategoriasFromCatalogo($sucursal);

        // Obtener rangos de precios
        $rangosPrecios = $this->getRangosPreciosFromCatalogo($sucursal);

        // Construir consulta principal
        $query = $this->buildCatalogoQuery($sucursal, $search, $especialidad, $categoria, $precio_min, $precio_max, $solo_promociones, $solo_destacados);

        // Ejecutar consulta con paginación
        $products = $query->paginate($perPage);

        // Transformar productos para la vista
        $transformedProducts = $products->getCollection()->map(function ($product) {
            return $this->transformProductFromCatalogo($product);
        });

        $products->setCollection($transformedProducts);

        // Obtener promociones destacadas
        $promociones = $this->getPromocionesFromCatalogo($sucursal);

        return view('catalogo.index', compact(
            'products',
            'sucursales',
            'sucursalActual',
            'especialidades',
            'categorias',
            'rangosPrecios',
            'promociones',
            'sucursal',
            'search',
            'especialidad',
            'categoria',
            'precio_min',
            'precio_max',
            'solo_promociones',
            'solo_destacados'
        ));
    }

    /**
     * Construir consulta principal usando solo CATALOGO_WEB
     */
    private function buildCatalogoQuery($sucursal, $search, $especialidad, $categoria, $precio_min, $precio_max, $solo_promociones, $solo_destacados)
    {
        $query = DB::table('CATALOGO_WEB')
            ->select([
                'COD_ARTICULO_SERV', 'DES_ARTICULO', 'DES_CORTA',
                'PRECIO_MOSTRAR', 'PRECIO_PROMOCION', 'MONEDA',
                'IMAGEN_URL', 'IND_PROMOCION', 'IND_DESTACADO',
                'COD_ESPECIALIDAD', 'CATEGORIA', 'TIPO_SERVICIO',
                'ORDEN_MOSTRAR', 'FECHA_INICIO_PROMO', 'FECHA_FIN_PROMO',
                'DISPONIBLE', 'DURACION_ESTIMADA', 'REQUIERE_CITA'
            ])
            ->where('COD_SUCURSAL', $sucursal)
            ->where('ESTADO', 'A')
            ->where('DISPONIBLE', 'S'); // Solo productos disponibles

        // Filtro de búsqueda
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('DES_ARTICULO', 'LIKE', "%{$search}%")
                  ->orWhere('DES_CORTA', 'LIKE', "%{$search}%")
                  ->orWhere('COD_ARTICULO_SERV', 'LIKE', "%{$search}%")
                  ->orWhere('PALABRAS_CLAVE', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por especialidad
        if ($especialidad && $especialidad !== 'all') {
            $query->where('COD_ESPECIALIDAD', $especialidad);
        }

        // Filtro por categoría
        if ($categoria && $categoria !== 'all') {
            $query->where('CATEGORIA', $categoria);
        }

        // Filtro por rango de precios
        if ($precio_min) {
            $query->where('PRECIO_MOSTRAR', '>=', $precio_min);
        }
        if ($precio_max) {
            $query->where('PRECIO_MOSTRAR', '<=', $precio_max);
        }

        // Solo promociones
        if ($solo_promociones) {
            $query->where('IND_PROMOCION', 'S')
                  ->whereNotNull('PRECIO_PROMOCION')
                  ->where('PRECIO_PROMOCION', '>', 0);
        }

        // Solo destacados
        if ($solo_destacados) {
            $query->where('IND_DESTACADO', 'S');
        }

        // Ordenamiento
        $query->orderByRaw('IND_DESTACADO DESC, IND_PROMOCION DESC, ORDEN_MOSTRAR ASC, DES_ARTICULO ASC');

        return $query;
    }

    /**
     * Obtener sucursales desde CATALOGO_WEB
     */
    private function getSucursalesFromCatalogo($categoria = null)
    {
        try {
            $query = DB::table('CATALOGO_WEB')
                ->select('COD_SUCURSAL')
                ->where('ESTADO', 'A');

            // Filtrar por categoría si se especifica
            if ($categoria) {
                $query->where('CATEGORIA', $categoria);
            }

            $sucursalesEnCatalogo = $query->distinct()->pluck('COD_SUCURSAL');

            return MaeSucursal::select(['COD_SUCURSAL', 'NOM_SUCURSAL', 'DES_DIRECCION', 'NUM_TELEFONO'])
                ->whereIn('COD_SUCURSAL', $sucursalesEnCatalogo)
                ->where('IND_BAJA', 'N')
                ->orderBy('NOM_SUCURSAL')
                ->get()
                ->map(function($sucursal) {
                    return (object)[
                        'COD_SUCURSAL' => $sucursal->COD_SUCURSAL,
                        'NOM_SUCURSAL' => $sucursal->NOM_SUCURSAL,
                        'CIUDAD' => $this->extractCiudad($sucursal->NOM_SUCURSAL),
                        'DIRECCION' => $sucursal->DES_DIRECCION ?? $sucursal->NOM_SUCURSAL,
                        'TELEFONO' => $sucursal->NUM_TELEFONO
                    ];
                });
        } catch (\Exception $e) {
            return collect([
                (object)[
                    'COD_SUCURSAL' => '004',
                    'NOM_SUCURSAL' => 'Zárate',
                    'CIUDAD' => 'Zárate',
                    'DIRECCION' => 'Av. Gran Chimú 085, Zárate',
                    'TELEFONO' => '993521429'
                ]
            ]);
        }
    }

    /**
     * Obtener especialidades desde CATALOGO_WEB
     */
    private function getEspecialidadesFromCatalogo($sucursal)
    {
        try {
            $especialidadesEnCatalogo = DB::table('CATALOGO_WEB')
                ->select('COD_ESPECIALIDAD')
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->whereNotNull('COD_ESPECIALIDAD')
                ->distinct()
                ->pluck('COD_ESPECIALIDAD');

            if ($especialidadesEnCatalogo->isEmpty()) {
                return collect();
            }

            return CveEspecialidad::select(['COD_ESPECIALIDAD', 'DES_ESPECIALIDAD'])
                ->whereIn('COD_ESPECIALIDAD', $especialidadesEnCatalogo)
                ->where('TIP_ESTADO', 'ACT')
                ->orderBy('DES_ESPECIALIDAD')
                ->get()
                ->map(function($especialidad) {
                    return (object)[
                        'COD_ESPECIALIDAD' => $especialidad->COD_ESPECIALIDAD,
                        'NOM_ESPECIALIDAD' => $especialidad->DES_ESPECIALIDAD,
                        'COLOR' => $this->getEspecialidadColor($especialidad->COD_ESPECIALIDAD),
                        'ICONO' => $this->getEspecialidadIcon($especialidad->COD_ESPECIALIDAD)
                    ];
                })->keyBy('COD_ESPECIALIDAD');
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Obtener categorías desde CATALOGO_WEB
     */
    private function getCategoriasFromCatalogo($sucursal)
    {
        try {
            return DB::table('CATALOGO_WEB')
                ->select('CATEGORIA', DB::raw('COUNT(*) as total'))
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->whereNotNull('CATEGORIA')
                ->where('CATEGORIA', '!=', '')
                ->groupBy('CATEGORIA')
                ->orderBy('CATEGORIA')
                ->get()
                ->map(function($categoria) {
                    return (object)[
                        'CODIGO' => $categoria->CATEGORIA,
                        'NOMBRE' => $this->getNombreCategoria($categoria->CATEGORIA),
                        'TOTAL' => $categoria->total,
                        'ICONO' => $this->getIconoCategoria($categoria->CATEGORIA)
                    ];
                });
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Obtener rangos de precios desde CATALOGO_WEB
     */
    private function getRangosPreciosFromCatalogo($sucursal)
    {
        try {
            $precios = DB::table('CATALOGO_WEB')
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->selectRaw('MIN(PRECIO_MOSTRAR) as min_precio, MAX(PRECIO_MOSTRAR) as max_precio')
                ->first();

            if (!$precios) {
                return collect();
            }

            return collect([
                ['min' => 0, 'max' => 50, 'label' => 'Hasta S/. 50'],
                ['min' => 50, 'max' => 100, 'label' => 'S/. 50 - S/. 100'],
                ['min' => 100, 'max' => 200, 'label' => 'S/. 100 - S/. 200'],
                ['min' => 200, 'max' => 500, 'label' => 'S/. 200 - S/. 500'],
                ['min' => 500, 'max' => 9999, 'label' => 'Más de S/. 500']
            ]);
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Obtener promociones desde CATALOGO_WEB
     */
    private function getPromocionesFromCatalogo($sucursal)
    {
        try {
            $promociones = DB::table('CATALOGO_WEB')
                ->select([
                    'COD_ARTICULO_SERV', 'DES_ARTICULO', 'PRECIO_MOSTRAR',
                    'PRECIO_PROMOCION', 'IMAGEN_URL', 'COD_ESPECIALIDAD'
                ])
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->where('IND_PROMOCION', 'S')
                ->whereNotNull('PRECIO_PROMOCION')
                ->where('PRECIO_PROMOCION', '>', 0)
                ->orderBy('ORDEN_MOSTRAR')
                ->limit(6)
                ->get();

            return $promociones->map(function($promo) {
                return [
                    'codigo' => $promo->COD_ARTICULO_SERV,
                    'nombre' => $promo->DES_ARTICULO,
                    'precio' => $promo->PRECIO_PROMOCION,
                    'precio_original' => $promo->PRECIO_MOSTRAR,
                    'ahorro' => $promo->PRECIO_MOSTRAR - $promo->PRECIO_PROMOCION,
                    'imagen' => $promo->IMAGEN_URL,
                    'especialidad' => $promo->COD_ESPECIALIDAD
                ];
            });
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Transformar producto desde CATALOGO_WEB
     */
    private function transformProductFromCatalogo($product)
    {
        $tienePromocion = $product->IND_PROMOCION === 'S' && !empty($product->PRECIO_PROMOCION);

        return [
            'id' => $product->COD_ARTICULO_SERV,
            'codigo' => $product->COD_ARTICULO_SERV,
            'nombre' => $product->DES_ARTICULO,
            'descripcion' => $product->DES_CORTA ?? $product->DES_ARTICULO,
            'precio' => $product->PRECIO_MOSTRAR,
            'precio_promocion' => $tienePromocion ? $product->PRECIO_PROMOCION : null,
            'moneda' => $this->getMonedaSymbol($product->MONEDA ?? 'PEN'),
            'image' => $this->getProductImage($product->IMAGEN_URL),
            'promocion' => $tienePromocion,
            'destacado' => $product->IND_DESTACADO === 'S',
            'especialidad' => $this->getEspecialidadName($product->COD_ESPECIALIDAD),
            'cod_especialidad' => $product->COD_ESPECIALIDAD,
            'color_especialidad' => $this->getEspecialidadColor($product->COD_ESPECIALIDAD),
            'icono_especialidad' => $this->getEspecialidadIcon($product->COD_ESPECIALIDAD),
            'categoria' => $product->CATEGORIA,
            'nombre_categoria' => $this->getNombreCategoria($product->CATEGORIA),
            'tipo_servicio' => $product->TIPO_SERVICIO ?? 'Servicio Médico',
            'duracion_estimada' => $product->DURACION_ESTIMADA ?? '30 min',
            'requiere_cita' => $product->REQUIERE_CITA === 'S',
            'disponible' => $product->DISPONIBLE === 'S',
            'orden' => $product->ORDEN_MOSTRAR ?? 999
        ];
    }

    /**
     * Transformar producto para vista detallada
     */
    private function transformProductForShow($product)
    {
        $tienePromocion = $product->IND_PROMOCION === 'S' && !empty($product->PRECIO_PROMOCION);
        $esServicioConStock = in_array($product->CATEGORIA, ['LABORATORIO', 'IMAGEN', 'PROCEDIMIENTO']);

        return [
            'id' => $product->COD_ARTICULO_SERV,
            'codigo' => $product->COD_ARTICULO_SERV,
            'nombre' => $product->DES_ARTICULO,
            'descripcion' => $product->DES_CORTA ?? $product->DES_ARTICULO,
            'descripcion_larga' => $product->META_DESCRIPCION ?? $product->DES_CORTA,
            'precio' => $product->PRECIO_MOSTRAR,
            'precio_promocion' => $tienePromocion ? $product->PRECIO_PROMOCION : null,
            'moneda' => $this->getMonedaSymbol($product->MONEDA ?? 'PEN'),
            'image' => $this->getProductImage($product->IMAGEN_URL),
            'promocion' => $tienePromocion,
            'destacado' => $product->IND_DESTACADO === 'S',
            'especialidad' => $this->getEspecialidadName($product->COD_ESPECIALIDAD),
            'cod_especialidad' => $product->COD_ESPECIALIDAD,
            'color_especialidad' => $this->getEspecialidadColor($product->COD_ESPECIALIDAD),
            'icono_especialidad' => $this->getEspecialidadIcon($product->COD_ESPECIALIDAD),
            'categoria' => $product->CATEGORIA,
            'nombre_categoria' => $this->getNombreCategoria($product->CATEGORIA),
            'tipo_servicio' => $product->TIPO_SERVICIO ?? 'Servicio Médico',
            'duracion_estimada' => $product->DURACION_ESTIMADA ?? '30 min',
            'requiere_cita' => $product->REQUIERE_CITA === 'S',
            'disponible' => $product->DISPONIBLE === 'S',
            'horario_disponible' => $product->HORARIO_DISPONIBLE,
            'dias_disponible' => $product->DIAS_DISPONIBLE ? explode(',', $product->DIAS_DISPONIBLE) : [],
            'tiene_stock' => $esServicioConStock,
            'stock_disponible' => $product->STOCK_DISPONIBLE ?? 999,
            'es_consulta' => $product->CATEGORIA === 'CONSULTA',
            'es_emergencia' => $product->CATEGORIA === 'EMERGENCIA',
            'palabras_clave' => $product->PALABRAS_CLAVE,
        ];
    }

    /**
     * Obtener servicios relacionados
     */
    private function getRelatedServices($especialidad, $sucursal, $excludeId, $limit = 3)
    {
        try {
            $related = DB::table('CATALOGO_WEB')
                ->select([
                    'COD_ARTICULO_SERV', 'DES_ARTICULO', 'DES_CORTA',
                    'PRECIO_MOSTRAR', 'PRECIO_PROMOCION', 'IND_PROMOCION',
                    'IMAGEN_URL', 'CATEGORIA', 'TIPO_SERVICIO'
                ])
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S')
                ->where('COD_ARTICULO_SERV', '!=', $excludeId)
                ->where(function($query) use ($especialidad) {
                    $query->where('COD_ESPECIALIDAD', $especialidad)
                          ->orWhere('IND_DESTACADO', 'S');
                })
                ->orderByRaw('COD_ESPECIALIDAD = ? DESC, IND_DESTACADO DESC, ORDEN_MOSTRAR ASC', [$especialidad])
                ->limit($limit)
                ->get();

            return $related->map(function($service) {
                return [
                    'codigo' => $service->COD_ARTICULO_SERV,
                    'nombre' => $service->DES_ARTICULO,
                    'descripcion' => $service->DES_CORTA,
                    'precio' => $service->PRECIO_MOSTRAR,
                    'precio_promocion' => ($service->IND_PROMOCION === 'S') ? $service->PRECIO_PROMOCION : null,
                    'promocion' => $service->IND_PROMOCION === 'S',
                    'moneda' => 'S/.',
                    'image' => $this->getProductImage($service->IMAGEN_URL),
                    'tipo_servicio' => $service->TIPO_SERVICIO ?? 'Servicio Médico'
                ];
            });
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Obtener información de la sucursal
     */
    private function getSucursalInfo($codSucursal)
    {
        try {
            $sucursal = DB::table('MAE_SUCURSAL')
                ->select(['COD_SUCURSAL', 'NOM_SUCURSAL', 'DES_DIRECCION', 'NUM_TELEFONO'])
                ->where('COD_SUCURSAL', $codSucursal)
                ->where('IND_BAJA', 'N')
                ->first();

            if ($sucursal) {
                return [
                    'codigo' => $sucursal->COD_SUCURSAL,
                    'nombre' => $sucursal->NOM_SUCURSAL,
                    'direccion' => $sucursal->DES_DIRECCION,
                    'telefono' => $sucursal->NUM_TELEFONO,
                    'whatsapp' => $this->formatWhatsAppNumber($sucursal->NUM_TELEFONO)
                ];
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return [
            'codigo' => '004',
            'nombre' => 'Zárate',
            'direccion' => 'Av. Gran Chimú 085, Zárate',
            'telefono' => '993521429',
            'whatsapp' => '51993521429'
        ];
    }

    private function formatWhatsAppNumber($telefono)
    {
        if (empty($telefono)) return '51993521429';

        // Limpiar el número
        $numero = preg_replace('/[^0-9]/', '', $telefono);

        // Si no empieza con 51, agregarlo
        if (!str_starts_with($numero, '51')) {
            $numero = '51' . $numero;
        }

        return $numero;
    }

    /**
     * Mostrar detalle del servicio médico
     */
    public function show(Request $request, $codArticulo)
    {
        $sucursal = $request->get('sucursal', '004');

        try {
            $product = DB::table('CATALOGO_WEB')
                ->select([
                    'COD_ARTICULO_SERV', 'DES_ARTICULO', 'DES_CORTA',
                    'PRECIO_MOSTRAR', 'PRECIO_PROMOCION', 'MONEDA',
                    'IMAGEN_URL', 'IND_PROMOCION', 'IND_DESTACADO',
                    'COD_ESPECIALIDAD', 'CATEGORIA', 'TIPO_SERVICIO',
                    'DURACION_ESTIMADA', 'REQUIERE_CITA', 'DISPONIBLE',
                    'HORARIO_ESPECIAL', 'DIAS_DISPONIBLE', 'STOCK_DISPONIBLE',
                    'META_DESCRIPCION', 'PALABRAS_CLAVE'
                ])
                ->where('COD_ARTICULO_SERV', $codArticulo)
                ->where('COD_SUCURSAL', $sucursal)
                ->where('ESTADO', 'A')
                ->first();

            if (!$product) {
                abort(404, 'Servicio no encontrado');
            }

            $productTransformed = $this->transformProductForShow($product);

            // Obtener servicios relacionados de la misma especialidad
            $relatedProducts = $this->getRelatedServices($product->COD_ESPECIALIDAD, $sucursal, $codArticulo);

            // Obtener información de la sucursal
            $sucursalInfo = $this->getSucursalInfo($sucursal);

            return view('catalogo.show', compact(
                'productTransformed',
                'relatedProducts',
                'sucursalInfo'
            ));
        } catch (\Exception $e) {
            \Log::error('Error en show: ' . $e->getMessage());
            abort(404, 'Error al cargar el servicio');
        }
    }

    /**
     * Mostrar servicios de laboratorio
     */
    public function laboratorio(Request $request)
    {
        try {
            $sucursal = $request->get('sucursal');
            $tipo_analisis = $request->get('tipo_analisis');
            $search = $request->get('search');

            // Obtener sucursales que tienen servicios de laboratorio en CATALOGO_WEB
            $sucursales = $this->getSucursalesFromCatalogo('LABORATORIO');

            // Definir sucursal actual
            $sucursalActual = null;
            if ($sucursal) {
                $sucursalActual = $sucursales->where('COD_SUCURSAL', $sucursal)->first();
            }

            // Si no hay sucursal seleccionada o no se encuentra, usar la primera disponible
            if (!$sucursalActual) {
                $sucursalActual = $sucursales->first();
                if ($sucursalActual) {
                    $sucursal = $sucursalActual->COD_SUCURSAL;
                }
            }

            // Si no hay sucursales con servicios de laboratorio, mostrar mensaje
            if ($sucursales->isEmpty()) {
                return view('catalogo.laboratorio')->with([
                    'error' => 'No hay servicios de laboratorio disponibles en este momento',
                    'sucursales' => collect(),
                    'procedimientos' => collect(),
                    'tiposAnalisis' => collect(),
                    'paquetesLab' => collect()
                ]);
            }

            // Obtener tipos de análisis disponibles con conteos
            $tiposAnalisisQuery = DB::table('CATALOGO_WEB')
                ->where('CATEGORIA', 'LABORATORIO')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S')
                ->whereNotNull('SUBCATEGORIA')
                ->where('SUBCATEGORIA', '!=', '');

            if ($sucursal) {
                $tiposAnalisisQuery->where('COD_SUCURSAL', $sucursal);
            }

            $tiposAnalisisData = $tiposAnalisisQuery
                ->select('SUBCATEGORIA', DB::raw('COUNT(*) as total'))
                ->groupBy('SUBCATEGORIA')
                ->get();

            // Mapear tipos de análisis con iconos
            $tiposAnalisis = $tiposAnalisisData->map(function($tipo) {
                $iconos = [
                    'HEMATOLOGIA' => 'fas fa-tint',
                    'BIOQUIMICA' => 'fas fa-flask',
                    'MICROBIOLOGIA' => 'fas fa-microscope',
                    'INMUNOLOGIA' => 'fas fa-shield-alt',
                    'HORMONAS' => 'fas fa-dna',
                    'ORINA' => 'fas fa-vial',
                    'HECES' => 'fas fa-search',
                    'GENETICA' => 'fas fa-dna',
                    'TOXICOLOGIA' => 'fas fa-exclamation-triangle'
                ];

                return [
                    'codigo' => $tipo->SUBCATEGORIA,
                    'nombre' => ucfirst(strtolower($tipo->SUBCATEGORIA)),
                    'total' => $tipo->total,
                    'icono' => $iconos[$tipo->SUBCATEGORIA] ?? 'fas fa-flask'
                ];
            });

            // Obtener procedimientos de laboratorio
            $procedimientosQuery = DB::table('CATALOGO_WEB')
                ->where('CATEGORIA', 'LABORATORIO')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S');

            if ($sucursal) {
                $procedimientosQuery->where('COD_SUCURSAL', $sucursal);
            }

            if ($tipo_analisis && $tipo_analisis !== 'all') {
                $procedimientosQuery->where('SUBCATEGORIA', $tipo_analisis);
            }

            if ($search) {
                $procedimientosQuery->where(function($q) use ($search) {
                    $q->where('DES_ARTICULO', 'LIKE', "%{$search}%")
                      ->orWhere('DES_CORTA', 'LIKE', "%{$search}%")
                      ->orWhere('PALABRAS_CLAVE', 'LIKE', "%{$search}%");
                });
            }

            $procedimientos = $procedimientosQuery
                ->orderBy('IND_DESTACADO', 'DESC')
                ->orderBy('ORDEN_MOSTRAR', 'ASC')
                ->paginate(12);

            // Paquetes de laboratorio (datos de ejemplo)
            $paquetesLab = collect([
                [
                    'nombre' => 'Perfil Básico',
                    'descripcion' => 'Análisis básicos para chequeo general',
                    'precio' => 120.00,
                    'precio_promocion' => 90.00,
                    'promocion' => true,
                    'incluye' => ['Hemograma completo', 'Glucosa', 'Colesterol total', 'Triglicéridos'],
                    'tiempo_entrega' => '24 hrs',
                    'ayuno_requerido' => true
                ],
                [
                    'nombre' => 'Perfil Completo',
                    'descripcion' => 'Análisis completos para evaluación integral',
                    'precio' => 250.00,
                    'precio_promocion' => null,
                    'promocion' => false,
                    'incluye' => ['Hemograma completo', 'Perfil lipídico', 'Función hepática', 'Función renal', 'Examen de orina'],
                    'tiempo_entrega' => '48 hrs',
                    'ayuno_requerido' => true
                ]
            ]);

            return view('catalogo.laboratorio', compact(
                'procedimientos',
                'sucursales',
                'sucursal',
                'sucursalActual',
                'tiposAnalisis',
                'tipo_analisis',
                'search',
                'paquetesLab'
            ));
        } catch (\Exception $e) {
            Log::error('Error en laboratorio: ' . $e->getMessage());
            return view('catalogo.laboratorio')->with('error', 'Error al cargar servicios de laboratorio');
        }
    }

    public function imagen(Request $request)
    {
        try {
            $sucursal = $request->get('sucursal');
            $tipo_estudio = $request->get('tipo_estudio');
            $search = $request->get('search');

            // Obtener sucursales que tienen servicios de imagen en CATALOGO_WEB
            $sucursales = $this->getSucursalesFromCatalogo('IMAGEN');

            // Definir sucursal actual
            $sucursalActual = null;
            if ($sucursal) {
                $sucursalActual = $sucursales->where('COD_SUCURSAL', $sucursal)->first();
            }

            // Si no hay sucursal seleccionada o no se encuentra, usar la primera disponible
            if (!$sucursalActual) {
                $sucursalActual = $sucursales->first();
                if ($sucursalActual) {
                    $sucursal = $sucursalActual->COD_SUCURSAL;
                }
            }

            // Si no hay sucursales con servicios de imagen, mostrar mensaje
            if ($sucursales->isEmpty()) {
                return view('catalogo.imagen')->with([
                    'error' => 'No hay estudios de imagen disponibles en este momento',
                    'sucursales' => collect(),
                    'estudios' => collect(),
                    'tiposEstudio' => collect(),
                    'estudiosDestacados' => collect()
                ]);
            }

            // Obtener tipos de estudios disponibles con conteos
            $tiposEstudiosQuery = DB::table('CATALOGO_WEB')
                ->where('CATEGORIA', 'IMAGEN')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S')
                ->whereNotNull('SUBCATEGORIA')
                ->where('SUBCATEGORIA', '!=', '');

            if ($sucursal) {
                $tiposEstudiosQuery->where('COD_SUCURSAL', $sucursal);
            }

            $tiposEstudiosData = $tiposEstudiosQuery
                ->select('SUBCATEGORIA', DB::raw('COUNT(*) as total'))
                ->groupBy('SUBCATEGORIA')
                ->get();

            // Mapear tipos de estudios con iconos
            $tiposEstudio = $tiposEstudiosData->map(function($tipo) {
                $iconos = [
                    'RADIOGRAFIA' => 'fas fa-x-ray',
                    'ECOGRAFIA' => 'fas fa-heartbeat',
                    'TOMOGRAFIA' => 'fas fa-brain',
                    'RESONANCIA' => 'fas fa-head-side-brain',
                    'MAMOGRAFIA' => 'fas fa-female',
                    'DENSITOMETRIA' => 'fas fa-bone',
                    'ENDOSCOPIA' => 'fas fa-search-plus'
                ];

                return [
                    'codigo' => $tipo->SUBCATEGORIA,
                    'nombre' => ucfirst(strtolower($tipo->SUBCATEGORIA)),
                    'total' => $tipo->total,
                    'icono' => $iconos[$tipo->SUBCATEGORIA] ?? 'fas fa-x-ray'
                ];
            });

            // Obtener estudios de imagen
            $estudiosQuery = DB::table('CATALOGO_WEB')
                ->where('CATEGORIA', 'IMAGEN')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S');

            if ($sucursal) {
                $estudiosQuery->where('COD_SUCURSAL', $sucursal);
            }

            if ($tipo_estudio && $tipo_estudio !== 'all') {
                $estudiosQuery->where('SUBCATEGORIA', $tipo_estudio);
            }

            if ($search) {
                $estudiosQuery->where(function($q) use ($search) {
                    $q->where('DES_ARTICULO', 'LIKE', "%{$search}%")
                      ->orWhere('DES_CORTA', 'LIKE', "%{$search}%")
                      ->orWhere('PALABRAS_CLAVE', 'LIKE', "%{$search}%");
                });
            }

            $estudios = $estudiosQuery
                ->orderBy('IND_DESTACADO', 'DESC')
                ->orderBy('ORDEN_MOSTRAR', 'ASC')
                ->paginate(12);

            // Obtener estudios destacados
            $estudiosDestacadosQuery = DB::table('CATALOGO_WEB')
                ->where('CATEGORIA', 'IMAGEN')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S')
                ->where('IND_DESTACADO', 'S');

            if ($sucursal) {
                $estudiosDestacadosQuery->where('COD_SUCURSAL', $sucursal);
            }

            $estudiosDestacados = $estudiosDestacadosQuery
                ->orderBy('ORDEN_MOSTRAR', 'ASC')
                ->limit(6)
                ->get();

            return view('catalogo.imagen', compact(
                'estudios',
                'sucursales',
                'sucursal',
                'sucursalActual',
                'tiposEstudio',
                'tipo_estudio',
                'search',
                'estudiosDestacados'
            ));
        } catch (\Exception $e) {
            Log::error('Error en imagen: ' . $e->getMessage());
            return view('catalogo.imagen')->with('error', 'Error al cargar estudios de imagen');
        }
    }

    public function promociones(Request $request)
    {
        try {
            $sucursalSeleccionada = $request->get('sucursal');

            // Obtener sucursales que tienen promociones en CATALOGO_WEB
            $sucursalesConPromociones = DB::table('CATALOGO_WEB')
                ->select('COD_SUCURSAL')
                ->where('ESTADO', 'A')
                ->where('IND_PROMOCION', 'S')
                ->distinct()
                ->pluck('COD_SUCURSAL');

            $sucursales = MaeSucursal::select(['COD_SUCURSAL', 'NOM_SUCURSAL', 'DES_DIRECCION'])
                ->whereIn('COD_SUCURSAL', $sucursalesConPromociones)
                ->where('IND_BAJA', 'N')
                ->get();

            // Obtener promociones
            $query = DB::table('CATALOGO_WEB')
                ->where('ESTADO', 'A')
                ->where('DISPONIBLE', 'S')
                ->where('IND_PROMOCION', 'S');

            if ($sucursalSeleccionada) {
                $query->where('COD_SUCURSAL', $sucursalSeleccionada);
            }

            $promociones = $query->orderBy('IND_DESTACADO', 'DESC')
                ->orderBy('ORDEN_MOSTRAR', 'ASC')
                ->paginate(12);

            return view('catalogo.promociones', compact(
                'promociones',
                'sucursales',
                'sucursalSeleccionada'
            ));
        } catch (\Exception $e) {
            Log::error('Error en promociones: ' . $e->getMessage());
            return view('catalogo.promociones')->with('error', 'Error al cargar promociones');
        }
    }

    /**
     * Buscar servicios médicos
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $sucursal = $request->get('sucursal', '004');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = DB::table('CATALOGO_WEB')
            ->select(['COD_ARTICULO_SERV', 'DES_ARTICULO', 'PRECIO_MOSTRAR'])
            ->where('COD_SUCURSAL', $sucursal)
            ->where('ESTADO', 'A')
            ->where(function($q) use ($query) {
                $q->where('DES_ARTICULO', 'LIKE', "%{$query}%")
                  ->orWhere('COD_ARTICULO_SERV', 'LIKE', "%{$query}%")
                  ->orWhere('PALABRAS_CLAVE', 'LIKE', "%{$query}%");
            })
            ->limit(5)
            ->get();

        return response()->json($products->map(function ($product) use ($sucursal) {
            return [
                'id' => $product->COD_ARTICULO_SERV,
                'nombre' => $product->DES_ARTICULO,
                'precio' => $product->PRECIO_MOSTRAR,
                'url' => route('catalogo.show', [
                    'codArticulo' => $product->COD_ARTICULO_SERV,
                    'sucursal' => $sucursal
                ])
            ];
        }));
    }

    // Métodos de utilidad
    private function getMonedaSymbol($codMoneda)
    {
        return ['PEN' => 'S/.', 'USD' => '$', 'EUR' => '€'][$codMoneda] ?? 'S/.';
    }

    private function getProductImage($imagenUrl)
    {
        if (empty($imagenUrl)) {
            return '/placeholder.svg?height=400&width=400&text=Servicio+Médico';
        }
        if (filter_var($imagenUrl, FILTER_VALIDATE_URL)) {
            return $imagenUrl;
        }
        return asset('storage/' . $imagenUrl);
    }

    private function getEspecialidadColor($codEspecialidad)
    {
        $colores = [
            '1' => '#2ecc71', '3' => '#e74c3c', '16' => '#e91e63',
            'LAB' => '#2ecc71', 'FAR' => '#3498db'
        ];
        return $colores[$codEspecialidad] ?? '#6b7280';
    }

    private function getEspecialidadIcon($codEspecialidad)
    {
        $iconos = [
            '1' => 'fas fa-stethoscope', '3' => 'fas fa-heartbeat', '16' => 'fas fa-female',
            'LAB' => 'fas fa-flask', 'FAR' => 'fas fa-pills'
        ];
        return $iconos[$codEspecialidad] ?? 'fas fa-stethoscope';
    }

    private function getNombreCategoria($categoria)
    {
        $nombres = [
            'CONSULTA' => 'Consultas Médicas',
            'LABORATORIO' => 'Análisis de Laboratorio',
            'IMAGEN' => 'Estudios de Imagen',
            'PROCEDIMIENTO' => 'Procedimientos',
            'EMERGENCIA' => 'Emergencias',
            'CIRUGIA' => 'Cirugías'
        ];
        return $nombres[$categoria] ?? $categoria;
    }

    private function getIconoCategoria($categoria)
    {
        $iconos = [
            'CONSULTA' => 'fas fa-user-md',
            'LABORATORIO' => 'fas fa-flask',
            'IMAGEN' => 'fas fa-x-ray',
            'PROCEDIMIENTO' => 'fas fa-procedures',
            'EMERGENCIA' => 'fas fa-ambulance',
            'CIRUGIA' => 'fas fa-cut'
        ];
        return $iconos[$categoria] ?? 'fas fa-stethoscope';
    }

    private function getEspecialidadName($codEspecialidad)
    {
        if (empty($codEspecialidad)) return null;

        try {
            $especialidad = CveEspecialidad::select('DES_ESPECIALIDAD')
                ->where('COD_ESPECIALIDAD', $codEspecialidad)
                ->first();
            return $especialidad ? $especialidad->DES_ESPECIALIDAD : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractCiudad($direccion)
    {
        if (stripos($direccion, 'Lima') !== false) return 'Lima';
        if (stripos($direccion, 'Zárate') !== false) return 'Zárate';
        if (stripos($direccion, 'Comas') !== false) return 'Comas';
        return 'Lima';
    }
}
