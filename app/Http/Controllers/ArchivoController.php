<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\DetalleArchivo;
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
            //convirtiendo a array
            $response = $archivos->toArray();
            $i=0;
            foreach($archivos as $archivo) {
                $response[$i]['nube'] = $archivo->nube->toArray();
                $detalle = $archivo->detalle_archivos->toArray();
                $f=0;
                foreach($archivo->detalle_archivos as $d){
                    $detalle[$f]['archivo'] = $d->archivo->toArray();
                    $detalle[$f]['archivo']['nube'] = $d->archivo->nube->toArray();
                    $f++;
                }
                $response[$i]['detalleArchivo'] = $detalle;
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
        //
        return "Vista para crear archivos";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
        $errores = 0;
            $archivo = new Archivo();
            $archivo->nombre = $request->nombre;
            $archivo->nube_id = $request->nube['id'];
            if($archivo->save() >= 1){
                $errores++;
            }
            $detalle = $request->detalleArchivo;
            foreach($detalle as $key => $det){
                //creando un objeto de tipo Detalle
                $detalleArchivo = new DetalleArchivo();
                $detalleArchivo->tipo_archivo = $det['tipoArchivo'];
                $detalleArchivo->fecha_ingreso = $det['fechaIngreso'];
                $detalleArchivo->tamaño = $det['tamaño'];
                $detalleArchivo->archivo_id = $archivo->id;
                if($detalleArchivo->save() <=0){
                    $errores++;
                }
            }
            if($errores == 0){
                return response()->json(['status'=>'ok','data'=>$archivo],201);
            }else{
                return response()->json(['status'=>'fail','data'=> null],409);
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
            $archivos = Archivo::findOrFail($id);
            $response = $archivos->toArray();
            $i=0;
            foreach($archivos as $archivo) {
                $response[$i]["nube"] = $archivo->nube->toArray();
                $detalle = $archivo->detalle_archivos->toArray();
                $f=0;
                foreach($archivo->detalle_archivos as $d){
                    $detalle[$f]['archivo'] = $d->archivo->toArray();
                    $detalle[$f]['archivo']['nube'] = $d->archivo->nube->toArray();
                    $f++;
                }
                $response[$i]['detalleArchivo'] = $detalle;
                $i++;
            }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          
            $errores = 0;
            $archivo =  Archivo::findOrFail($id);
            $archivo->nombre = $request->nombre;
            $archivo->nube_id = $request->nube['id'];
            if ($archivo->update() <= 0) {
                $errores++;
            }
            $detalle = $request->detalleArchivo;
            foreach($detalle as $key => $det){
                //creando un objeto de tipo Detalle
                $detalleArchivo = DetalleArchivo::findOrFail($det['$id']);
                $detalleArchivo->tipo_archivo = $det['tipoArchivo'];
                $detalleArchivo->fecha_ingreso = $det['fechaIngreso'];
                $detalleArchivo->tamaño= $det['tamaño'];
                if($detalleArchivo->update() <=0){
                    $errores++;
                }
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
