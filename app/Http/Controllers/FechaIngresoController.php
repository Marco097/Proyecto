<?php

namespace App\Http\Controllers;

use App\Models\FechaIngreso;
use Illuminate\Http\Request;

class FechaIngresoController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $fechaIngreso = FechaIngreso::all();
            return $fechaIngreso;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $fechaIngreso = new FechaIngreso();
            $fechaIngreso->fecha_ingreso = $request->fecha_ingreso;
 
            if($fechaIngreso->save() >= 1){
             return response()->json(['status'=>'ok','data'=>$fechaIngreso],201);
            }else{
             return response()->json(['status'=>'fall','data'=>$fechaIngreso],409);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $fechaIngreso = FechaIngreso::findOrFail($id);
            return $fechaIngreso;
        }catch(\Exception $e){
            return $e->getMessage();
        }
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
    public function update(Request $request, string $id)
    {
        try{
            $fechaIngreso = FechaIngreso::findOrFail($id);
            $fechaIngreso->fecha_ingreso = $request->fecha_ingreso;
            if($fechaIngreso->update() >= 1){
             return response()->json(['status'=>'ok','data'=>$fechaIngreso],202);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $fechaIngreso = FechaIngreso::findOrFail($id);
            if($fechaIngreso->delete() >= 1){
             return response()->json(['status'=>'ok','data'=>$fechaIngreso],201);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
