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
        $secciones = DB::select("SELECT
                    ID,
                    NOMBRE,
                    AULA,
                    ID_INSTITUCION,
                    ID_ASIGNATURA,
                    HORA_INICIO,
                    HORA_FIN,
                    CREATED_AT
                FROM
                    PUBLIC.SECCIONES
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
            ->with('secciones', $secciones)
            ->with('periodos_academicos', $periodos_academicos)
            ->with('id_institucion', $id_institucion);
    }
}
