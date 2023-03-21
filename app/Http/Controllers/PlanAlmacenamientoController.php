<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanAlmacenamiento;
use Illuminate\Support\Facades\DB;

class PlanAlmacenamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $almacenamientos = PlanAlmacenamiento::all();
            //convirtiendo a array
            $response = $almacenamientos->toArray();
            $i = 0;
            foreach($almacenamientos as $almacenamiento) {
                $response[$i]["nube"] = $almacenamiento->nube->toArray();
                $i++;
            }
            //dd($response);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
        try{
            $errores = 0;
            DB::beginTransaction();
            //crear la instancia de alquiler
            $almacenamiento  = new PlanAlmacenamiento();
            $almacenamiento->nombre_plan = $request->nombrePlan;
            $almacenamiento->precio = $request->precio;
            $almacenamiento->nube_id = $request->nube['id'];
            if($almacenamiento->save() <=0){
                $errores++;
                return response()->json(['status'=>'ok','data'=>$almacenamiento],201);
            }else{
                return response()->json(['status'=>'fail','data'=>$almacenamiento],409);
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
        try {
            $almacenamiento = PlanAlmacenamiento::findOrFail($id);
            $response = $almacenamiento->toArray();
            $response["nube"] = $almacenamiento->nube->toArray();
            //dd($response);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $almacenamiento =  PlanAlmacenamiento::findOrFail($id);
            $almacenamiento->nombre_plan = $request->nombrePlan;
            $almacenamiento->precio = $request->precio;
            $almacenamiento->nube_id = $request->nube['id'];
            if ($almacenamiento->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $almacenamiento], 201);
            } else {
                return response()->json(['status' => 'fall', 'data' => null], 409);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $almacenamiento = PlanAlmacenamiento::findOrFail($id);
            if ($almacenamiento->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
