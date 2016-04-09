<?php

namespace frontend\controllers;

use yii;
use frontend\models\programacion\VResumenDiariaAcero;

class MoldeoAceroController extends ProduccionController
{
    public $IdArea = 2;
    public $IdProceso = 1;
        
    function init(){
        $this->layout = "aceros";
    }
    
    function actionSaveDetalle() {
        
    }
    
    function actionSaveProduccion() {
        
    }
    
    public function actionSemanal(){
        return $this->Semanal(1,2,'');
    }
    
    public function actionRutas(){
        return $this->render('Rutas', [
            'IdArea' => $this->IdArea
        ]);
    }
    
    public function actionDataSemanal(){
        $dataProvider = $this->DataSemanal($this->IdArea,$this->IdProceso,$_REQUEST['Estatus'],$_REQUEST['semana1']);

        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
            ]);
        }
        
        return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
        ]);
    }
    
    public function actionDiario(){
        return $this->Diario(1,2,'Reporte de programación diario ( Aceros )');
    }
    
    public function actionDataDiaria(){
        return $this->DataDiaria($this->IdArea,$this->IdProceso,$_REQUEST['semana'],$_REQUEST['turno']);
    }
    
    public function actionResumenDiarioAcero(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $area = Yii::$app->session->get('area');
        $area = $area['IdArea'];
        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        for($x=1;$x<7;$x++){
            $res = VResumenDiariaAcero::find()->where([
                'IdArea' => $area,
                'Anio' => $year,
                'Semana' => $week,
                'Dia' => $fecha,
                ])->asArray()->one();
            if($res == null){
                $res = [
                    'IdArea' => $area,
                    'Dia' => $fecha,
                    'TonPrgK' => 0,
                    'TonPrgV' => 0,
                    'TonPrgE' => 0,
                    'TonVacK' => 0,
                    'TonVacV' => 0,
                    'TonVacE' => 0,
                    'CiclosK' => 0,
                    'CiclosV' => 0,
                    'CiclosE' => 0,
                    'MolPrgK' => 0,
                    'MolPrgV' => 0,
                    'MolPrgE' => 0
                ];
            }
            $resumen[] = $res;
            $fecha = date('Y-m-d',strtotime('+1day',strtotime($fecha)));
        }
        return json_encode($resumen);
    }
    
    public function CapturaInventarios($transaccion = true){
        $this->layout = 'produccion';
        
        return $this->render('CapturaInventarios', [
            'transaccion'=> $transaccion,
            'IdArea' => $this->IdArea
        ]);
    }
    
    public function actionTransferencias(){
        return $this->CapturaInventarios(false);
    }
    
    public function actionTransacciones(){
        return $this->CapturaInventarios();
    }
}
