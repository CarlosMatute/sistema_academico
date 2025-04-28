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
    public function ver_secciones($id_institucion){
        $asignaturas = DB::select("SELECT
                    ID,
                    ID_ASIGNATURA,
                    ASIGNATURA,
                    DETALLE,
                    ID_INSTITUCION,
                    CREATED_AT
                FROM
                    PUBLIC.ASIGNATURAS
                WHERE
                    DELETED_AT IS NULL
                AND ID_INSTITUCION = :id_institucion;", ["id_institucion" => $id_institucion]);

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

        return view('pages.twacademic.secciones')
            ->with('asignaturas', $asignaturas)
            ->with('periodos_academicos', $periodos_academicos)
            ->with('id_institucion', $id_institucion);
    }
}
