<?php

namespace App\Http\Controllers;
use App\Models\VenTarifarioPrecio;
use Illuminate\Http\Request;
use App\Models\VenTipoPrecio;
use App\Models\LogArticuloServ;
use Illuminate\Support\Facades\DB;

class VenTarifarioPrecioController extends Controller
{
      public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $perPage = 30;
        
        $query = $this->buildProductQuery();
        
        // Aplicar filtro de búsqueda
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('a.DES_ARTICULO_SERV', 'LIKE', "%{$search}%")
                  ->orWhere('a.DES_LARGA', 'LIKE', "%{$search}%")
                  ->orWhere('a.COD_ARTICULO_SERV', 'LIKE', "%{$search}%")
                  ->orWhere('a.COD_BARRA', 'LIKE', "%{$search}%");
            });
        }
        
        // Aplicar filtro de categoría
        if ($category && $category !== 'all') {
            $query->where('a.TIP_PRODUCTO', $category);
        }
        
        $products = $query->paginate($perPage);
        $categories = $this->getCategories();
        
        // Transformar los productos
        $products->getCollection()->transform(function($producto) {
            return $this->transformProduct($producto);
        });
        
        return view('productos.index', compact('products', 'categories', 'search', 'category'));
    }

    public function show($codArticulo)
    {
        $product = $this->getProductByCode($codArticulo);
        if (!$product) {
            abort(404, 'Producto no encontrado');
        }
        
        $relatedProducts = $this->getRelatedProducts($product['cod_familia'], $codArticulo);

        return view('productos.show', compact('product', 'relatedProducts'));
    }

    public function category($category)
    {
        return redirect()->route('productos.index', ['category' => $category]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');
        return redirect()->route('productos.index', ['search' => $search]);
    }

    private function buildProductQuery()
    {
        return DB::table('LOG_ARTICULO_SERV as a')
            ->join('VEN_TARIFARIO_PRECIO as p', function($join) {
                $join->on('a.COD_ARTICULO_SERV', '=', 'p.COD_ARTICULO_SERV')
                     ->on('a.COD_EMPRESA', '=', 'p.COD_EMPRESA');
            })
            ->join('VEN_TIPO_PRECIO as tp', function($join) {
                $join->on('p.COD_PRECIO', '=', 'tp.COD_PRECIO')
                     ->on('p.COD_EMPRESA', '=', 'tp.COD_EMPRESA');
            })
            ->select(
                'a.COD_ARTICULO_SERV as codigo',
                'a.DES_ARTICULO_SERV as nombre',
                'a.DES_LARGA as descripcion',
                'a.COD_FAMILIA as cod_familia',
                'a.TIP_PRODUCTO as categoria',
                'p.IMP_PRECIO as precio',
                'p.COD_MONEDA as moneda',
                'tp.DES_PRECIO as tipo_precio',
                'a.COD_BARRA as codigo_barra'
            )
            ->where('p.COD_PRECIO', '=', '0006')
            ->where('p.IMP_PRECIO', '>', 0)
            ->orderBy('a.DES_ARTICULO_SERV');
    }

    private function transformProduct($producto)
    {
        return [
            'codigo' => $producto->codigo,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion ?: 'Descripción no disponible',
            'precio' => (float) $producto->precio,
            'cod_familia' => $producto->cod_familia,
            'categoria' => $this->mapCategoria($producto->categoria),
            'moneda' => $producto->moneda,
            'tipo_precio' => $producto->tipo_precio,
            'codigo_barra' => $producto->codigo_barra,
            'image' => $this->getProductImage($producto->codigo),
            'stock' => rand(5, 50),
            'rating' => round(rand(35, 50) / 10, 1)
        ];
    }

    private function getProductByCode($codigo)
    {
        $producto = DB::table('LOG_ARTICULO_SERV as a')
            ->join('VEN_TARIFARIO_PRECIO as p', function($join) {
                $join->on('a.COD_ARTICULO_SERV', '=', 'p.COD_ARTICULO_SERV')
                     ->on('a.COD_EMPRESA', '=', 'p.COD_EMPRESA');
            })
            ->join('VEN_TIPO_PRECIO as tp', function($join) {
                $join->on('p.COD_PRECIO', '=', 'tp.COD_PRECIO')
                     ->on('p.COD_EMPRESA', '=', 'tp.COD_EMPRESA');
            })
            ->select(
                'a.COD_ARTICULO_SERV as codigo',
                'a.DES_ARTICULO_SERV as nombre',
                'a.DES_LARGA as descripcion',
                'a.COD_FAMILIA as cod_familia',
                'a.TIP_PRODUCTO as categoria',
                'p.IMP_PRECIO as precio',
                'p.COD_MONEDA as moneda',
                'tp.DES_PRECIO as tipo_precio',
                'a.COD_BARRA as codigo_barra'
            )
            ->where('a.COD_ARTICULO_SERV', $codigo)
            ->first();

        if (!$producto) {
            return null;
        }

        return $this->transformProduct($producto);
    }

    private function getRelatedProducts($codFamilia, $excludeCode)
    {
        $productos = DB::table('LOG_ARTICULO_SERV as a')
            ->join('VEN_TARIFARIO_PRECIO as p', function($join) {
                $join->on('a.COD_ARTICULO_SERV', '=', 'p.COD_ARTICULO_SERV')
                     ->on('a.COD_EMPRESA', '=', 'p.COD_EMPRESA');
            })
            ->select(
                'a.COD_ARTICULO_SERV as codigo',
                'a.DES_ARTICULO_SERV as nombre',
                'a.DES_LARGA as descripcion',
                'a.COD_FAMILIA as cod_familia',
                'a.TIP_PRODUCTO as categoria',
                'p.IMP_PRECIO as precio'
            )
            ->where('a.COD_FAMILIA', $codFamilia)
            ->where('a.COD_ARTICULO_SERV', '!=', $excludeCode)
            ->where('a.TIP_ARTICULO_SERV', '=', 'A')
            ->where('p.IMP_PRECIO', '>', 0)
            ->limit(3)
            ->get();

        return $productos->map(function($producto) {
            return $this->transformProduct($producto);
        })->toArray();
    }

    private function getCategories()
    {
        $categorias = DB::table('LOG_ARTICULO_SERV')
            ->select('TIP_PRODUCTO')
            ->where('TIP_ARTICULO_SERV', '=', 'A')
            ->distinct()
            ->whereNotNull('TIP_PRODUCTO')
            ->get();

        $categoriasMap = [];
        foreach ($categorias as $categoria) {
            $categoriasMap[$categoria->TIP_PRODUCTO] = $this->mapCategoria($categoria->TIP_PRODUCTO);
        }

        return $categoriasMap;
    }

    private function mapCategoria($tipProducto)
    {
        $mapeo = [
            'P' => 'Productos',
            'S' => 'Servicios',
            'M' => 'Medicamentos',
            'E' => 'Equipos',
            'I' => 'Insumos',
            'default' => 'General'
        ];

        return $mapeo[$tipProducto] ?? $mapeo['default'];
    }

    private function getProductImage($codigo)
    {
        $seed = crc32($codigo);
        $colors = ['medical', 'health', 'pharmacy', 'equipment', 'medicine'];
        $color = $colors[$seed % count($colors)];
        
        return "/placeholder.svg?height=400&width=400&text=" . urlencode($codigo) . "&query=" . $color;
    }
}