<?php

namespace frontend\controllers;

use Yii;
use frontend\models\programacion\VResumenDiario;

class MoldeoBronceController extends ProduccionController
{
    public $IdArea = 3;
    
    function init(){
        $this->layout = "bronces";
        $this->IdArea = 3;
        $this->IdProceso = 1;
    }
    
    function actionSaveDetalle() {
    }
    
    function actionSaveProduccion() {
    }
    
    public function actionSemanal(){
        return $this->Semanal(1,2);
    }
    
    public function actionDiario(){
        return $this->Diario(1,3,'Reporte de programación diario ( Bronces ) F-PC-7.0-47');
    }
    
    public function actionDataDiaria(){
        return $this->DataDiaria($this->IdArea,$this->IdProceso,$_REQUEST['semana'],$_REQUEST['turno']);
    }
    
    public function actionResumenDiario(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $turno = isset($_REQUEST['turno']) ? $_REQUEST['turno'] : 1;
        $area = $this->IdArea;

        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        for($x=1;$x<7;$x++){
            $res = VResumenDiario::find()->where([
                'IdArea' => $area,
                'Anio' => $year,
                'Semana' => $week,
                'Dia' => $fecha,
                'IdTurno' => $turno,
                ])->asArray()->one();
            if($res == null){
                $res = [
                    'IdArea' => $area,
                    'Anio' => $year,
                    'Semana' => $week,
                    'Dia' => $fecha,
                    'IdTurno' => $turno,
                    'PrgMol' => 0,
                    'PrgPzas' => 0,
                    'PrgTonP' => 0,
                    'PrgTon' => 0,
                    'PrgHrs' => 0,
                    'HecMol' => 0,
                    'HecPzas' => 0,
                    'HecTonP' => 0,
                    'HecTon' => 0,
                    'HecHrs' => 0
                ];
            }
            $resumen[] = $res;
            $fecha = date('Y-m-d',strtotime('+1day',strtotime($fecha)));
        }
        return json_encode($resumen);
    }
}
