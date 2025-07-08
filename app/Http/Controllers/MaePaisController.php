<?php

namespace App\Http\Controllers;

use App\Models\MaePais;
use Illuminate\Http\Request;

class MaePaisController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de la tabla mae_pais
        $paises = MaePais::all();

        // Devolver los registros en formato JSON
        return response()->json($paises, 200);
    }

    public function show(string $id)
    {
        // Obtener un solo registro filtrado por COD_PAIS o lanzar una excepción si no existe
        $pais = MaePais::where('COD_PAIS', $id)->firstOrFail();

        // Devolver el registro en formato JSON
        return response()->json($pais, 200);
    }
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'COD_PAIS' => 'required|string|max:10',
            'NOM_PAIS' => 'required|string|max:50',
            'NOM_ABR' => 'required|string|max:10',
        ]);

        // Crear un nuevo registro en la tabla mae_pais
        MaePais::create($request->all());

        // Devolver una respuesta JSON con el registro creado
        return response()->json(['success' => true], 201);
    }
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'NOM_PAIS' => 'required|string|max:50',
            'NOM_ABR' => 'required|string|max:10',
        ]);

        // Actualizar el registro en la tabla mae_pais
        $pais = MaePais::where('COD_PAIS', $id)->firstOrFail();
        $pais->update($request->all());

        // Devolver una respuesta JSON con el registro actualizado
        return response()->json(['success' => true], 200);
    }
    public function destroy(string $id)
    {
        // Eliminar el registro en la tabla mae_pais
        $pais = MaePais::where('COD_PAIS', $id)->firstOrFail();
        $pais->delete();

        // Devolver una respuesta JSON con el registro eliminado
        return response()->json(['success' => true], 200);
    }
    public function getPaises()
    {
        // Obtener todos los registros de la tabla mae_pais
        $paises = MaePais::all();

        // Devolver los registros en formato JSON
        return response()->json($paises, 200);
    }
    public function getPaisById($id)
    {
        // Obtener un solo registro filtrado por COD_PAIS o lanzar una excepción si no existe
        $pais = MaePais::where('COD_PAIS', $id)->firstOrFail();

        // Devolver el registro en formato JSON
        return response()->json($pais, 200);
    }
    public function getPaisByName($name)
    {
        // Obtener un solo registro filtrado por NOM_PAIS o lanzar una excepción si no existe
        $pais = MaePais::where('NOM_PAIS', 'like', '%' . $name . '%')->get();

        // Devolver el registro en formato JSON
        return response()->json($pais, 200);
    }
    public function getPaisByAbreviatura($abreviatura)
    {
        // Obtener un solo registro filtrado por NOM_ABR o lanzar una excepción si no existe
        $pais = MaePais::where('NOM_ABR', 'like', '%' . $abreviatura . '%')->get();

        // Devolver el registro en formato JSON
        return response()->json($pais, 200);
    }
    public function getPaisByCod($cod)
    {
        // Obtener un solo registro filtrado por COD_PAIS o lanzar una excepción si no existe
        $pais = MaePais::where('COD_PAIS', 'like', '%' . $cod . '%')->get();

        // Devolver el registro en formato JSON
        return response()->json($pais, 200);
    }
}
