<?php

namespace frontend\controllers;

use Yii;
use frontend\models\inventario\VExistencias;
use frontend\models\inventario\Inventarios;
use frontend\models\inventario\InventarioMovimientos;
use frontend\models\inventario\Existencias;
use frontend\models\inventario\SerieMovimientos;
use frontend\models\inventario\ExistenciasDetalle;
use frontend\models\inventario\UnionInv;
use common\models\datos\Bitacora;
use common\models\datos\SerieCavidad;
use frontend\models\produccion\Series;
use frontend\models\produccion\ProduccionesDetalle;
use common\models\dux\Productos;
use common\models\catalogos\CentrosTrabajo;

class InventarioController extends \yii\web\Controller
{
    public function CapturaInventarios($transaccion = true){
        $this->layout = 'produccion';
        
        return $this->render('CapturaInventarios', [
            'transaccion'=> $transaccion,
        ]);
    }
    
    public function actionSaveDetalle(){
        
    }
    
    public function actionSaveProduccion(){
        
    }
    
    public function actionTransferencias(){
        return $this->CapturaInventarios(false);
    }
    
    public function actionTransacciones(){
        return $this->CapturaInventarios();
    }

    /****************************************************
     *  CONTROL DE INVENTARIOS ------ INICIO ------
     ****************************************************/
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
        
        return $unioninv;
    }
    
    function actionInventario(){
        $model = VExistencias::find()->where($_REQUEST)->orderBy('IdSubProceso ASC, Descripcion ASC, Identificacion ASC')->asArray()->all();
        return json_encode($model);
    }
    
    function actionSaveInventario($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }

        $model = new Inventarios();
        $data['IdEstatusInventario'] = 1;
        $model->load(['Inventarios' => $data]);
        if(!$model->save()){
            throw new \yii\base\Exception(json_encode($model->errors));
        }
        
        return json_encode($model->attributes);
    }
    
    function actionSaveMovimiento($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }

        $model = new InventarioMovimientos();
        $model->load(['InventarioMovimientos' => $data]);
        $model->save();
        return $model;
    }
    
    function actionGetExistencia($data){
        $model = Existencias::find()->where($data)->one();
        if(is_null($model)){
            $model = new Existencias();
            
            $model->load(['Existencias' => $data]);
            $model->Existencia = 0;
            $model->save();

            $model = Existencias::find()->where($data)->one();
        }
        return $model;
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
            $model = InventarioMovimientos::findOne($model->IdInventarioMovimiento);
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
        $model = new ExistenciasDetalle();
        
        $model = ExistenciasDetalle::find()->where("FechaMoldeo = '".$data['FechaMoldeo']."'")->one();
        if(is_null($model)){
            $model = new ExistenciasDetalle();
            
            $model->load(['ExistenciasDetalle' => $data]);
            $model->Existencia = 0;
            $model->save();
            
            $model = ExistenciasDetalle::find()->where("FechaMoldeo = '".$data['FechaMoldeo']."'")->one();
        }
        return $model;
    }
    
    function actionGetProducto2($data = ''){
        if($data == ''){
            $data = $_REQUEST;
        }
        return json_encode(Productos::find()->where($data)->asArray()->one());
    }
    
    function actionAfectar($IdInventario){
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

            $productos = json_decode($this->actionGetProducto2(['IdProducto' => $model->IdProducto]),true);
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

    function actionDesafectar(){
        
    }
    
    /****************************************************
     *  CONTROL DE INVENTARIOS ------ FIN ------
     ****************************************************/
    
    public function actionBronces()
    {
        return $this->render('index',[
            'IdArea' => 3
        ]);
    }
    
    public function actionAceros(){
        return $this->render('index',[
            'IdArea' => 2
        ]);
    }
    
    function actionCentros(){
        $model = CentrosTrabajo::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    function GetSerie($data){
        return Series::find()->where($data)->asArray()->one();
    }

    function GetProducto($data){
        return Productos::find()->where($data)->asArray()->one();
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
        $model->save();
        //var_dump($model);
    }
    
    function actionPrueba2($data,$transaction = ''){
        if($transaction != ''){
            $tran = &$transaction;
        }else{
            $tran = Yii::$app->db->beginTransaction();
        }
        
        try {
            if(!$model->update()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }

            if($transaction != ''){
                $tran->commit();
            }
        }catch(\yii\base\Exception $e) {
            $tran->rollback();
            throw new \yii\base\Exception($e);
        }
    }
    
    function actionPruebaTransaccion(){
        $tran = Yii::$app->db->beginTransaction();
        try {
            $model = Existencias::findOne(2);
            $model->IdSubProceso = null;
            $model->Cantidad = 20;
            
            if(!$model->update()){
                throw new \yii\base\Exception(json_encode($model->errors));
            }

            $tran->commit();
            echo "Hizo commit";
        }catch(\yii\base\Exception $e) {
            \Yii::$app->mail->compose()
            ->setFrom('idesantiago@fimex.com.mx')
            ->setTo('idesantiago@fimex.com.mx')
            ->setSubject('Error en el sistema')
            ->setTextBody($e)
            ->send();
            $tran->rollback();
            throw new \yii\base\Exception($e);
        }
    }
}