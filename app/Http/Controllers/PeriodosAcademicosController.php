<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class PeriodosAcademicosController extends Controller
{
    public function ver_periodos_academicos($id_institucion){
        $periodos_academicos = DB::select("SELECT
                ID,
                PERIODO_ACADEMICO,
                ANIO_PERIODO_ACADEMICO,
                NOMBRE,
                ID_INSTITUCION,
                FECHA_INICIO,
                FECHA_FIN,
                CREATED_AT
            FROM
                PUBLIC.PERIODOS_ACADEMICOS
            WHERE
                DELETED_AT IS NULL
                AND ID_INSTITUCION = :id_institucion;", ["id_institucion" => $id_institucion]);
        return view('pages.twacademic.periodos_academicos')
            ->with('periodos_academicos', $periodos_academicos)
            ->with('id_institucion', $id_institucion);
    }

    public function guardar_periodos_academicos(Request $request){
        $accion = $request->accion;
        $id_institucion = $request->id_institucion;
        $id = $request->id;
        $periodo_academico  = $request->periodo_academico;
        $anio_periodo_academico  = $request->anio_periodo_academico;
        $nombre  = $request->nombre;
        $fecha_inicio  = $request->fecha_inicio;
        $fecha_fin  = $request->fecha_fin;
        $msgSuccess = null;
        $msgError = null;
        $periodos_academicos = null;
        
        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        //DB::beginTransaction();
        try {
            //throw new Exception($id_institucion);
            if($accion == 1){
                $id = collect(\DB::select("INSERT INTO
                        PUBLIC.PERIODOS_ACADEMICOS (
                            PERIODO_ACADEMICO,
                            ANIO_PERIODO_ACADEMICO,
                            NOMBRE,
                            ID_INSTITUCION,
                            FECHA_INICIO,
                            FECHA_FIN
                        )
                    VALUES
                        (:periodo_academico, :anio_periodo_academico, :nombre, :id_institucion, :fecha_inicio, :fecha_fin)
                    RETURNING ID;",
                ["periodo_academico" => $periodo_academico, "anio_periodo_academico" => $anio_periodo_academico, "nombre" => $nombre, "fecha_inicio" => $fecha_inicio,
                "id_institucion" => $id_institucion, "fecha_fin" => $fecha_fin]))->first();

                $id = $id->id;

                $msgSuccess = 'Registro '.$id." creado correctamente.";
            }elseif($accion == 2){
                DB::select("UPDATE PUBLIC.PERIODOS_ACADEMICOS
                    SET
                        PERIODO_ACADEMICO = :periodo_academico,
                        ANIO_PERIODO_ACADEMICO = :anio_periodo_academico,
                        NOMBRE = :nombre,
                        ID_INSTITUCION = :id_institucion,
                        FECHA_INICIO = :fecha_inicio,
                        FECHA_FIN = :fecha_fin,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id;",
                ["id" => $id, "periodo_academico" => $periodo_academico, "anio_periodo_academico" => $anio_periodo_academico, "nombre" => $nombre, "fecha_inicio" => $fecha_inicio,
                "id_institucion" => $id_institucion, "fecha_fin" => $fecha_fin]);

                $msgSuccess = 'Registro '.$id." editado correctamente.";
            }elseif($accion == 3){
                DB::select("UPDATE PUBLIC.PERIODOS_ACADEMICOS SET DELETED_AT = NOW() WHERE ID = :id", ["id" => $id]);

                $msgSuccess = 'Registro '.$id." eliminado correctamente.";
            }else{
                $msgError = 'Acción Inválida.';
            }

            if($msgError == null){
                $periodos_academicos = DB::select("SELECT
                    ID,
                    PERIODO_ACADEMICO,
                    ANIO_PERIODO_ACADEMICO,
                    NOMBRE,
                    ID_INSTITUCION,
                    FECHA_INICIO,
                    FECHA_FIN,
                    CREATED_AT
                FROM
                    PUBLIC.PERIODOS_ACADEMICOS
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
            "periodos_academicos" => $periodos_academicos
        ]);
    }
}
