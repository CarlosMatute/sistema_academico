<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class SeccionesController extends Controller
{
    public function ver_secciones($id_institucion, $id_periodo_academico){
        $secciones = DB::select("SELECT
                        S.ID,
                        S.NOMBRE,
                        S.AULA,
                        S.ID_PERIODO_ACADEMICO,
                        PA.NOMBRE PERIODO_ACADEMICO,
                        S.ID_ASIGNATURA,
	                    A.ID ID_ASIGNATURA,
                        A.CODIGO_ASIGNATURA,
                        A.ASIGNATURA,
                        S.HORA_INICIO,
                        TO_CHAR(S.HORA_INICIO, 'HH12:MI AM') HORA_INICIO_FORMATO,
                        S.HORA_FIN,
                        TO_CHAR(S.HORA_FIN, 'HH12:MI AM') HORA_FIN_FORMATO,
                        S.CREATED_AT
                    FROM
                        PUBLIC.SECCIONES S
                        JOIN PUBLIC.PERIODOS_ACADEMICOS PA ON S.ID_PERIODO_ACADEMICO = PA.ID
                        AND PA.ID = :id_periodo_academico
                        AND PA.DELETED_AT IS NULL
                        JOIN PUBLIC.INSTITUCIONES I ON PA.ID_INSTITUCION = I.ID
                        JOIN PUBLIC.ASIGNATURAS A ON S.ID_ASIGNATURA = A.ID
                    WHERE
                        S.DELETED_AT IS NULL
                    AND I.ID = :id_institucion;", ["id_institucion" => $id_institucion, "id_periodo_academico" => $id_periodo_academico]);

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
                    ID_INSTITUCION= :id_institucion
                ORDER BY CODIGO_ASIGNATURA;", ["id_institucion" => $id_institucion]);

        return view('pages.twacademic.secciones')
            ->with('secciones', $secciones)
            ->with('periodos_academicos', $periodos_academicos)
            ->with('asignaturas', $asignaturas)
            ->with('id_institucion', $id_institucion)
            ->with('id_periodo_academico', $id_periodo_academico);
    }

    public function guardar_secciones(Request $request){
        $accion = $request->accion;
        $id_institucion = $request->id_institucion;
        $id = $request->id;
        $seccion = $request->seccion;
        $aula = $request->aula;
        $id_periodo_academico = $request->id_periodo_academico;
        $asignatura  = $request->id_asignatura;
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $msgSuccess = null;
        $msgError = null;
        $periodos_academicos = null;

        //dd($request->all());
        
        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        //DB::beginTransaction();
        try {
            //throw new Exception($hora_inicio);
            if($accion == 1){
                $id = collect(\DB::select("INSERT INTO
                        PUBLIC.SECCIONES (
                            NOMBRE,
                            AULA,
                            ID_PERIODO_ACADEMICO,
                            ID_ASIGNATURA,
                            HORA_INICIO,
                            HORA_FIN
                        )
                    VALUES
                        (:seccion, :aula, :id_periodo_academico, :asignatura, :hora_inicio, :hora_fin)
                    RETURNING ID;",
                ["seccion" => $seccion, "aula" => $aula, "id_periodo_academico" => $id_periodo_academico, "asignatura" => $asignatura,
                "hora_inicio" => $hora_inicio, "hora_fin" => $hora_fin]))->first();

                $id = $id->id;

                $msgSuccess = 'Registro '.$id." creado correctamente.";
            }elseif($accion == 2){
                DB::select("UPDATE PUBLIC.SECCIONES
                    SET
                        NOMBRE = :seccion,
                        AULA = :aula,
                        ID_PERIODO_ACADEMICO = :id_periodo_academico,
                        ID_ASIGNATURA = :asignatura,
                        HORA_INICIO = :hora_inicio,
                        HORA_FIN = :hora_fin,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id;",
                ["id" => $id, "seccion" => $seccion, "aula" => $aula, "id_periodo_academico" => $id_periodo_academico, "asignatura" => $asignatura,
                "hora_inicio" => $hora_inicio, "hora_fin" => $hora_fin]);

                $msgSuccess = 'Registro '.$id." editado correctamente.";
            }elseif($accion == 3){
                DB::select("UPDATE PUBLIC.SECCIONES SET DELETED_AT = NOW() WHERE ID = :id", ["id" => $id]);

                $msgSuccess = 'Registro '.$id." eliminado correctamente.";
            }else{
                $msgError = 'Acción Inválida.';
            }

            if($msgError == null){
                $secciones = DB::select("SELECT
                        S.ID,
                        S.NOMBRE,
                        S.AULA,
                        S.ID_PERIODO_ACADEMICO,
                        PA.NOMBRE PERIODO_ACADEMICO,
                        S.ID_ASIGNATURA,
	                    A.ID ID_ASIGNATURA,
                        A.CODIGO_ASIGNATURA,
                        A.ASIGNATURA,
                        S.HORA_INICIO,
                        TO_CHAR(S.HORA_INICIO, 'HH12:MI AM') HORA_INICIO_FORMATO,
                        S.HORA_FIN,
                        TO_CHAR(S.HORA_FIN, 'HH12:MI AM') HORA_FIN_FORMATO,
                        S.CREATED_AT
                    FROM
                        PUBLIC.SECCIONES S
                        JOIN PUBLIC.PERIODOS_ACADEMICOS PA ON S.ID_PERIODO_ACADEMICO = PA.ID
                        AND PA.ID = :id_periodo_academico
                        AND PA.DELETED_AT IS NULL
                        JOIN PUBLIC.INSTITUCIONES I ON PA.ID_INSTITUCION = I.ID
                        JOIN PUBLIC.ASIGNATURAS A ON S.ID_ASIGNATURA = A.ID
                    WHERE
                        S.DELETED_AT IS NULL
                    AND I.ID = :id_institucion AND S.ID = :id;", ["id" => $id, "id_institucion" => $id_institucion, "id_periodo_academico" => $id_periodo_academico]);
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
            "secciones" => $secciones
        ]);
    }

    public function ver_secciones_estudiantes($id_institucion, $id_periodo_academico, $id_seccion){
        $secciones_estudiantes = DB::select("SELECT
                SE.ID,
                SE.ID_SECCION,
                SE.ID_ESTUDIANTE,
                E.NUMERO_CUENTA,
                TRIM(
                    COALESCE(TRIM(E.PRIMER_NOMBRE) || ' ', '') || COALESCE(TRIM(E.SEGUNDO_NOMBRE) || ' ', '') || COALESCE(TRIM(E.PRIMER_APELLIDO) || ' ', '') || COALESCE(TRIM(E.SEGUNDO_APELLIDO || ' '), '')
                ) AS NOMBRE_ESTUDIANTE,
                E.PRIMER_NOMBRE,
                E.SEGUNDO_NOMBRE,
                E.PRIMER_APELLIDO,
                E.SEGUNDO_APELLIDO,
                E.CORREO_ELECTRONICO,
                E.CELULAR,
                E.CARRERA,
                SE.OBSERVACIONES,
                SE.CREATED_AT
            FROM
                PUBLIC.SECCIONES_ESTUDIANTES SE
                JOIN ESTUDIANTES E ON SE.ID_ESTUDIANTE = E.ID
            WHERE
                SE.DELETED_AT IS NULL
                AND SE.ID_SECCION = :id_seccion;", ["id_seccion" => $id_seccion]);

        return view('pages.twacademic.secciones_estudiantes')
            ->with('secciones_estudiantes', $secciones_estudiantes)
            ->with('id_institucion', $id_institucion)
            ->with('id_periodo_academico', $id_periodo_academico);
    }
}
