<?php

namespace frontend\models\Programacion;
use yii;
use yii\base\Model;
use frontend\models\Programacion\Pedidos;
use common\models\datos\Programaciones;

use frontend\models\Programacion\ProgramacionesDia;
use frontend\models\Programacion\ProgramacionesSemana;

use frontend\models\Programacion\ProgramacionesAlma;
use frontend\models\Programacion\ProgramacionesAlmaDia;
use frontend\models\Programacion\ProgramacionesAlmaSemana;

use common\models\datos\Almas;


class CompletaProgramacion extends Model{
	
	
	public $ProductoProbeta = 20281;
	public $ProductoKeelBlock = 18717;
	 // public $conn = \Yii::$app->db;


	public function setPedido($prod){
		$p  = new Pedidos();
		$p->IdAlmacen = 1 ; // no identificado
		$p->IdProducto = $prod;
		$p->Codigo = '000';
		$p->Numero = 1;
		$p->Fecha = '20160101';
		$p->Cliente = '201106246320690' ; // fimex interno
		$p->Estatus = 0;
		$p->Cantidad = 0;
		$p->SaldoCantidad = 0;
		$p->save();
		var_dump($p);

	}
	
	public function setProgramacionPK($pk,$cantidad=10){

		 $conn = \Yii::$app->db;
		
		if($pk == 'probeta'){
			$producto = $this->ProductoProbeta;
		}elseif($pk == 'keelblock') {
			$producto = $this->ProductoKeelBlock;
		}else{
			echo "Producto no Valido";
			return 0;
		}
		
		$ped  =  Pedidos::find()->where(
				"IdProducto = $producto "
			)->one();

		 if ($ped == null){  
		 	echo "Sin pedido Inmortal para  $pk ";
		 	return 0;
		 } 
		 	
		$tran = $conn->beginTransaction();
		try {
			
			 $p  = new Programaciones();
			 $programaciones = Programaciones::find()->where([
	                    'IdProducto' => $ped->IdProducto,
	                    'IdPedido' => $ped->IdPedido,
		                ])->one();

			if(is_null($programaciones)){
				 $p->IdPedido= $ped->IdPedido;
	             $p->IdArea =2;
	             $p->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
	             $p->IdProgramacionEstatus = 1;
	             $p->IdProducto = $ped->IdProducto;
	             $p->Programadas = $cantidad;
	             $p->Hechas = 0;
	             $p->Cantidad = 2;
	             $p->save();
	             $programaciones = $p;
	             echo "new Programaciones: ". $programaciones->IdProgramacion;
			}

			$almas = Almas::find()->where(['IdProducto' => $ped->IdProducto])->asArray()->all();

			if(count($almas)>0){
				 foreach($almas as $alma){
			// echo "---------------------------ALMA :";var_dump($alma);

					 	 $programacionesalma = ProgramacionesAlma::find()->where([
	                    'IdProgramacion' => $programaciones->IdProgramacion,
	                    'IdAlmas' => $alma['IdAlma'],
		                ])->one();
						echo "---------------------------PRGALMA :";var_dump($programacionesalma);

						if(is_null($programacionesalma)){
		            	//programacionAlma
		                     // [['IdPedido', 'IdArea', 'IdEmpleado', 'IdProgramacionEstatus', 'IdProducto', 'Programadas', 'Hechas']
		                    $pa = new ProgramacionesAlma();
		                    $pa->IdPedido = $ped->IdPedido;
		                    $pa->IdArea = 2;
		                    $pa->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
		                    $pa->IdProgramacionEstatus = 1;
		                    $pa->IdProducto = $ped->IdProducto;
		                    $pa->Programadas = $cantidad;
		                    $pa->IdAlma = $alma['IdAlma'];
		                    $pa->Hechas = 0;
		                    $pa->save();
		                    $programacionesalma = $pa;
		                    echo "new Programacionesalma: ". $programacionesalma->IdProgramacionAlma;
		    			}
		         
		    
		    			$programacioensalmasemana = ProgramacionesAlmaSemana::find()->where([
	                    'IdProgramacionAlma' => $programacionesalma->IdProgramacionAlma,
		                ])->one();
		    			// echo "---------------------------prgALMAsemana :";var_dump($programacioensalmasemana);

			    		if(is_null($programacioensalmasemana)){
			            //programacionesAlmaSemana
		                    // [['IdProgramacionAlma', 'Anio', 'Semana', 'Programadas']
		    				$ps = new ProgramacionesAlmaSemana();
		                    $ps->IdProgramacionAlma = $programacionesalma->IdProgramacionAlma;
		                    $ps->Anio = date('Y');
		                    $ps->Semana = date('W');
		                    $ps->Programadas = $cantidad;
		                    $ps->save();
		                    $programacioensalmasemana = $ps;
		                    echo "new Programacionesalmasem: ". $programacioensalmasemana->IdProgramacionAlmaSemana;
		                }

		                $programacioensalmadia = ProgramacionesAlmaDia::find()->where([
	                    'IdProgramacionAlmaSemana' => $programacioensalmasemana->IdProgramacionAlmaSemana,
		                ])->one();
		                	if(is_null($programacioensalmadia)){
			            		//ProgramacionesAlmaDia
			                    // [['IdProgramacionAlmaSemana', 'Dia', 'Programadas', 'IdCentroTrabajo', 'IdMaquina'],
			                    $pd = new ProgramacionesAlmaDia();
			                    $pd->IdProgramacionAlmaSemana = $programacioensalmasemana->IdProgramacionAlmaSemana;
			                    $pd->Dia  = date('Y-m-d');
			                    $pd->Programadas = 10;
			                    $pd->IdCentroTrabajo = 31; // BetaSet
			                    $pd->IdMaquina = 2041; //sopladora de corazones
			                    $pd->save();
			                    $programacioensalmadia = $pd;
			                     echo "new Programacionesalmasdia: ". $programacioensalmadia->IdProgramacionAlmaDia;
            				}
            	}
            }    
            

		    $tran->commit();

		}catch(Exception $e) {

		    $tran->rollback();
		    var_dump($e);

		}



	}

	public function setProgramacionPK_moldeo($pk){

		 $conn = \Yii::$app->db;
		
		if($pk == 'probeta'){
			$producto = $this->ProductoProbeta;
		}elseif($pk == 'keelblock') {
			$producto = $this->ProductoKeelBlock;
		}else{
			echo "Producto no Valido";
			return 0;
		}
		
		$ped  =  Pedidos::find()->where(
				"
				IdProducto = $producto and 
				Cliente = 201106246320690 and
				SaldoCantidad > 0
				"
			)->one();

		 if ($ped == null){  
		 	echo "Sin pedido Inmortal para  $pk ";
		 	return 0;
		 } 
		 	
		$tran = $conn->beginTransaction();
		try {
			
			$p  = new Programaciones();
			$ps = new ProgramacionesSemana();
			$pd = new ProgramacionesDia();

			// programaciones 
                    $p->IdPedido= $ped->IdPedido;
                    $p->IdArea =2;
                    $p->IdEmpleado = Yii::$app->user->identity->IdEmpleado;
                    $p->IdProgramacionEstatus = 1;
                    $p->IdProducto = $ped->IdProducto;
                    $p->Programadas = 2;
                    $p->Hechas = 0;
                    $p->Cantidad = 2;
                    $p->save();
                    var_dump($p);
            //programacion semana 
                    $ps->IdProgramacion = $p->IdProgramacion;
                    $ps->Anio = date('Y');
                    $ps->Semana = date('W');
                    $ps->Prioridad = 0;
                    $ps->Programadas = $p->Programadas;
                    $ps->Hechas= 0; 
                    $ps->save();
                    var_dump($ps);
             //programacion Dia
                    $pd->IdProgramacionSemana = $ps->IdProgramacionSemana;
                    $pd->Dia = date('Y-m-d');
                    $pd->Programadas = $ps->Programadas;
                    $pd->IdTurno = 1;
                    $pd->IdCentroTrabajo = 1;
                    $pd->IdMaquina =  1;
                    $pd->save();
                    var_dump($pd);


		    $tran->commit();

		}catch(Exception $e) {

		    $tran->rollback();
		    var_dump($e);

		}



	}
	

}