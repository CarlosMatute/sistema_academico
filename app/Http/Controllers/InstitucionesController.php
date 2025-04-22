<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Exception;
use DB;

class InstitucionesController extends Controller
{
    public function ver_instituciones(){
        $instituciones = DB::select("SELECT
                ID,
                NOMBRE,
                SIGLAS,
                CAMPUS,
                DETALLES,
                CREATED_AT
            FROM
                INSTITUCIONES
            WHERE DELETED_AT IS NULL;");
        return view('pages.twacademic.instituciones')
            ->with('instituciones', $instituciones);
    }

    public function guardar_instituciones(Request $request){
        $accion = $request->accion;
        $id = $request->id;
        $institucion = $request->institucion;
        $siglas = $request->siglas;
        $campus = $request->campus;
        $detalles = $request->detalles;
        $msgSuccess = null;
        $msgError = null;
        $instituciones = null;

        if ($id == null && $accion == 2) {
            $accion = 1;
        }

        try {
            if($accion == 1){
                $id = collect(\DB::select("INSERT INTO
                    PUBLIC.INSTITUCIONES (NOMBRE, SIGLAS, CAMPUS, DETALLES)
                VALUES
                    (:institucion, :siglas, :campus, :detalles)
                RETURNING ID;",
                ["institucion" => $institucion, "siglas" => $siglas, "campus" => $campus, "detalles" => $detalles]))->first();

                $id = $id->id;

                $msgSuccess = 'Registro '.$id." creado correctamente.";
            }elseif($accion == 2){
                DB::select("UPDATE PUBLIC.INSTITUCIONES
                    SET
                        NOMBRE = :institucion,
                        SIGLAS = :siglas,
                        CAMPUS = :campus,
                        DETALLES = :detalles,
                        UPDATED_AT = NOW()
                    WHERE
                        ID = :id;",
                ["id" => $id, "institucion" => $institucion, "siglas" => $siglas, 
                "campus" => $campus, "detalles" => $detalles]);

                $msgSuccess = 'Registro '.$id." editado correctamente.";
            }elseif($accion == 3){
                DB::select("UPDATE PUBLIC.INSTITUCIONES SET DELETED_AT = NOW() WHERE ID = :id", ["id" => $id]);

                $msgSuccess = 'Registro '.$id." eliminado correctamente.";
            }else{
                $msgError = 'Acción Inválida.';
            }

            if($msgError == null){
                $instituciones = DB::select("SELECT
                    ID,
                    NOMBRE,
                    SIGLAS,
                    CAMPUS,
                    DETALLES,
                    CREATED_AT
                FROM
                    INSTITUCIONES
                WHERE DELETED_AT IS NULL
                AND ID = :id;", ["id" => $id]);
            }

        } catch (Exception $e) {
            // Manejo del error
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "instituciones" => $instituciones
        ]);
    }
}
