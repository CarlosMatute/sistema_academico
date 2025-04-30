<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class AsignaturasController extends Controller
{
    public function ver_asignaturas($id_institucion){
        $asignaturas = DB::select("SELECT
                    ID,
                    CODIGO_ASIGNATURA,
                    ASIGNATURA,
                    DETALLE,
                    ID_INSTITUCION,
                    CREATED_AT
                FROM
                    PUBLIC.ASIGNATURAS
                WHERE
                    DELETED_AT IS NULL
                AND ID_INSTITUCION = :id_institucion;", ["id_institucion" => $id_institucion]);
        return view('pages.twacademic.asignaturas')
            ->with('asignaturas', $asignaturas)
            ->with('id_institucion', $id_institucion);
    }

    public function guardar_asignaturas(Request $request){
        $accion = $request->accion;
        $id_institucion = $request->id_institucion;
        $id = $request->id;
        $codigo_asignatura = $request->codigo_asignatura;
        $asignatura = $request->asignatura;
        $detalle = $request->detalle;
        $msgSuccess = null;
        $msgError = null;
        $asignaturas = null;
        
        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        //DB::beginTransaction();
        try {
            //throw new Exception($id_institucion);
            if($accion == 1){
                $id = collect(\DB::select("INSERT INTO
                        PUBLIC.ASIGNATURAS (
                            CODIGO_ASIGNATURA,
                            ASIGNATURA,
                            DETALLE,
                            ID_INSTITUCION
                        )
                    VALUES
                        (:codigo_asignatura, :asignatura, :detalle, :id_institucion)
                    RETURNING ID;",
                ["codigo_asignatura" => $codigo_asignatura, "asignatura" => $asignatura, "detalle" => $detalle, "id_institucion" => $id_institucion]))->first();

                $id = $id->id;

                //throw new Exception($id_institucion.' '.$id_estudiante);

                $msgSuccess = 'Registro '.$id." creado correctamente.";
            }elseif($accion == 2){
                DB::select("UPDATE PUBLIC.ASIGNATURAS
                    SET
                        codigo_ASIGNATURA = :codigo_asignatura,
                        ASIGNATURA = :asignatura,
                        DETALLE = :detalle,
                        ID_INSTITUCION = :id_institucion,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id;",
                ["id" => $id, "codigo_asignatura" => $codigo_asignatura, "asignatura" => $asignatura, "detalle" => $detalle, "id_institucion" => $id_institucion]);

                $msgSuccess = 'Registro '.$id." editado correctamente.";
            }elseif($accion == 3){
                DB::select("UPDATE PUBLIC.ASIGNATURAS SET DELETED_AT = NOW() WHERE ID = :id", ["id" => $id]);

                $msgSuccess = 'Registro '.$id." eliminado correctamente.";
            }else{
                $msgError = 'Acción Inválida.';
            }

            if($msgError == null){
                $asignaturas = DB::select("SELECT
                        ID,
                        CODIGO_ASIGNATURA,
                        ASIGNATURA,
                        DETALLE,
                        ID_INSTITUCION,
                        CREATED_AT
                    FROM
                        PUBLIC.ASIGNATURAS
                    WHERE
                    DELETED_AT IS NULL
                    AND ID_INSTITUCION = :id_institucion
                    AND ID = :id;", ["id" => $id, "id_institucion" => $id_institucion]);
            }
            //DB::commit();
        } catch (Exception $e) {
            // Manejo del error
            //DB::rollback();
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "asignaturas" => $asignaturas
        ]);
    }
}
