<?php

namespace App\Http\Controllers;

use App\Models\CveMedicos;
use Illuminate\Http\Request;

class CveMedicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
   
        // Obtener todos los registros de la tabla mae_pais
        $medicos = CveMedicos::paginate(10);

        // Devolver los registros en formato JSON
        return response()->json($medicos, 200);
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
    public function show(CveMedicos $cveMedicos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CveMedicos $cveMedicos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CveMedicos $cveMedicos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CveMedicos $cveMedicos)
    {
        //
    }
}
