<?php

namespace App\Http\Controllers;

use App\Models\Nube;
use Illuminate\Http\Request;

class NubeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $nubes = Nube::all();
            return $nubes;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Vista para crear nube";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $nube = new Nube();
            $nube->almacenamiento = $request->almacenamiento;
 
            if($nube->save() >= 1){
             return response()->json(['status'=>'ok','data'=>$nube],201);
            }else{
             return response()->json(['status'=>'fall','data'=>$nube],409);
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
            $nube = Nube::findOrFail($id);
            return $nube;
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
            $nube = Nube::findOrFail($id);
            $nube->almacenamiento = $request->almacenamiento;
            if($nube->update() >= 1){
             return response()->json(['status'=>'ok','data'=>$nube],202);
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
            $nube = Nube::findOrFail($id);
            if($nube->delete() >= 1){
             return response()->json(['status'=>'ok','data'=>$nube],200);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
