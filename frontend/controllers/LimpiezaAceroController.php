<?php

namespace frontend\controllers;

use Yii;
use frontend\models\programacion\VResumenLimpiezaAcero;
use frontend\models\programacion\VResumenAcero;
use frontend\models\programacion\VResumenCelda;
use frontend\models\programacion\VResumenDiariaLimpiezaAcero;
use frontend\models\produccion\VProgramacionLimpieza;
use common\models\catalogos\VMaquinas;

class LimpiezaAceroController extends ProduccionController
{
    public $IdArea = 2;
    public $IdProceso = 2; //Proceso de limpieza
    
    function init(){
        $this->layout = "aceros";
    }
    
    function actionSaveDetalle(){
        $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        $_REQUEST['Inicio'] = date('Y-m-d H:i:s',strtotime($_REQUEST['Inicio']));
        $_REQUEST['Fin'] = date('Y-m-d H:i:s',strtotime($_REQUEST['Fin']));
        $_REQUEST['Fin'] = strtotime($_REQUEST['Fin']) >= strtotime($_REQUEST['Inicio']) ? $_REQUEST['Fin'] : date('Y-m-d H:i:s',strtotime( '+1 day' ,strtotime($_REQUEST['Fin'])));
        $_REQUEST['Eficiencia'] = isset($_REQUEST['Eficiencia']) ? $_REQUEST['Eficiencia'] : 1;
        $_REQUEST['CiclosMolde'] *= 1;
        $_REQUEST['Hechas'] *= 1;
        $_REQUEST['Rechazadas'] *= 1;
        //var_dump($_REQUEST);exit;
        $model = $this->saveDetalle($_REQUEST);

        $model['Fin'] = date('Y-m-d H:i:s',strtotime($_REQUEST['Fin']));
        $model['Inicio'] = date('Y-m-d H:i:s',strtotime($_REQUEST['Inicio']));
                
        return json_encode($model);
    }
    
    function actionSaveProduccion(){
        return json_encode($this->saveProduccion($_REQUEST));
    }
    
    public function actionSemanal(){
        return $this->Semanal(2,2,'Programacion Semanal Limpieza');
    }
    
    public function actionDiario(){
        return $this->Diario(2,2,'Reporte de programación diario ( Limpieza Acero)');
    }
    
    public function actionDataSemanal2(){
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1']);
        var_dump($semanas);
        return $this->DataSemanal($this->IdArea,2,$_REQUEST['Estatus']);
    }
    
    public function actionDataSemanal(){
        return $this->DataSemanal($this->IdArea,2,$_REQUEST['Estatus'],$_REQUEST['semana1']);
    }
    
    public function actionResumenSemanal(){
        $semanas = $this->LoadSemana(!isset($_REQUEST['semana']) ? '' : $_REQUEST['semana']);
        foreach ($semanas as $semana){
            
            $res = VResumenLimpiezaAcero::find()->where([
                'IdArea' => $this->IdArea,
                'Anio' => $semana['year'],
                'Semana' => $semana['week'],
            ])->asArray()->all();
            
            $meta = VResumenAcero::find()
                ->select("SUM(PzaMeta) AS PzaMeta, SUM(TonMeta) AS TonMeta")
                ->where("Anio = " . $semana['year'] . " AND Semana = " . $semana['week'] . " AND IdAleacionTipo <> 15")
                ->asArray()
                ->one();
            
            $datos = [
                "IdArea" => $this->IdArea,
                "Anio" => $semana['year'],
                "Semana" => $semana['week'],
                "TonPrg" => 0,
                "TonHechas" => 0,
                "Hechas" => 0,
                "PzaPrg" => 0,
                "PzaMeta" => isset($meta['PzaMeta']) ? $meta['PzaMeta'] : 0,
                "TonMeta" => isset($meta['TonMeta']) ? $meta['TonMeta'] : 0,
            ];

            if(count($res)>0){
                foreach($res as $res2){
                    $datos['TonPrg'] += $res2['TonPrg'];
                    $datos['TonHechas'] += $res2['TonHechas'];
                    $datos['PzaPrg'] += $res2['PzaPrg'];
                    $datos['Hechas'] += $res2['Hechas'];
                }
            }
            $resumen[] = $datos;
        }
        return json_encode($resumen);
    }
    
    public function actionDataDiaria(){
        return $this->DataDiaria($this->IdArea,2,$_REQUEST['semana'],$_REQUEST['turno']);
    }
    
    public function actionResumenCelda(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        
        $centros = VMaquinas::find()->distinct()->select("IdCentroTrabajo,Descripcion")->where("IdSubProceso = 12 AND IdMaquina IS NOT NULL")->asArray()->all();
        
        foreach($centros as &$centro){
            for($x=1;$x<=7;$x++){
                $resumen = VResumenCelda::find()
                    ->where("Anio = $year AND Semana = $week AND IdCentroTrabajo = ". $centro['IdCentroTrabajo'] . " AND DiaSemana = $x")
                    ->asArray()
                    ->one();
                $centro["Pzas$x"] = isset($resumen['Pzas']) ? $resumen['Pzas'] * 1 : 0;
                $centro["TON$x"] = isset($resumen['TON']) ? $resumen['TON'] * 1 : 0;
            }
        }
        return json_encode($centros);
    }
    
    public function actionResumenDiario(){
        $dia = !isset($_REQUEST['semana']) ? date('Y-m-d') : $_REQUEST['semana'];
        $year = date('Y',strtotime($dia));
        $week = date('W',strtotime($dia));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        
        $meta = VResumenAcero::find()
            ->select("SUM(PzaMeta) AS PzaMeta, SUM(TonMeta) AS TonMeta")
            ->where("Anio = $year AND Semana = $week AND IdAleacionTipo <> 15")
            ->asArray()
            ->one();
        
        for($x=1;$x<7;$x++){
            $res = VResumenDiariaLimpiezaAcero::find()->where([
                'IdArea' => $this->IdArea,
                'Anio' => $year,
                'Semana' => $week,
                'Dia' => $fecha,
                ])->asArray()->one();
            if($res == null){
                $res = [
                    'IdArea' => $this->IdArea,
                    'Anio' => $year,
                    'Semana' => $week,
                    'Dia' => $fecha,
                    'PzasProg' => 0,
                    'TonProg' => 0,
                    'PzasHechas' => 0,
                    'TonHechas' => 0,
                ];
            }
            $resumen[] = $res;
            $fecha = date('Y-m-d',strtotime('+1day',strtotime($fecha)));
        }
        
        return json_encode($resumen);
    }
    
    public function actionCaptura(){
        return $this->CapturaProduccion(12);
    }
    
    public function actionMaquinas(){
        return $this->Maquinas($_REQUEST);
    }
    
    public function actionProgramacion(){
        $_REQUEST['Dia'] = date('Y-m-d',strtotime($_REQUEST['Dia']));
        unset($_REQUEST['IdMaquina']);
        
        $_REQUEST['Semana'] = date('W',strtotime($_REQUEST['Dia']));
        //unset($_REQUEST['Dia']);
        unset($_REQUEST['IdTurno']);
        unset($_REQUEST['IdSubProceso']);
        $model = VProgramacionLimpieza::find()
            ->distinct()
            ->select('IdProgramacionSemana,IdProgramacion,Anio,Semana,Dia,Prioridad,Programadas,Hechas,Llenadas,Cerradas,Vaciadas,IdProceso, Producto, IdProducto, IdProductoCasting, Aleacion, IdTurno, CiclosMolde, PiezasMolde')
            ->where($_REQUEST)
            ->asArray()
            ->all();
        
        return json_encode($model);
    }
}
