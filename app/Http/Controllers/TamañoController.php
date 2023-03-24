<?php

namespace App\Http\Controllers;

use App\Models\Tamaño;
use Illuminate\Http\Request;

class TamañoController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $tamaños = Tamaño::all();
            return $tamaños;
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
            $tamaño = new Tamaño();
            $tamaño->tamaño = $request->tamaño;
 
            if($tamaño->save() >= 1){
             return response()->json(['status'=>'ok','data'=>$tamaño],201);
            }else{
             return response()->json(['status'=>'fall','data'=>$tamaño],409);
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
            $tamaño = Tamaño::findOrFail($id);
            return $tamaño;
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
            $tamaño = Tamaño::findOrFail($id);
            $tamaño->tamaño = $request->tamaño;
            if($tamaño->update() >= 1){
             return response()->json(['status'=>'ok','data'=>$tamaño],202);
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
            $tamaño = Tamaño::findOrFail($id);
            if($tamaño->delete() >= 1){
             return response()->json(['status'=>'ok','data'=>$tamaño],201);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
