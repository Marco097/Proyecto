<?php

namespace App\Http\Controllers;

use App\Models\Archivo;

use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //devolver una lista 
        try {
            $archivos = Archivo::all();
            $response = $archivos->toArray();
            $i = 0;
            foreach($archivos as $archivo) {
                $response[$i]["nube"] = $archivo->nube->toArray();
                $response[$i]["tipo_archivo"] = $archivo->tipo_archivo->toArray();
                $response[$i]["tamaño"] = $archivo->tamaño->toArray();
                $response[$i]["fecha_ingreso"] = $archivo->fecha_ingreso->toArray();
                $i++;
            }
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
        return view('admin.archivos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
            $archivo = new Archivo();
            $archivo->nombre = $request->nombre;
            $archivo->nube_id = $request->nube['id'];
            $archivo->tipo_archivo_id = $request->tipo_archivo['id'];
            $archivo->tamaño_id = $request->tamaño['id'];
            $archivo->fecha_ingreso_id = $request->fecha_ingreso['id'];
            if($archivo->save() >= 1){
                return response()->json(['status'=>'ok','data'=>$archivo],201);
            }else{
                return response()->json(['status'=>'fail','data'=> $archivo],409);
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
            $archivo = Archivo::findOrFail($id);
            $response = $archivo->toArray();
                $response["nube"] = $archivo->nube->toArray();
                $response["tipo_archivo"] = $archivo->tipo_archivo->toArray();
                $response["tamaño"] = $archivo->tamaño->toArray();
                $response["fecha_ingreso"] = $archivo->fecha_ingreso->toArray();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $archivo =  Archivo::findOrFail($id);
            $archivo->nombre = $request->nombre;
            $archivo->nube_id = $request->nube['id'];
            $archivo->tipo_archivo_id = $request->tipo_archivo['id'];
            $archivo->tamaño_id = $request->tamaño['id'];
            $archivo->fecha_ingreso_id = $request->fecha_ingreso['id'];
            if ($archivo->update() >= 1) {
                return response()->json(['status'=>'ok','data'=>$archivo],202);
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
        try {
            $archivo = Archivo::findOrFail($id);
            if ($archivo->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}