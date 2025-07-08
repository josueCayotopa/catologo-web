<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaPersonalRequest;
use App\Models\PlaPersonal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaPersonalController extends Controller
{
    public function index()
    {
        // mostrar solo 10 registro 
         $personal = PlaPersonal::paginate(10); // Obtener todos los registros de la tabla PLA_PERSONAL con paginación
    
       
       
  
        return response()->json($personal,200); // Devolver los registros en formato JSON con formato legible
        // return response()->json($personal,200,[],JSON_UNESCAPED_SLASHES); // Devolver los registros en formato JSON sin escapar las barras
        // return response()->json($personal,200,[],JSON_UNESCAPED_UNICODE); // Devolver los registros en formato JSON sin escapar los caracteres unicode
        // return response()->json($personal,200,[],JSON_NUMERIC_CHECK); // Devolver los registros en formato JSON con los números como números
        // return response()->json($personal,200,[],JSON_PRESERVE_ZERO_FRACTION); // Devolver los registros en formato JSON con los números decimales como números decimales
        // return response()->json($personal,200,[],JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_SLASHES); // Devolver los registros en formato JSON con los números decimales como números decimales y sin escapar las barras


    }

  
    public function store(PlaPersonalRequest $request)
    {
        //
                // Validar los datos de entrada
      

        // Crear un nuevo registro en la tabla PLA_PERSONAL
        PlaPersonal::create($request->all());

        // Devolver una respuesta JSON con el registro creado
        return response()->json(['success'=>true], 201);
    }

  
    public function show(string $id)
    {
        //
        $personal=PlaPersonal::where('COD_PERSONAL', $id); // Obtener un solo registro filtrado por COD_PERSONAL o lanzar una excepción si no existe
        return response()->json($personal,200); // Devolver los registros en formato JSON
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaPersonalRequest $request, string $id)
    {
        $personal= PlaPersonal::where('COD_PERSONAL', $id); // Obtener un solo registro filtrado por COD_PERSONAL o lanzar una excepción si no existe
        $personal->APE_PATERNO = $request->input('APE_PATERNO');
        $personal->APE_MATERNO = $request->input('APE_MATERNO');
        $personal->NOM_TRABAJADOR = $request->input('NOM_TRABAJADOR');
        $personal->COD_PROFESION = $request->input('COD_PROFESION');
        $personal->save(); // Guardar los cambios en la base de datos
        // Devolver una respuesta JSON con el registro actualizado
        return response()->json(['success'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
