<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class EstudiantesController extends Controller
{
    public function ver_estudiantes($id_institucion){
        $estudiantes = DB::select("SELECT
                E.ID,
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
                E.CREATED_AT
            FROM
                PUBLIC.ESTUDIANTES E
                JOIN INSTITUCIONES_ESTUDIANTES IE ON E.ID = IE.ID_ESTUDIANTE
            WHERE
                E.DELETED_AT IS NULL
                AND IE.DELETED_AT IS NULL
                AND IE.ID_INSTITUCION = :id_institucion;", ["id_institucion" => $id_institucion]);
        return view('pages.twacademic.estudiantes')
            ->with('estudiantes', $estudiantes)
            ->with('id_institucion', $id_institucion);
    }

    public function guardar_estudiantes(Request $request){
        $accion = $request->accion;
        $id_institucion = $request->id_institucion;
        $id = $request->id;
        $numero_cuenta = $request->numero_cuenta;
        $primer_nombre = $request->primer_nombre;
        $segundo_nombre = $request->segundo_nombre;
        $primer_apellido = $request->primer_apellido;
        $segundo_apellido = $request->segundo_apellido;
        $correo_electronico = $request->correo_electronico;
        $celular = $request->celular;
        $carrera = $request->carrera;
        $msgSuccess = null;
        $msgError = null;
        $estudiantes = null;
        
        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        //DB::beginTransaction();
        try {
            //throw new Exception($id_institucion);
            if($accion == 1){
                $id = collect(\DB::select("INSERT INTO
                        PUBLIC.ESTUDIANTES (
                            NUMERO_CUENTA,
                            PRIMER_NOMBRE,
                            SEGUNDO_NOMBRE,
                            PRIMER_APELLIDO,
                            SEGUNDO_APELLIDO,
                            CORREO_ELECTRONICO,
                            CELULAR,
                            CARRERA
                        )
                    VALUES
                        (:numero_cuenta, :primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :correo_electronico, :celular, :carrera)
                    RETURNING ID;",
                ["numero_cuenta" => $numero_cuenta, "primer_nombre" => $primer_nombre, "segundo_nombre" => $segundo_nombre, "primer_apellido" => $primer_apellido,
                "segundo_apellido" => $segundo_apellido, "correo_electronico" => $correo_electronico, "celular" => $celular, "carrera" => $carrera]))->first();

                $id = $id->id;

                //throw new Exception($id_institucion.' '.$id_estudiante);

                DB::statement("INSERT INTO
                        PUBLIC.INSTITUCIONES_ESTUDIANTES (
                            ID_INSTITUCION,
                            ID_ESTUDIANTE
                        )
                    VALUES
                        (:id_institucion, :id_estudiante);", ["id_institucion" => $id_institucion, "id_estudiante" => $id_estudiante]);


                $msgSuccess = 'Registro '.$id." creado correctamente.";
            }elseif($accion == 2){
                DB::select("UPDATE PUBLIC.ESTUDIANTES
                    SET
                        NUMERO_CUENTA = :numero_cuenta,
                        PRIMER_NOMBRE = :primer_nombre,
                        SEGUNDO_NOMBRE = :segundo_nombre,
                        PRIMER_APELLIDO = :primer_apellido,
                        SEGUNDO_APELLIDO = :segundo_apellido,
                        CORREO_ELECTRONICO = :correo_electronico,
                        CELULAR = :celular,
                        CARRERA = :carrera,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id;",
                ["id" => $id, "numero_cuenta" => $numero_cuenta, "primer_nombre" => $primer_nombre, "segundo_nombre" => $segundo_nombre, "primer_apellido" => $primer_apellido,
                "segundo_apellido" => $segundo_apellido, "correo_electronico" => $correo_electronico, "celular" => $celular, "carrera" => $carrera]);

                $msgSuccess = 'Registro '.$id." editado correctamente.";
            }elseif($accion == 3){
                DB::select("UPDATE PUBLIC.ESTUDIANTES SET DELETED_AT = NOW() WHERE ID = :id", ["id" => $id]);

                $msgSuccess = 'Registro '.$id." eliminado correctamente.";
            }else{
                $msgError = 'Acción Inválida.';
            }

            if($msgError == null){
                $estudiantes = DB::select("SELECT
                    E.ID,
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
                    E.CREATED_AT
                FROM
                    PUBLIC.ESTUDIANTES E
                    JOIN INSTITUCIONES_ESTUDIANTES IE ON E.ID = IE.ID_ESTUDIANTE
                WHERE
                    E.DELETED_AT IS NULL
                    AND IE.DELETED_AT IS NULL
                    AND IE.ID_INSTITUCION = :id_institucion
                    AND E.ID = :id;", ["id" => $id, "id_institucion" => $id_institucion]);
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
            "estudiantes" => $estudiantes
        ]);
    }
}
