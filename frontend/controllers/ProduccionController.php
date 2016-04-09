<?php

namespace frontend\controllers;

use Yii;

//Programacion
use common\models\dux\Productos;
use common\models\dux\VProductos;
use common\models\dux\AleacionesTipo;
use common\models\datos\Bitacora;
use common\models\datos\SerieCavidad;

use common\models\catalogos\CentrosTrabajo;
use common\models\catalogos\CentrosTrabajoRutas;
use common\models\catalogos\SubProcesos;
use common\models\catalogos\VEmpleados;
use common\models\catalogos\VMaquinas;
use common\models\catalogos\Materiales;
use common\models\catalogos\Turnos;
use common\models\catalogos\VDefectos;

use frontend\models\programacion\VPedidos;
use frontend\models\programacion\Pedidos;
use frontend\models\programacion\Programacion;
use frontend\models\programacion\VProgramacionesDia;
use frontend\models\programacion\ProgramacionesDia;
use frontend\models\programacion\VEmbarques;
use frontend\models\programacion\VEmbarquesBronce;

use frontend\models\produccion\Series;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesDetalleMaterialVaciado;

use frontend\models\inventario\VExistencias;
use frontend\models\inventario\Inventarios;
use frontend\models\inventario\InventarioTransferencias;
use frontend\models\inventario\InventarioMovimientos;
use frontend\models\inventario\Existencias;
use frontend\models\inventario\ExistenciasDetalle;
use frontend\models\inventario\SerieMovimientos;
use frontend\models\inventario\UnionInv;
use frontend\models\inventario\VCentrosRutas;

//Produccion
abstract class ProduccionController extends \yii\web\Controller
{
    public $IdArea;
    public $IdProceso;
    
    abstract function actionSaveDetalle();
    abstract function actionSaveProduccion();
     
    function actionIndex(){
        return $this->render('index');
    }
    
    public function actionActualizacion(){
        $model = new Programacion();
        return date('d-m-Y h:i',strtotime($model->getActualizacion()[0]['FechaInicio']));
    }
    
    /*
     * CONTROL DE PROGRAMACIONES --- INICIO ---
     */
    
    public function Semanal($IdProceso,$IdArea,$title){
        $this->layout = 'programacion';
        
        return $this->render('programacion',[
            'IdProceso' => $IdProceso,
            'IdArea' => $IdArea,
            'TipoUsuario' => Yii::$app->user->identity->role,
            'title' => $title
        ]);
    }
    
    public function DataSemanal2($IdArea,$IdProceso,$IdProgramacionEstatus = 1,$offSet = 1,$limit = 20){
        $Programaciones = Programacion::find()->where([
            'IdArea' => $IdArea,
            'IdProgramacionEstatus' => $IdProgramacionEstatus,
        ])->offset($offSet)->limit($limit)->asArray()->all();
        
        var_dump($Programaciones);
    }
    
    public function DataSemanal($IdArea,$IdProceso,$Estatus,$Semana){
        $semanas = $this->LoadSemana(!isset($Semana) ? '' : $Semana);

        $programacion = new Programacion();
        //$programacion
        $dataProvider = $programacion->getProgramacionSemanal($IdArea,$IdProceso,$semanas,$Estatus);
        //var_dump($dataProvider->allModels);exit;
        $Producto = '';
        foreach ($dataProvider->allModels as &$value) {
            $value['Orden2'] = $value['OrdenCompra'];
            $value['FechaEnvio'] = $value['FechaEnvio'] == '' ? $value['FechaEnvio'] : date(DATE_ISO8601,  strtotime($value['FechaEnvio']));
            
            if($value['Producto'] == $value['ProductoCasting']){
                $value['SemanaActual'] = date('W',  strtotime($value['FechaEnvio']));
                $value['SemanaActual'] -= date('N',  strtotime($value['FechaEnvio'])) > 2 ? 1 : 2;
            }
            
            $value['Cantidad']*=1;
            
            $x = 1;
            while(isset($value['Prioridad'.$x])){
                $value['Prioridad'.$x]*=1;
                $value['Programadas'.$x]*=1;
                $value['Kilos'.$x] = $value['Programadas'.$x] * $value['PesoCasting'];
                $value['Prioridad'.$x] = $value['Prioridad'.$x] == 0 ? '' : $value['Prioridad'.$x];
                $value['Programadas'.$x] = $value['Programadas'.$x] == 0 ? '' : $value['Programadas'.$x];
                $x++;
            }
            

            $value['Moldes']= round($value['Moldes'],0,PHP_ROUND_HALF_UP);
            
            $value['SaldoCantidad']*=1;
            
            if($value['Producto'] != $Producto){
                $Casting = $value['Cast'];
                $Maquinado = $value['Maq'];
                $FaltaCasting = 0;
                $FaltaMaquinado = 0;
            }
            
            $Maquinado = $Maquinado < 0 ? 0 : $Maquinado;
            $Casting = $Casting < 0 ? 0 : $Casting;
            
            $value['ExitMaquinado'] = $Maquinado;
            $value['ExitCasting'] = $Casting;
            
            if($Maquinado > 0){
                $FaltaMaquinado = $Maquinado > $value['SaldoCantidad'] ? 0 : $value['SaldoCantidad'] - $Maquinado;
                $Maquinado -= $value['SaldoCantidad'];
            }else{
                $FaltaMaquinado = $value['SaldoCantidad'];
            }
            
            if($Casting > 0 && $Maquinado <= 0){
                $FaltaCasting = $Casting > $FaltaMaquinado ? 0 : $FaltaMaquinado - $Casting;
                $Casting -= $FaltaMaquinado;
            }else{
                $FaltaCasting = $FaltaMaquinado;
            }
            
            $value['FaltaMaquinado'] = $FaltaMaquinado;
            $value['FaltaCasting'] = $FaltaCasting;
            $value['class'] = $value['FaltaCasting'] == 0 ? 'background-color: lightgreen;' : '';
            
            $Producto  = $value['Producto'];
        }
        
        return json_encode($dataProvider->allModels);
    }
    
    public function actionLoadSemana(){
        $val = $this->LoadSemana(!isset($_REQUEST['semana1']) ? '' : $_REQUEST['semana1']);
        return json_encode($val);
    }
    
    public function LoadSemana($semana1= '',$TotalSemanas = 6){
        if($semana1 == ''){
            $mes = date('m');
            $semana1 = $mes == 12 && date('W') == 1 ? [date('Y')+1,date('W'),date('Y-m-d')] : [date('Y'),date('W'),date('Y-m-d')];
        }else{
            $semana1 = date('Y-m-d',strtotime($semana1));
            $mes = date('m',strtotime($semana1));

            $semana1 = $mes == 12 && date('W',strtotime($semana1)) == 1 ? [date('Y',strtotime($semana1))+1,1* date('W',strtotime($semana1)),$semana1] : [date('Y',strtotime($semana1)),1 * date('W',strtotime($semana1)),$semana1];
        }
        
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'val'=>$semana1[2]];
        
        for($x=1; $x < $TotalSemanas; $x++){
            $semanas['semana'.($x+1)] = $this->checarSemana($semanas['semana'.$x]);
        }
        //var_dump($semanas);exit;
        return $semanas;
    }
    
    public function checarSemana($semana){
        $ultimaSemana = date('W',strtotime($semana['year'].'-12-31'));
        if($semana['week'] == $ultimaSemana || $ultimaSemana == '01'){
            $semana['week'] = 1;
            $semana['year']++;
        }
        else
            $semana['week']++;
        $semana['val'] = date('Y-m-d',strtotime('+7 day',strtotime($semana['val'])));

        return $semana;
    }
    
    public function Diario($IdProceso,$IdArea,$title){
        $this->layout = 'programacion';
        
        return $this->render('programacionDiaria',[
            'title'=>$title,
            'IdArea'=>$IdArea,
            'IdProceso'=>$IdProceso,
            'turno'=>1,
            'TipoUsuario' => Yii::$app->user->identity->role
        ]);
    }
    
    public function actionLoadDias($semana = ''){
        $diasSemana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];

        $year = $semana == '' ? date('Y') : date('Y',strtotime($semana));
        $week = $semana == '' ? date('W') : date('W',strtotime($semana));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        //echo $fecha;exit;
        
        for($x=0;$x<6;$x++){
            $dias[] = $diasSemana[$x]." ".date('d-m-Y',strtotime($fecha));
            $fecha = date('Y-m-d',strtotime("+1 Day",strtotime($fecha)));
        }
        return json_encode($dias);
    }
    
    public function DataDiaria($IdArea, $IdProceso, $Semana = '', $IdTurno = 1){
        //var_dump($Semana);
        $Semana = $Semana == '' ? [date('Y'),date('W')] : [date('Y',strtotime($Semana)),date('W',strtotime($Semana))];
        //var_dump($Semana);exit;
        $Semana['semana1'] = ['year'=>$Semana[0],'week'=>$Semana[1],'value'=>"$Semana[0]-$Semana[1]"];

        $programacion = new Programacion();
        $dataProvider = $programacion->getprogramacionDiaria($Semana,$IdArea,$IdProceso,$IdTurno);
        //var_dump($dataProvider->allModels);exit;
        if(count($dataProvider)==0){
            return json_encode([
                'total'=>0,
                'rows'=>[],
                'footer'=>[],
                'ResumenSem'=>[],
            ]);
        }

        if($IdArea == 3){
            $IdMaquina = 1700;
        }else{
            $IdMaquina = 1755;
        }
            
        foreach($dataProvider->allModels as &$dat){
            $dat['Programadas1'] = $dat['Programadas1'] == 0 ? '' : $dat['Programadas1'] * 1;
            $dat['Programadas2'] = $dat['Programadas2'] == 0 ? '' : $dat['Programadas2'] * 1;
            $dat['Programadas3'] = $dat['Programadas3'] == 0 ? '' : $dat['Programadas3'] * 1;
            $dat['Programadas4'] = $dat['Programadas4'] == 0 ? '' : $dat['Programadas4'] * 1;
            $dat['Programadas5'] = $dat['Programadas5'] == 0 ? '' : $dat['Programadas5'] * 1;
            $dat['Programadas6'] = $dat['Programadas6'] == 0 ? '' : $dat['Programadas6'] * 1;
            $dat['MoldesHora']*=1;
            $dat['TotalHecho'] = $dat['TotalHecho'] == 0 ? 0 : $dat['TotalHecho'] * 1;
            $dat['TotalProgramado'] = $dat['TotalProgramado'] == '' ? 0 : $dat['TotalProgramado'] * 1;
            $dat['Programadas'] = $dat['Programadas'] == 0 ? '' : $dat['Programadas'] * 1;
            $dat['Hechas']*=1;
            $dat['Maquina1'] = $dat['Maquina1'] == null ? $IdMaquina : ($dat['Maquina1']*1);
            $dat['Maquina2'] = $dat['Maquina2'] == null ? $IdMaquina : ($dat['Maquina2']*1);
            $dat['Maquina3'] = $dat['Maquina3'] == null ? $IdMaquina : ($dat['Maquina3']*1);
            
            $dat['Maquina4'] = $dat['Maquina4'] == null ? $IdMaquina : ($dat['Maquina4']*1);
            $dat['Maquina5'] = $dat['Maquina5'] == null ? $IdMaquina : ($dat['Maquina5']*1);
            $dat['Maquina6'] = $dat['Maquina6'] == null ? $IdMaquina : ($dat['Maquina6']*1);
            $dat['Maquina7'] = $dat['Maquina7'] == null ? $IdMaquina : ($dat['Maquina7']*1);
        }
        
        return json_encode([
            'total'=>count($dataProvider->allModels),
            'rows'=>$dataProvider->allModels,
            //'footer'=>$dataResumen[0],
            //'ResumenSem'=>$dataResumen[1],
        ]);
    }
    
    public function actionPedidos(){
        $this->layout = 'JSON';
        $model = new Pedidos();
        
        $fecha = isset($_REQUEST['fecha']) ? date('Y-m-d',strtotime($_REQUEST['fecha'])) : '';
        $dataProvider = $model->getSinProgramar($fecha , $_REQUEST['IdArea']);

        if(count($dataProvider)>0){
            return json_encode([
                'total'=>count($dataProvider->allModels),
                'rows'=>$dataProvider->allModels,
            ]);
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionSaveSemanal(){
        $model = new Programacion();

        $dat = $_REQUEST;
        
        $dat['Prioridad'] = isset($dat['Prioridad']) && $dat['Prioridad'] != '' ? $dat['Prioridad'] : 'NULL';
        $dat['Programadas'] = isset($dat['Programadas']) && $dat['Programadas'] != '' ? $dat['Programadas'] : 'NULL';
        //var_dump($dat);exit;
        $datosSemana1 = $dat['IdProceso'].",".$dat['IdProgramacion'].",".$dat['Anio'].",".$dat['Semana'].",".$dat['Prioridad'].",".$dat['Programadas'];
        return $model->setProgramacionSemanal($datosSemana1);
        $this->SetBitacora("Programacion Actualizada Producto: ".$dat['Producto']." Año: ".$dat['Anio'].", Semana: ".$dat['Semana'],"ProgramacionSemanal","Programadas",$dat['Programadas'],"");
    }
    
    public function actionSaveDiario(){
        $model = new Programacion();
        $maquinas = new VMaquinas();
        $dat = $_REQUEST;
        $guardado = false;
        $dat['Prioridad'] = isset($dat['Prioridad'])?$dat['Prioridad'] : 'NULL';
        
        if(isset($dat['Programadas'])){
            
            $maquina = isset($dat['Maquina']) ? $dat['Maquina'] : 1;
            if(isset($dat['IdCentroTrabajo'])){
                $IdCentroTrabajo = $dat['IdCentroTrabajo'];
            }else{
                $maq = $maquinas->find()->where("IdMaquina = $maquina")->asArray()->all();
                $IdCentroTrabajo = $maq[0]['IdCentroTrabajo'];
            }
            $datosSemana = $dat['IdProgramacionSemana'].",'".$dat['Dia']."',".$dat['Prioridad'].",".$dat['Programadas'].",".$dat['IdTurno'].",$maquina,$IdCentroTrabajo";
            
            if($model->setProgramacionDiaria($datosSemana)){
                $this->SetBitacora("Programacion Actualizada Producto: ".$dat['Producto']." Dia: ".$dat['Dia'],"ProgramacionDiaria","Programadas",$dat['Programadas'],"");
                $this->SetBitacora("Programacion Actualizada Producto: ".$dat['Producto']." Dia: ".$dat['Dia'],"ProgramacionDiaria","Prioridad",$dat['Prioridad'],"");
            }

            if(isset($dat['Tarimas'])){
                $where = [
                    'IdProgramacionSemana' => $dat['IdProgramacionSemana'],
                    'Dia' => $dat['Dia'],
                    'IdTurno' => $dat['IdTurno']
                ];
                $tarimas = json_decode($dat['Tarimas'],true);
                $ciclosMolde = !isset($dat['CiclosMolde']) || $dat['CiclosMolde'] == 0 ? 1 : $dat['CiclosMolde'];
                $programacionDia = ProgramacionesDia::find()->where($where)->one();
                
                foreach($tarimas as $tarima){
                    $datosTarima = "$datosSemana,".$tarima['Loop'].",".$tarima['Tarima'].",".(isset($dat['Delete'])?1:0);
                    $model->setProgramacionTarima($datosTarima);
                }
                
                $programadas = VTarimas::find()->select('count(IdProgramacionDia) AS Programadas')->where(['IdProgramacionDia' => $programacionDia->IdProgramacionDia])->one();
                $programacionDia->Programadas = $programadas->Programadas / $ciclosMolde;
                $programacionDia->update();
            }
            $guardado = true;
        }
        return $guardado;
    }
    
    /*
     * CONTROL DE PROGRAMACIONES --- FIN ---
     */
    
    /****************************************************
     *  CONTROL DE INVENTARIOS ------ INICIO ------
     ****************************************************/
    
    function actionGetInventarios($where = '',$limit = '',$offset = ''){
        $model = Inventarios::find()->where($where)->with('inventarioMovimientos','inventarioTransferencias')->limit($limit)->offset($offset)->asArray()->all();
        return json_encode($model);
    }
    
    function actionCountInventario($transaccion = 0){
        $model = Inventarios::find()->select('count(IdInventario) AS Total')->where(['Transaccion'=>$transaccion])->asArray()->one();
        return $model['Total']*1;
    }
    
    function generarMovimiento($IdProduccion,$produccionDetalle,$IdSubProceso,$IdCentroTrabajo = 1,$Cantidad,$Tipo,$Series = ''){
        $UnionInv = $this->actionGetUnionInv([
            'IdProduccion' => $IdProduccion['IdProduccion'],
            //'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
        ]);
        
        $data = [
            'Fecha' => $IdProduccion['Fecha'],
            'IdEmpleado' => $IdProduccion['IdEmpleado'],
            'IdSubProceso' => $IdProduccion['IdSubProceso']
        ];
        
        if(count($UnionInv)>0){
            $data['IdInventario'] = $UnionInv->IdInventario;
            $encabezado = $this->actionGetInventario($data);
        }else{
            $encabezado = json_decode($this->actionSaveInventario($data));
        }

        $movimiento = $this->actionGetMovimientos([
            'IdInventario' => $encabezado->IdInventario,
            'IdSubProceso' => $IdSubProceso,
            'IdCentroTrabajo' => $IdCentroTrabajo,
            'IdProducto' => $produccionDetalle->IdProductos,
            'Cantidad' => $Cantidad * ($Tipo == 'E' ? 1 : -1),
            'Series' => $Series,
            'FechaMoldeo' => $produccionDetalle->FechaMoldeo,
            'Tipo' => $Tipo,
        ]);

        $unioninv = $this->actionUnionInv([
            'IdProduccion' => $IdProduccion['IdProduccion'],
            'IdProduccionDetalle' => $produccionDetalle->IdProduccionDetalle,
            'IdInventario' => $encabezado->IdInventario,
            'IdInventarioMovimiento' => $movimiento->IdInventarioMovimiento,
        ]);
    }
    
    function actionInventario($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        $model = VExistencias::find()->where($data)->orderBy('IdSubProceso ASC, Descripcion ASC, Identificacion ASC')->asArray()->all();
        return json_encode($model);
    }
    
    function actionSaveTransferencia($data = ''){
        $tran = Yii::$app->db->beginTransaction();
        
        try {
            if($data == ''){
                $data = $_REQUEST;
            }
            
            if(isset($data['$$hashKey'])){unset($data['$$hashKey']);}

            if(isset($data['IdInventarioTransferencia'])){
                $model = InventarioTransferencias::findOne($data['IdInventarioTransferencia']);
            }else{
                $model = new InventarioTransferencias();
            }

            if(!isset($data['idInventarioMovimientoSalida']['IdInventarioMovimiento']) && isset($data['idInventarioMovimientoSalida'])){
                $data['IdInventarioMovimientoSalida'] = json_decode($this->actionSaveMovimiento(json_decode($data['idInventarioMovimientoSalida'],true)),true)['IdInventarioMovimiento'];
                unset($data['idInventarioMovimientoSalida']);
            }

            if(!isset($data['idInventarioMovimientoEntrada']['IdInventarioMovimiento']) && isset($data['idInventarioMovimientoEntrada'])){
                $data['IdInventarioMovimientoEntrada'] = json_decode($this->actionSaveMovimiento(json_decode($data['idInventarioMovimientoEntrada'],true)),true)['IdInventarioMovimiento'];
                unset($data['idInventarioMovimientoEntrada']);
            }

            $model->load(['InventarioTransferencias'=>$data]);

            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }
            
            //$tran->rollback();
            $tran->commit();
            
            return json_encode(InventarioTransferencias::find()
                ->where(['IdInventarioTransferencia' => $model->IdInventarioTransferencia])
                ->with('idInventarioMovimientoEntrada','idInventarioMovimientoSalida')
                ->asArray()
                ->one()
            );
            
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            return json_encode(['error' => $e->getMessage()]);
            throw new \yii\base\Exception($e);
        }
    }
    
    function actionSaveInventario($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        if(isset($data['IdInventario'])){
            $model = Inventarios::findOne($data['IdInventario']);
        }else{
            $model = new Inventarios();
        }
        
        $data['IdEstatusInventario'] = 1;
        $model->load(['Inventarios' => $data]);
        
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        
        return $this->actionGetInventarios(['IdInventario' => $model->IdInventario],'','');
    }
    
    function actionSaveMovimiento($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        if(isset($data['idCentroTrabajo'])){
            unset($data['idCentroTrabajo']);
        }
        
        if(isset($data['idSubProceso'])){
            unset($data['idSubProceso']);
        }
        
        if(isset($data['idProducto'])){
            unset($data['idProducto']);
        }
        
        if(isset($data['serieMovimientos'])){
            unset($data['serieMovimientos']);
        }
        
        foreach($data as $key => $value){
            if(is_null($value)){
                unset($data[$key]);
            }
        }

        if(isset($data['IdInventarioMovimiento'])){
            $model = InventarioMovimientos::findOne($data['IdInventarioMovimiento']);
        }else{
            $model = new InventarioMovimientos();
        }
        
        $model->load(['InventarioMovimientos' => $data]);
        
        if(isset($data['Tipo']) && $data['Tipo'] == 'S'){
            $existencia = $this->actionGetExistencia([
                'IdSubProceso' => $model->IdSubProceso,
                'IdCentroTrabajo' => $model->IdCentroTrabajo,
                'IdProducto' => $model->IdProducto
            ]);
            
            $productos = json_decode($this->actionGetProducto(['IdProducto' => $model->IdProducto]),true);
            
            if ($productos['FechaMoldeo'] == 1) {
                $ExistenciasDetalle = $this->actionGetExistenciaDetalle([
                    'IdExistencia' => $existencia['IdExistencias'],
                    'FechaMoldeo' => $partida['FechaMoldeo'],
                ]);
                //var_dump($ExistenciasDetalle);exit;

                if($model->Tipo == 'S'){
                    if($ExistenciasDetalle->Existencia < abs($model->Cantidad)){
                        throw new \yii\base\Exception("Producto: ".$productos['Identificacion']." Fecha Moldeo: ".$partida['FechaMoldeo']." no cuenta con la suficiente existencia, existencia actual ".$ExistenciasDetalle->Existencia);
                    }
                }

                $ExistenciasDetalle->Existencia += $model->Cantidad;

                if(!$ExistenciasDetalle->save()){
                    throw new \yii\base\Exception(json_encode($ExistenciasDetalle->errors));
                }

                $existencia->Existencia = ExistenciasDetalle::find()->select('Sum(Existencia) AS Existencia')->where(['IdExistencia' => $existencia->IdExistencias])->asArray()->one()['Existencia'];
            }else{
                if($model->Tipo == 'S'){
                    if($existencia->Existencia < abs($model->Cantidad)){
                        throw new \yii\base\Exception("Producto: ".$productos['Identificacion']." no cuenta con la suficiente existencia, existencia actual ".$existencia->Existencia);
                    }
                }

                $existencia->Existencia += $model->Cantidad;
            }
        }
        
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        
        $model = InventarioMovimientos::find()->where(['IdInventarioMovimiento'=>$model->IdInventarioMovimiento])->with('idProducto','serieMovimientos','idCentroTrabajo','idSubProceso')->asArray()->one();

        return json_encode($model);
    }
    
    function actionDeleteTransferencia($IdInventarioTransferencia){
        $tran = Yii::$app->db->beginTransaction();
        
        try {
            $model = InventarioTransferencias::findOne($IdInventarioTransferencia);
            $entrada = $model->IdInventarioMovimientoEntrada;
            $salida = $model->IdInventarioMovimientoSalida;
            
            if(!$model->delete()){
                throw new \yii\base\Exception($model->getMessage());
            }

            if(isset(json_decode($this->actionDeleteMovimiento($entrada, $tran),true)['error'])){
                throw new \yii\base\Exception("No se pudo eliminar el movimiento con Id ".$model->IdInventarioMovimientoEntrada);
            }

            if(isset(json_decode($this->actionDeleteMovimiento($salida, $tran),true)['error'])){
                throw new \yii\base\Exception("No se pudo eliminar el movimiento con Id ".$model->IdInventarioMovimientoSalida);
            }
            
            $tran->commit();
            //$tran->rollback();
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            return json_encode(['error' =>$e->getMessage()]);
            throw new \yii\base\Exception($e->getMessage());
        }
        return json_encode($model);
    }
    
    function actionDeleteMovimiento($IdInventarioMovimiento,$tran = ''){
        if($tran == '' ){
            $tran2 = Yii::$app->db->beginTransaction();
        }
        
        try {
            $model = InventarioMovimientos::findOne($IdInventarioMovimiento);
            $inventario = Inventarios::findOne($model->IdInventario);
            
            if($inventario->IdEstatusInventario === 3){
                throw new \yii\base\Exception("Transferencia ya fue afectada no se puede eliminar");
            }
            
            if(count(SerieMovimientos::find()->where(['IdInventarioMovimiento'=> $model->IdInventarioMovimiento])->asArray()->all()) > 0 ){
                if(!SerieMovimientos::deleteAll(['IdInventarioMovimiento'=> $model->IdInventarioMovimiento])){
                    throw new \yii\base\Exception($model->getMessage());
                }
            }
            
            if(!$model->delete()){
                throw new \yii\base\Exception($model->getMessage());
            }
            
            if($tran == '' ){
                $tran2->commit();
            }
        }catch(\yii\base\Exception $e) {
            if($tran == '' ){
                $tran2->rollback();
            }
            return json_encode(['error' =>$e]);
            throw new \yii\base\Exception($e->getMessage());
        }
        return json_encode($model);
    }
    
    function actionSaveSerieMovimiento($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        $model = InventarioMovimientos::findOne($data['IdInventarioMovimiento']);
        $Tipo = $model->Tipo;
        
        $model = new SerieMovimientos;
                
        $model->load(['SerieMovimientos' => $data]);
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }

        return $this->actionSaveMovimiento([
            'IdInventarioMovimiento'=>$data['IdInventarioMovimiento'],
            'Cantidad' => ($Tipo == 'S' ? (-1) : 1) * count(SerieMovimientos::find()->where(['IdInventarioMovimiento'=>$data['IdInventarioMovimiento']])->asArray()->all())
        ]);
    }
    
    function actionDeleteSerieMovimiento($data = ''){
        $Tipo = '';
        if($data == ''){
            $data = $_REQUEST;
        }
        
        if(isset($data['Tipo'])){
            $Tipo = $data['Tipo'];
            unset($data['Tipo']);
        }
        
        $model = SerieMovimientos::find()->where($data)->one();
        $IdInventarioMovimiento = $model->IdInventarioMovimiento;

        if(!$model->delete()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }

        return $this->actionSaveMovimiento([
            'IdInventarioMovimiento'=>$IdInventarioMovimiento,
            'Cantidad' => ($Tipo == 'S' ? (-1) : 1) * count(SerieMovimientos::find()->where(['IdInventarioMovimiento'=>$IdInventarioMovimiento])->asArray()->all())
        ]);
    }
    
    function actionGetExistencia($data){
        $model = Existencias::find()->where($data)->one();
        if(is_null($model)){
            $model = new Existencias();
            
            $model->load(['Existencias' => $data]);
            $model->Existencia = 0;
            
            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }

            $model = Existencias::find()->where($data)->one();
        }
        return $model;
    }
    
    function actionGetSeries($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        //$data = json_decode($data,true);
        $model = Series::find()->where($data)->asArray()->all();
        return json_encode($model);
    }
    
    function actionGetInventario($data){
        $model = Inventarios::find()->where($data)->one();
        if(is_null($model)){
            $model = new Inventarios();
            
            $model->load(['Inventarios' => $data]);
            $model->IdEstatusInventario = 1;
            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }
            //var_dump($model); exit();
            $model = Inventarios::find()->where($data)->one();
        }
        
        return $model;
    }
    
    function actionGetMovimientos($data){
        if (isset($data['Series'])) {
            $series = explode(",", $data['Series']);
            unset($data['Series']);
        }
        
        $Cantidad = $data['Cantidad'];
        unset($data['Cantidad']);

        $model = InventarioMovimientos::find()->where($data)->one();
        
        if(is_null($model)){
            $model = new InventarioMovimientos();
            
            $model->load(['InventarioMovimientos' => $data]);

            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }

            unset($data['IdCentroTrabajo']);
            unset($data['IdProducto']);
            unset($data['Cantidad']);
            //$model = Inventarios::find()->where($data)->one();
            $model = InventarioMovimientos::find()->where($data)->one();
        }
        
        $model->Cantidad = $Cantidad;
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }

        if (isset($series) && $series != '') {
            $this->SetSerieMovimientos([
                'Series' => $series,
                'IdInventarioMovimiento' => $model->IdInventarioMovimiento,
                'IdProducto' => $model->IdProducto,
            ]); 
        }

        return $model;
    }
    
    function actionUnionInv($data){
        $model = UnionInv::find()->where($data)->asArray()->one();
        
        if(is_null($model)){
            $model = new UnionInv();
            
            $model->load(['UnionInv' => $data]);
            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }
            
            $model = UnionInv::find()->where($data)->asArray()->one();
        }
        return $model;
    }
    
    function actionGetUnionInv($data){
        $model = UnionInv::find()->where($data)->one();
        return $model;
    }
    
    function SetSerieMovimientos($data){
        foreach ($data['Series'] as $key => $serie) {
            if ($serie != "") {
                $Serie = $this->GetSerie([
                    'IdSerie' => $serie,
                ]);
                $model = SerieMovimientos::find()->where([
                    'IdSerie' => $Serie['IdSerie'],
                    'IdInventarioMovimiento' => $data['IdInventarioMovimiento'],
                ])->one();
                if(is_null($model)){
                    $model = new SerieMovimientos();
                    $model->load([
                        'SerieMovimientos' => [
                            'IdSerie' => $Serie['IdSerie'],
                            'IdInventarioMovimiento' => $data['IdInventarioMovimiento'],
                        ]
                    ]);
                    if(!$model->save()){
                        throw new \yii\base\Exception(json_encode($model->errors));
                    }
                }
            }
        }
    }

    function actionGetExistenciaDetalle($data){
        $model = ExistenciasDetalle::find()->where($data)->one();
        if(is_null($model)){
            $model = new ExistenciasDetalle();
            
            $model->load(['ExistenciasDetalle' => $data]);
            $model->Existencia = 0;
            
            if(!$model->save()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }
            
            $model = ExistenciasDetalle::find()->where($data)->one();
        }
        return $model;
    }
    
    function actionDesafectarTransferencia($IdInventario){
        $tran = Yii::$app->db->beginTransaction();
        
        try {
            $encabezado = Inventarios::findOne($IdInventario);
            $encabezado->IdEstatusInventario = 1;
            
            $transferencias = InventarioTransferencias::find()->where(['IdInventario' => $IdInventario])->asArray()->all();

            foreach($transferencias as $transferencia){
                $Origen = InventarioMovimientos::findOne($transferencia['IdInventarioMovimientoSalida']);
                $Destino = InventarioMovimientos::findOne($transferencia['IdInventarioMovimientoEntrada']);
                
                $existenciaOrigen = $this->actionGetExistencia([
                    'IdSubProceso' => $Origen->IdSubProceso,
                    'IdCentroTrabajo' => $Origen->IdCentroTrabajo,
                    'IdProducto' => $Origen->IdProducto
                ]);
                
                $existenciaDestino = $this->actionGetExistencia([
                    'IdSubProceso' => $Destino->IdSubProceso,
                    'IdCentroTrabajo' => $Destino->IdCentroTrabajo,
                    'IdProducto' => $Destino->IdProducto
                ]);
                
                $productos = json_decode($this->actionGetProducto(['IdProducto' => $Origen->IdProducto]),true);
                
                //var_dump($existencia);exit;
                if ($productos['FechaMoldeo'] == 1) {
                    
                    $ExistenciasDetalleOrigen = $this->actionGetExistenciaDetalle([
                        'IdExistencia' => $existenciaOrigen['IdExistencias'],
                        'FechaMoldeo' => $Origen['FechaMoldeo'],
                    ]);
                    
                    $ExistenciasDetalleDestino = $this->actionGetExistenciaDetalle([
                        'IdExistencia' => $existenciaDestino['IdExistencias'],
                        'FechaMoldeo' => $Destino['FechaMoldeo'],
                    ]);
                    
                    $ExistenciasDetalleOrigen->Existencia -= $Origen->Cantidad;
                    $ExistenciasDetalleDestino->Existencia -= $Destino->Cantidad;

                    if(!$ExistenciasDetalleOrigen->save()){
                        throw new \yii\base\Exception(json_encode($ExistenciasDetalle->errors));
                    }
                    
                    if(!$ExistenciasDetalleDestino->save()){
                        throw new \yii\base\Exception(json_encode($ExistenciasDetalle->errors));
                    }
                    
                    $existenciaOrigen->Existencia = ExistenciasDetalle::find()->select('Sum(Existencia) AS Existencia')->where(['IdExistencia' => $existenciaOrigen->IdExistencias])->asArray()->one()['Existencia'];
                    $existenciaDestino->Existencia = ExistenciasDetalle::find()->select('Sum(Existencia) AS Existencia')->where(['IdExistencia' => $existenciaDestino->IdExistencias])->asArray()->one()['Existencia'];

                }else{
                    $existenciaDestino->Existencia -= $Destino->Cantidad;
                    $existenciaOrigen->Existencia -= $Origen->Cantidad;
                }
                
                $Origen->Existencia = null;
                $Destino->Existencia = null;
                
                if(!$existenciaDestino->save()){
                    throw new \yii\base\Exception(json_encode($existenciaDestino->errors));
                }
                
                if(!$existenciaOrigen->save()){
                    throw new \yii\base\Exception(json_encode($existenciaOrigen->errors));
                }
                
                if(!$Destino->save()){
                    throw new \yii\base\Exception(json_encode($Destino->errors));
                }
                
                if(!$Origen->save()){
                    throw new \yii\base\Exception(json_encode($Origen->errors));
                }

                $series = SerieMovimientos::find()->where(['IdInventarioMovimiento'=>$transferencia['IdInventarioMovimientoSalida']])->asArray()->all();

                foreach ($series as $serie){
                    $s = $this->GetSerie(['IdSerie' => $serie['IdSerie']]);
                    if($Destino['IdSubProceso'] != $s['IdSubProceso'] || $Destino['IdCentroTrabajo'] != $s['IdCentroTrabajo']){
                        throw new \yii\base\Exception('No se pueden deshacer los movimientos');
                        //throw new \yii\base\Exception($serie['IdSubProceso']);
                    }
                    
                    $this->setSeries([
                        'IdSerie' => $serie['IdSerie'],
                        'IdSubProceso' => $Origen['IdSubProceso'],
                        'IdCentroTrabajo' => $Origen['IdCentroTrabajo'],
                    ]);
                }
            }
            
            if(!$encabezado->save()){
                throw new \yii\base\Exception(json_encode($encabezado->errors));
            }
            
            //echo "llego al final";
            //$tran->rollback();
            $tran->commit();
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            return json_encode(['error' =>$e]);
            throw new \yii\base\Exception($e->getMessage());
        }
        return $this->actionGetInventarios(['IdInventario'=>$IdInventario]);
    }
    
    function actionAfectar($IdInventario){
        $tran = Yii::$app->db->beginTransaction();
        try {
            $encabezado = Inventarios::findOne($IdInventario);
            $encabezado->IdEstatusInventario = 3;

            $partidas = InventarioMovimientos::find()->where([
                'IdInventario' => $encabezado->IdInventario
            ])->asArray()->all();

            foreach($partidas as $partida){
                if($partida['Cantidad'] == 0){
                    throw new \yii\base\Exception(json_encode("La Partida con Id ". $partida['IdInventarioMovimiento'] . " Esta en ceros"));
                }
                
                $model = InventarioMovimientos::findOne($partida['IdInventarioMovimiento']);
                $existencia = $this->actionGetExistencia([
                    'IdSubProceso' => $model->IdSubProceso,
                    'IdCentroTrabajo' => $model->IdCentroTrabajo,
                    'IdProducto' => $model->IdProducto
                ]);
                
                $productos = json_decode($this->actionGetProducto(['IdProducto' => $model->IdProducto]),true);
                $inioninv = $this->GetUnionInv(['IdInventarioMovimiento' => $model->IdInventarioMovimiento]);
                $produccion = $this->GetProduccionesDetalle(['IdProduccionDetalle' => $inioninv['IdProduccionDetalle']]);

                //var_dump($existencia);exit;
                if ($productos['FechaMoldeo'] == 1) {
                    $ExistenciasDetalle = $this->actionGetExistenciaDetalle([
                        'IdExistencia' => $existencia['IdExistencias'],
                        'FechaMoldeo' => $partida['FechaMoldeo'],
                    ]);
                    //var_dump($ExistenciasDetalle);exit;
                    
                    if($model->Tipo == 'S'){
                        if($ExistenciasDetalle->Existencia < abs($model->Cantidad)){
                            throw new \yii\base\Exception("Producto: ".$productos['Identificacion']." Fecha Moldeo: ".$partida['FechaMoldeo']." no cuenta con la suficiente existencia");
                        }
                    }
                    
                    $ExistenciasDetalle->Existencia += $model->Cantidad;

                    if(!$ExistenciasDetalle->save()){
                        throw new \yii\base\Exception(json_encode($ExistenciasDetalle->errors));
                    }
                    
                    $existencia->Existencia = ExistenciasDetalle::find()->select('Sum(Existencia) AS Existencia')->where(['IdExistencia' => $existencia->IdExistencias])->asArray()->one()['Existencia'];
                }else{
                    if($model->Tipo == 'S'){
                        if($existencia->Existencia < abs($model->Cantidad)){
                            throw new \yii\base\Exception("Producto: ".$productos['Identificacion']." no cuenta con la suficiente existencia");
                        }
                    }
                    
                    $existencia->Existencia += $model->Cantidad;
                }
                
                $model->Existencia = $existencia->Existencia;
                
                if(!$existencia->save()){
                    throw new \yii\base\Exception(json_encode($existencia->errors));
                }
                
                if(!$model->save()){
                    throw new \yii\base\Exception(json_encode($model->errors));
                }

                if($partida['Tipo'] == 'E'){
                    $series = SerieMovimientos::find()->where(['IdInventarioMovimiento'=>$partida['IdInventarioMovimiento']])->asArray()->all();

                    foreach ($series as $serie){
                        $this->setSeries([
                            'IdSerie' => $serie['IdSerie'],
                            'IdSubProceso' => $partida['IdSubProceso'],
                            'IdCentroTrabajo' => $partida['IdCentroTrabajo'],
                        ]);
                    }
                }
            }
            
            if(!$encabezado->save()){
                throw new \yii\base\Exception(json_encode($encabezado->errors));
            }
            
            //echo "llego al final";
            //$tran->rollback();
            $tran->commit();
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            return json_encode(['error' =>$e->getMessage()]);
            throw new \yii\base\Exception($e);
        }
        return $this->actionGetInventarios(['IdInventario'=>$IdInventario]);
    }

    function SeriesMoldesPiezas($IdProducto,$IdInventarioMovimiento,$IdSubProceso){
        $cavidad = SerieCavidad::find()->where("IdProducto = ".$IdProducto."")->asArray()->all();
        $movimientos = SerieMovimientos::find()->where("IdInventarioMovimiento = ".$IdInventarioMovimiento."")->asArray()->all();
        
        foreach ($movimientos as $key => $value) {
            $serieCons = $this->GetSerie([
                'IdSerie' => $value['IdSerie'],
            ]);
            foreach ($cavidad as $key => $value) {
                $Series = new Series(); 
                $Series->load([
                    'Series' => [
                        'IdProducto' => $IdProducto,
                        'IdSubProceso' => $IdSubProceso,
                        'Serie' => $serieCons['Serie'].$value['Prefijo'].$value['ConsecutivoCavidad'],
                        'Estatus' => 'B',
                        'FechaHora' => date('Y-m-d H:i:s'),
                        'IdSeriePadre' => $serieCons['IdSerie'],
                    ]
                ]);
                //$Series->save();
                //var_dump($Series);
            }
        }
    }
    
    function actionAfectarTodo(){
        $inventarios = Inventarios::find()->where('IdEstatusInventario = 1')->orderBy('Fecha')->asArray()->all();
        
        foreach($inventarios as $inventario){
            $this->actionAfectar($inventario['IdInventario']);
        }
        
        var_dump($inventarios);
    }

    /****************************************************
     *  CONTROL DE INVENTARIOS ------ FIN ------
     ****************************************************/
    
    function GetSerie($data){
        return Series::find()->where($data)->asArray()->one();
    }

    function actionGetProducto($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        return json_encode(Productos::find()->where($data)->asArray()->one());
    }

    function GetUnionInv($data){
        return UnionInv::find()->where($data)->asArray()->one();
    }

    function GetProduccionesDetalle($data){
        return ProduccionesDetalle::find()->where($data)->asArray()->one();
    }

    function setSeriesDetalle($data){
        $serie = new SeriesDetalles();
        $serie->load(['SeriesDetalles' => $data]);
        $serie->save();
        return $serie;
    }

    function setSeries($data){
        if(isset($data['IdSerie'])){
            $model = Series::findOne($data['IdSerie']);
        }else{
            $model = Series::find()->where([
                'IdProducto' => $data['IdProducto'],
                'Serie' => $data['Serie']
            ])->one();
            
            if(is_null($model)){
                $model = new Series();
            }
        }

        $model->load(['Series' => $data]);
        
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        return $model;
    }
    
    function SetBitacora($descripcion,$tabla,$campo,$valorNuevo,$valorAnterior){
        $data = [
            'Bitacora' => [
                'Descripcion' => $descripcion,
                'Tabla' => $tabla,
                'Campo' => $campo,
                'ValorNuevo' => $valorNuevo,
                'ValorAnterior' => $valorAnterior,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'IdUsuario' => Yii::$app->user->identity->username
            ]
        ];
        
        $model = new Bitacora();
        $model->load($data);
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        //var_dump($model);
    }
    
    public function actionMarcas(){
        $this->layout = 'JSON';
        $model = new Pedidos();
        $dataProvider = $model->getMarcas(2);

        if(count($dataProvider)>0){
            return json_encode($dataProvider->allModels);
        }
        
        return json_encode([
            'total'=>0,
            'rows'=>[],
        ]);
    }
    
    public function actionTurnos(){
        return json_encode(Turnos::find()->asArray()->all());
    }
    
    public function Maquinas($data){
        if(isset($data)){
            $model = VMaquinas::find()->where($data)->asArray()->all();
            return json_encode($model);
        }
    }
    
    public function actionProductos($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        
        $model = VProductos::find()->where($data)->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCentrosTrabajo(){
        $model = CentrosTrabajo::find()->where($_REQUEST)->with('centrosTrabajoMaquinas')->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCentroTrabajoRutas(){
        $model = VCentrosRutas::find()->where($_REQUEST)->orderBy('IdCentroTrabajoOrigen')->asArray()->all();
        //var_dump($model);
        return json_encode($model);
    }
    
    public function actionRevisaExistencia(){
        if($_GET['fechaMoldeo'] == '' || $_GET['fechaMoldeo'] == 'No hay prouductos Disponibles')
            unset($_GET['fechaMoldeo']);
        $model = VExistencias::find()->where($_GET)->asArray()->all();

        return json_encode($model);
    }
    
    public function actionEmpleados($depto=''){
        if($depto != ''){
            $depto = (strpos($depto,",") ? explode(",",$depto) : $depto);
            $depto = (is_array($depto) ? implode("','",$depto) : $depto);
            $depto = "AND IDENTIFICACION IN('$depto')";
        }
        $model = VEmpleados::find()->where("IdEmpleadoEstatus <> 2 $depto"  )->orderBy('NombreCompleto')->asArray()->all();
        return json_encode($model);
    }
    
    public function actionSubProcesos(){
        $model = SubProcesos::find()->asArray()->all();
        return json_encode($model);
    }
    
    function actionGetEmbarques(){
        $where = $_REQUEST;
        if(isset($_REQUEST['Fecha'])){
            $_REQUEST['Fecha'] = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        }
        
        if(isset($_REQUEST['programacion'])){
            unset($_REQUEST['programacion']);
            $semana = date('W',  strtotime($_REQUEST['Fecha']));
            $anio = date('Y',  strtotime($_REQUEST['Fecha']));
            
            $where = "concat(Anio,REPLICATE('0', 2-LEN(Semana)),Semana) >= concat($anio,REPLICATE('0', 2-LEN($semana)),$semana)";
        }
        if(isset($_REQUEST['FechaFin'])){
            $_REQUEST['FechaFin'] = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $where = "Fecha between '".$_REQUEST['Fecha']."' AND '".$_REQUEST['FechaFin']."'";
        }
        
        switch($this->IdArea){
            case 1:
                $class = '';
                break;
            case 2:
                $model = VEmbarques::find()
                    ->where($where)
                    ->orderBy('Fecha')
                    ->asArray()
                    ->all();
                break;
            case 3:
                $model = VEmbarquesBronce::find()
                    ->where($where)
                    ->orderBy('Fecha')
                    ->asArray()
                    ->all();
                break;
        }
        //var_dump($model);exit;
        
        return json_encode($model);
    }
    
    public function CapturaProduccion($IdSubProceso){
        $this->layout = 'produccion';
        
        return $this->render('CapturaProduccion', [
            'IdProceso'=> $this->IdProceso,
            'IdSubProceso'=> $IdSubProceso,
            'IdArea'=> $this->IdArea
        ]);
    }
    
    function actionGetProducciones($where = '',$limit = '',$offset = ''){
        $where = json_decode($where,true);
        $model = Producciones::find()->where($where)->with('produccionesDetalles','idEmpleado','idSubProceso','idMaquina','idCentroTrabajo','idTurno','temperaturas','materialesVaciados')->limit($limit)->offset($offset)->asArray()->all();
        return json_encode($model);
    }
    
    function actionFindProduccion($where){
        $where = json_decode($where,true);
        $model = Producciones::find()->where($where)->asArray()->one();
        
        if(count($model) > 0){
            $where = "IdArea = " . $model['IdArea'] . " AND IdSubProceso = " . $model['IdSubProceso'] . " AND IdProduccion <= " . $model['IdProduccion'];
            $model = Producciones::find()->select('count(IdProduccion) AS Total')->where($where)->asArray()->one();
            return json_encode($model['Total']);
        }
        
        return json_encode(false);
    }
    
    function actionCountProduccion(){
        $where = $_REQUEST;
        $model = Producciones::find()->select('count(IdProduccion) AS Total')->where($where)->asArray()->one();
        return $model['Total']*1;
    }
    
    function actionMaterial(){
        $where = $_REQUEST;
        $model = Materiales::find()->where($where)->asArray()->all();
        return json_encode($model);
    }
    
    function actionAleacionTipo(){
        $model = AleacionesTipo::find()->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDefectos($IdSubProceso,$IdArea){
        $model = VDefectos::find()->where([
            'IdSubProceso' => $IdSubProceso,
            'IdArea'=>$IdArea,
        ])->asArray()->all();
        
        return json_encode($model);
    }
    
    function saveDetalle($data){
        if(isset($data['IdProduccionDetalle'])){
            $model = ProduccionesDetalle::findOne($data['IdProduccionDetalle']);
        }else{
            $model = new ProduccionesDetalle();
        }
        
        $model->load(['ProduccionesDetalle' => $data]);
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        
        return $this->getProduccionDetalle('IdProduccionDetalle = '.$model->IdProduccionDetalle);
    }
    
    function saveProduccion($data){
        if(isset($data['IdProduccion'])){
            $model = Producciones::findOne($data['IdProduccion']);
        }else{
            $model = new Producciones();
        }
        
        $model->load(['Producciones' => $data]);
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        
        $model = Producciones::find()->where('IdProduccion = '.$model->IdProduccion)->with('produccionesDetalles','idEmpleado','idSubProceso','idMaquina','idCentroTrabajo','idTurno')->asArray()->one();
    }
    
    function actionDeleteDetalle(){
        return $model = ProduccionesDetalle::findOne($_REQUEST['IdProduccionDetalle'])->delete();
    }
    
    function actionDeleteConsumo(){
        return $model = MaterialesVaciado::findOne($_REQUEST['IdMaterialVaciado'])->delete();
    }
    
    function actionSaveConsumoDetalle(){
        
        $model = ProduccionesDetalleMaterialVaciado::find()->where("IdProduccionDetalle = " . $_REQUEST['IdProduccionDetalle'])->one();
        if(is_null($model)){
            $model = new ProduccionesDetalleMaterialVaciado();
        }
        $model->load(['ProduccionesDetalleMaterialVaciado' => $_REQUEST]);
        $model->save();
        return json_encode(
            $this->getProduccionDetalle("IdProduccionDetalle = " . $_REQUEST['IdProduccionDetalle'])
        );
    }
    
    function actionSaveConsumo(){
        if(!isset($_REQUEST['IdMaterialVaciado'])){
            $model = new MaterialesVaciado();
        }else{
            $model = MaterialesVaciado::find()->where("IdMaterialVaciado = ".$_REQUEST['IdMaterialVaciado'])->with('idMaterial')->one();
        }
        
        $model->load([
            'MaterialesVaciado'=>$_REQUEST
        ]);
        
        if(!$model->save()){
            json_encode([]);
        }
        
        return json_encode(
            MaterialesVaciado::find()->where("IdMaterialVaciado = ".$model->IdMaterialVaciado)->with('idMaterial')->asArray()->one()
        );
    }
    
    function actionSaveRuta($data){
        $data = json_decode($data,true);
        var_dump($data);
        if(isset($data['IdCentroTrabajoRutas'])){
            $model = CentrosTrabajoRutas::findOne($data['IdCentroTrabajoRutas']);
        }else{
            $model = new CentrosTrabajoRutas();
        }
        
        $model->load(['CentrosTrabajoRutas' => $data]);
        
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
    }
    
    function actionSaveRechazo(){
        if(!isset($_REQUEST['IdProduccionDefecto'])){
            $model = new ProduccionesDefecto();
        }else{
            $model = ProduccionesDefecto::findOne($_REQUEST['IdProduccionDefecto']);
        }
        
        $_REQUEST['Rechazadas'] *= 1;
        $_REQUEST['Hechas'] = $_REQUEST['Rechazadas'];
        
        $model->load([
            'ProduccionesDefecto'=>$_REQUEST
        ]);
        
        if(!$model->save()){
            var_dump($model);
            return json_encode([]);
        }
        
        return json_encode(
            $this->saveDetalle($_REQUEST)
        );
    }
    
    function actionDeleteRetrabajo(){
        $tran = Yii::$app->db->beginTransaction();
        
        try{
            $detalle = ProduccionesDetalle::findOne($_REQUEST['IdProduccionDetalle']);
            
            if(count(ProduccionesDefecto::find()->where("IdProduccionDetalle = ".$detalle->IdProduccionDetalle)->asArray()->all())>0){
                if(!ProduccionesDefecto::deleteAll("IdProduccionDetalle = ".$detalle->IdProduccionDetalle)){
                    throw new \yii\base\Exception(json_encode("No se pudo eliminar el registro"));
                }
            }
            
            if(!$detalle->delete()){
                throw new \yii\base\Exception(json_encode("No se pudo eliminar el registro"));
            }

            //$tran->rollback();
            $tran->commit();
            
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            return json_encode(['error' => $e->getMessage()]);
            throw new \yii\base\Exception($e);
        }
    }
    
    function getProduccionDetalle($data){
        return ProduccionesDetalle::find()->where($data)->with('idProductos','seriesDetalles','soldadura','produccionesDefectos')->asArray()->one();
    }
}