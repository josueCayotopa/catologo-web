<?php

namespace App\Http\Controllers;

use App\Models\MaeAuxiliar;
use Illuminate\Http\Request;

class MaeAuxiliarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los registros de la tabla mae_pais
        $maeAuxiliar = MaeAuxiliar::paginate(10);

        // Devolver los registros en formato JSON
        return response()->json($maeAuxiliar, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MaeAuxiliar $maeAuxiliar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaeAuxiliar $maeAuxiliar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaeAuxiliar $maeAuxiliar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaeAuxiliar $maeAuxiliar)
    {
        //
    }
}
