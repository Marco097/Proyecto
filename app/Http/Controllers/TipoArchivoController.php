<?php

namespace App\Http\Controllers;

use App\Models\TipoArchivo;
use Illuminate\Http\Request;

class TipoArchivoController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $tipoArchivos = TipoArchivo::all();
            return $tipoArchivos;
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
            $tipoArchivo = new TipoArchivo();
            $tipoArchivo->tipo_archivo = $request->tipo_archivo;
 
            if($tipoArchivo->save() >= 1){
             return response()->json(['status'=>'ok','data'=>$tipoArchivo],201);
            }else{
             return response()->json(['status'=>'fall','data'=>$tipoArchivo],409);
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
            $tipoArchivo = TipoArchivo::findOrFail($id);
            return $tipoArchivo;
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
            $tipoArchivo = TipoArchivo::findOrFail($id);
            $tipoArchivo->tipo_archivo = $request->tipo_archivo;
            if($tipoArchivo->update() >= 1){
             return response()->json(['status'=>'ok','data'=>$tipoArchivo],202);
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
            $tipoArchivo = TipoArchivo::findOrFail($id);
            if($tipoArchivo->delete() >= 1){
             return response()->json(['status'=>'ok','data'=>$tipoArchivo],201);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
