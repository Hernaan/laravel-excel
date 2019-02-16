<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Punto;
use Illuminate\Support\Facades\DB;
use Auth;

class ClienteController extends Controller
{
    //
    public function index() {
    	$user_id = Auth::user()->id;
    	$mes_actual = date("m");

    	$puntos_acumulados = DB::select(
    		'SELECT sum(disc_puntualidad_pos+productividad_pos+gestion_pos+meritos_taller_curso+merito_univ+merito_espec+be_disc_puntualidad+be_disc_ausencia+be_disc_apercib+be_prod_fluor+be_prod_fluor_verde+be_prod_verde+be_gestion_excelente+be_gestion_exc_buena+be_gestion_buena) as r from puntos where user_id ='. $user_id);

    	$punto_pos_mes_actual = DB::select(
    		"SELECT sum(disc_puntualidad_pos+productividad_pos+gestion_pos+meritos_taller_curso+merito_univ+merito_espec+be_disc_puntualidad+be_disc_ausencia+be_disc_apercib+be_prod_fluor+be_prod_fluor_verde+be_prod_verde+be_gestion_excelente+be_gestion_exc_buena+be_gestion_buena) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes_actual'");

    	$punto_neg_mes_actual = DB::select(
    		"SELECT sum(disc_puntualidad_neg+productividad_neg+gestion_neg) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes_actual'");
    	return view('cliente.index', compact('puntos_acumulados', 'punto_pos_mes_actual', 'punto_neg_mes_actual'));
    }

    public function extracto () {
    	$user_id = Auth::user()->id;
    	$puntos_acumulados = DB::select(
    		'SELECT sum(disc_puntualidad_pos+productividad_pos+gestion_pos+meritos_taller_curso+merito_univ+merito_espec+be_disc_puntualidad+be_disc_ausencia+be_disc_apercib+be_prod_fluor+be_prod_fluor_verde+be_prod_verde+be_gestion_excelente+be_gestion_exc_buena+be_gestion_buena) as r from puntos where user_id ='. $user_id);

    	$puntualidad = DB::select(
    		'SELECT sum(disc_puntualidad_pos+be_disc_puntualidad) as r from puntos where user_id ='. $user_id);

    	$llegadas_tardias = DB::select(
    		'SELECT sum(disc_puntualidad_neg) as r from puntos where user_id ='. $user_id);

    	$productividad = DB::select(
    		'SELECT sum(productividad_pos+be_prod_fluor+be_prod_fluor_verde+be_prod_verde) as r from puntos where user_id ='. $user_id);

    	$bono_mensual_ausencia = DB::select(
    		'SELECT sum(be_disc_ausencia) as r from puntos where user_id ='. $user_id);
    	$bono_mensual_apercibimiento = DB::select(
    		'SELECT sum(be_disc_apercib) as r from puntos where user_id ='. $user_id);

    	return view('cliente.extracto', compact('puntos_acumulados', 'puntualidad', 'llegadas_tardias', 'productividad', 'bono_mensual_ausencia', 'bono_mensual_apercibimiento'));
    }

    public function historial() {
    	return view('cliente.historial');
    }

    public function historial_mes(Request $request, $id) {
    	$user_id = Auth::user()->id;
    	$mes = $request->id;
    	$nombre_mes = '';
    	if ($mes == 1) {
    		$nombre_mes = 'ENERO';
    	} 
    	if ($mes == 2) {
    		$nombre_mes = 'FEBRERO';
    	}
    	if ($mes == 3) {
    		$nombre_mes = 'MARZO';
    	} 
    	if ($mes == 4) {
    		$nombre_mes = 'ABRIL';
    	}
    	if ($mes == 5) {
    		$nombre_mes = 'MAYO';
    	} 
    	if ($mes == 6) {
    		$nombre_mes = 'JUNIO';
    	}
    	if ($mes == 7) {
    		$nombre_mes = 'JULIO';
    	} 
    	if ($mes == 8) {
    		$nombre_mes = 'AGOSTO';
    	}
    	if ($mes == 9) {
    		$nombre_mes = 'SEPTIEMBRE';
    	} 
    	if ($mes == 10) {
    		$nombre_mes = 'OCTUBRE';
    	}
    	if ($mes == 11) {
    		$nombre_mes = 'NOVIEMBRE';
    	} 
    	if ($mes == 12) {
    		$nombre_mes = 'DICIEMBRE';
    	}

    	if($mes < 1 || $mes > 12) {
    		$nombre_mes = 'ESTE MES NO EXISTE';
    	}

    	$puntos_acumulados = DB::select(
    		"SELECT sum(disc_puntualidad_pos+productividad_pos+gestion_pos+meritos_taller_curso+merito_univ+merito_espec+be_disc_puntualidad+be_disc_ausencia+be_disc_apercib+be_prod_fluor+be_prod_fluor_verde+be_prod_verde+be_gestion_excelente+be_gestion_exc_buena+be_gestion_buena) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");

    	$puntualidad = DB::select(
    		"SELECT sum(disc_puntualidad_pos+be_disc_puntualidad) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");

    	$llegadas_tardias = DB::select(
    		"SELECT sum(disc_puntualidad_neg) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");

    	$productividad = DB::select(
    		"SELECT sum(productividad_pos+be_prod_fluor+be_prod_fluor_verde+be_prod_verde) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");

    	$bono_mensual_ausencia = DB::select(
    		"SELECT sum(be_disc_ausencia) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");
    	$bono_mensual_apercibimiento = DB::select(
    		"SELECT sum(be_disc_apercib) as r from puntos where user_id ='$user_id' AND MONTH(created_at) = '$mes'");

    	return view('cliente.historial_mes', compact('puntos_acumulados', 'puntualidad', 'llegadas_tardias', 'productividad', 'bono_mensual_ausencia', 'bono_mensual_apercibimiento', 'nombre_mes'));
    }
}
