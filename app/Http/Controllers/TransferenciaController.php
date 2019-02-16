<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Punto;
use App\User;
use App\Regalo;
use Illuminate\Support\Facades\DB;
use Auth;

class TransferenciaController extends Controller
{
    public function index() {
    	$user_id = Auth::user()->id;
    	$puntos_acumulados = DB::select(
    		'SELECT sum(disc_puntualidad_pos+productividad_pos+gestion_pos+meritos_taller_curso+merito_univ+merito_espec+be_disc_puntualidad+be_disc_ausencia+be_disc_apercib+be_prod_fluor+be_prod_fluor_verde+be_prod_verde+be_gestion_excelente+be_gestion_exc_buena+be_gestion_buena) as r from puntos where user_id ='. $user_id);
    	return view('transferencia.index', compact('puntos_acumulados'));
    }

    public function transferir(Request $request) {
    	$user_id = Auth::user()->id;
    	$monto_a_transferir = $request->monto;
        $monto_ya_transferido = 0;
    	$puntos_acumulados = $request->punto_acumulado;
        $user_a_regalar = $request->cuenta;
    	$user_a_transferir = DB::select("SELECT id, name FROM users WHERE id = '$request->cuenta'");
    	$registros = DB::select('SELECT id, disc_puntualidad_pos, productividad_pos from puntos where user_id ='. $user_id);
    	$cantidad_registros = count($registros);
        $acumulado = 0;


    	if ($monto_a_transferir <= $puntos_acumulados) {
    		if ($user_a_transferir) {
                for ($i=0; $i < $cantidad_registros; $i++) {

                    if ($monto_a_transferir > $acumulado) {

                        if ($registros[$i]->disc_puntualidad_pos > 0) {

                            $acumulado = $acumulado + $registros[$i]->disc_puntualidad_pos;
                            

                            if ($acumulado ==  $monto_a_transferir) {
                                var_dump('acumulado ya es igual al monto a transferir '.$acumulado);

                                // actualiza el registro
                                $punto = Punto::findOrFail($registros[$i]->id);
                                $punto->disc_puntualidad_pos = 0;
                                $punto->save();

                                // registra la transeferencia
                                $regalo = new Regalo();
                                $regalo->puntos = $acumulado;
                                $regalo->user_regalo = $user_id;
                                $regalo->user_recibio = $user_a_regalar;
                                $regalo->save();
                                var_dump('se regalo');

                            }

                            if ($acumulado <  $monto_a_transferir) {
                                var_dump('el acumulado quedo en '. $acumulado . ' y el monto a transferir es '. $monto_a_transferir);
                                // actualiza el registro
                                $punto = Punto::findOrFail($registros[$i]->id);
                                $punto->disc_puntualidad_pos = 0;
                                $punto->save();

                            }

                            if ($acumulado > $monto_a_transferir) {
                                var_dump('el acumulado '. $acumulado . ' ya paso al monto a transferir '. $monto_a_transferir);
                                $vuelto = $acumulado - $monto_a_transferir;

                                // actualiza el registro
                                $punto = Punto::findOrFail($registros[$i]->id);
                                $punto->disc_puntualidad_pos = $vuelto;
                                $punto->save();

                                // registra la transeferencia
                                $regalo = new Regalo();
                                $regalo->puntos = $monto_a_transferir;
                                $regalo->user_regalo = $user_id;
                                $regalo->user_recibio = $user_a_regalar;
                                $regalo->save();
                            }
                        }

                        

                    }
                }
    		} else {
    			var_dump('no hay usuario');
    		}
    	} else {
    		var_dump('el monto es mayor al punto acumulado');
    	}
        // var_dump('se sumo'.$acumulado);
    	var_dump('--------'); die;
    	return redirect('/transferencia');

    }
}
