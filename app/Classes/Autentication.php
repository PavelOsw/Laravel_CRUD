<?php

namespace App\Classes;

use stdClass;
use Branca\Branca;

use App\Models\Centro;

class RecuperarDatosUdg
{
    private function consultaDatos($ruta, $params)
    {
        $curl = curl_init();
        $url_consulta = env('SIGI_LOGIN_URL') . $ruta;

        $branca = new Branca(env('TOKEN_KEY', ''));
        $token = $branca->encode(env('TOKEN_API_LOGIN_SIGI', ''));

        $credenciales = array(
            'sistema:' . env('SIGI_LOGIN_SISTEMA'),
            'token: ' . $token
        );
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_consulta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array_merge($credenciales, $params)            
        ));

        return json_decode(curl_exec($curl));
    }

	public function getDataAlumno($codigo)
    {
        $existe_alumno = true;
        $alumno = new stdClass();
        $data = $this->consultaDatos('/datos-alumno', array('codigo: ' . $codigo));

        if(isset($data->error)) {
            $existe_alumno = false;
            $alumno->msj_error = $data->error;
        }
        
        $alumno->existe = $existe_alumno;
        $alumno->codigo = $data->codigo ?? null;
        $alumno->nombre = $data->nombre ?? null;
        $alumno->apellidos = $data->apellido ?? null;
        
        if(isset($data->campus)) {
            $alumno->centro_id = Centro::ObtenerIdSiglas($data->campus);
            $alumno->centro = Centro::find($alumno->centro_id);
        }

        return $alumno;
    }

    public function getDataUsuario($codigo)
    {
        $existe_usuario = true;
        $usuario = new stdClass();
        $data = $this->consultaDatos('/datos-usuario', array('codigo: ' . $codigo));

        if(isset($data->error)) {
            $existe_usuario = false;
            $usuario->msj_error = $data->error;
        }

        $usuario->existe = $existe_usuario;
        $usuario->codigo = $data->codigo ?? null;
        $usuario->nombre = $data->nombre ?? null;

        $ap_paterno = $data->ap_paterno ?? null;
        $ap_materno = $data->ap_materno ?? null;
        $usuario->apellidos = $ap_paterno . ' ' . $ap_materno;

        $usuario->centro_id = null;

        return $usuario;
    }

    public static function getDataTrabajador($codigo, $nip)
    {
        $existe_usuario = true;
        $usuario = new stdClass();

        $data = (new RecuperarDatosUdg)->consultaDatos('/tipo-usuario', array(
            'codigo: ' . $codigo,
            'password: ' . $nip
        ));

        if(isset($data->error)) {
            $existe_usuario = false;
            $usuario->msj_error = 'El usuario no se encuentra en los registros de SIIAU.';
        }

        $usuario->existe = $existe_usuario;
        $usuario->tipo = $data->tipoUsuario ?? null;
        $usuario->estatus = $data->estatus ?? null;

        return $usuario;
    }
}