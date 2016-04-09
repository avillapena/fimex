<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller; 
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\Temperaturas;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\Producciones;
use common\models\catalogos\Areas;
use frontend\models\programacion\VPedidos;

use frontend\models\certificados\VColadasCerty;
use frontend\models\certificados\Empleados;
use frontend\models\certificados\VNormas;
use frontend\models\certificados\CertificadosAQ;
use frontend\models\certificados\Certificados;
use frontend\models\certificados\VCertColadasSeries;
use frontend\models\certificados\TiposCertificados;
use frontend\models\certificados\VBrokerMuestras;
use frontend\models\certificados\AnalisisQuimicos;
use frontend\models\certificados\CertificadosDetalle;
use frontend\models\certificados\CertificadosSeries;
use frontend\models\certificados\Responsables;
use frontend\models\certificados\VNumClienteCerty;
use frontend\models\certificados\CertificadosExtendido;

use common\models\dux\Productos;
use common\models\dux\Aleaciones;
use frontend\models\certificados\CertificadoTT;
use frontend\models\certificados\CertificadoTTDetalle;
use frontend\models\certificados\CertTTColada;
use frontend\models\certificados\CertTTSerie;
use frontend\models\tt\TratamientosTermicos;


class CertificadosController extends Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
    
    /************************************************************
     *                    RUTAS PARA LOS MENUS                  *
     ************************************************************/
     
    public function actionCertificadott($area)
    {
        $this->layout = 'captura';
        
        return $this->render('Certificadott', [
            'title' => 'Certificado de Calidad',
            'IdArea'=> $area,
        ]);
    }                                             
    
    public function actionCertificadoGeneral(){
        return $this->GeneraCertificados(2,1);
    }

    public function actionPruebasNoDestructivas(){
        return $this->GeneraCertificados(2,2);
    }
    
    public function GeneraCertificados($IdArea, $TipoCertificado){
        $this->layout = 'captura';
        /*return $this->render('Certificados', [
            'title' => 'Certificado de Calidad',
            'IdArea'=> $IdArea,
        ]);*/

        switch ($TipoCertificado){
            case 1: $url = 'Certificados'; $title = 'Certificado de Calidad'; break;
            case 2: $url = 'PruebasNoDestructivas'; $title = 'Certificado - Pruebas No Destructivas'; break;
        }

        return $this->render($url, [
            'title' => $title,
            'IdArea' => $IdArea,
        ]);
    }                                               
    
    /************************************************************
     *                    OBTENCION DE DATOS
     ************************************************************/

    function actionCountCertificados(){
        $model = Certificados::find()->select('count(IdCertificado) AS Total')->where($_REQUEST)->asArray()->one();
        return $model['Total']*1;
    }

    public function actionCertificados($where='',$limit = '',$offset = ''){
        $model = Certificados::find()->where($where)->with('idTipoCertificado')->limit($limit)->offset($offset)->asArray()->all();
        return json_encode($model);
    }

    public function actionOc(){
        $almacen =   $_REQUEST["IdArea"] ;
        $model = VPedidos::find()
        ->select("OrdenCompra")
         ->where("IdPresentacion  =  '$almacen' and cast( fecha as date )  > '20141101' ")
        ->distinct()
        ->asArray()
        ->all();

        return json_encode($model);
    }
    
    public function actionProducto(){
       
        $oc = $_REQUEST["oc"];
        $model = VPedidos::find()
        // ->where("")
        ->select("Producto")
        ->distinct()
        ->where("OrdenCompra = '$oc'")
        ->asArray()
        ->all();

        return json_encode($model);
    }

    public function actionProductodesc(){
       
       $producto = $_REQUEST["producto"];
        $model = Productos::find()
        ->where("Identificacion = '$producto'")
        ->asArray()
        ->all();

        return json_encode($model);
    }

    public function actionProductoaleacion(){
       
        $material = $_REQUEST["material"];
        $model = Aleaciones::find()
        ->where("IdAleacion = '$material'")
        ->asArray()
        ->all();

        return json_encode($model);
    }

    public function actionColada(){
       
        $producto = $_REQUEST["producto"];

        $model = VCertColadasSeries::find()
         ->select('Colada')
         ->distinct()
        ->where("CodProducto = '$producto'")
        ->asArray()
        ->all();

        return json_encode($model);
    }

    public function actionSerie(){
       
        $colada = $_REQUEST["colada"];
        $producto = $_REQUEST["producto"];
        $coladas = '';
        foreach ( $colada as $c ) {
            $coladas .=  $c['Colada']. ',';
        }

        $coladas = rtrim ($coladas,",");
      
        $model = VCertColadasSeries::find()
        ->where("Colada in ( $coladas ) and CodProducto = '$producto'")
        ->asArray()
        ->all();

        return json_encode($model);
    }

    public function actionPedidosCliente(){
        $model = VPedidos::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }
    
    public function actionColadas(){
        $model = VColadasCerty::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    public function actionSeries(){
        $model = VCertColadasSeries::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    public function actionTiposCerty(){
        $model = TiposCertificados::find()->where('TipoCert IN (1,3)')->asArray()->all();
        return json_encode($model);
    }

    public function actionEmpleados(){
        $model = Empleados::find()->where($_REQUEST)->asArray()->all();
        return json_encode($model);
    }

    public function actionNormas(){
        $model = VNormas::find()->asArray()->all();
        return json_encode($model);
    }

    public function actionNumCertificado(){
        $sub = CertificadosAQ::find()
            ->select('IdCertificadoAQ')
            ->max('IdCertificadoAQ');
        return str_pad($sub+1, 4, "0", STR_PAD_LEFT); 
    }
    
    public function actionNumCliente(){

        $command = \Yii::$app->db;
        $result = $command->createCommand("SELECT
            Max(dbo.Certificados.IdCertificado) AS Certy,
            SUBSTRING(dbo.Marcas.Descripcion, 0,4) AS Cliente
            FROM Certificados
            INNER JOIN v_Pedidos ON Certificados.OrdenCompra = v_Pedidos.OrdenCompra
            INNER JOIN dbo.Marcas ON dbo.v_Pedidos.IdMarca = dbo.Marcas.IdMarca
            WHERE dbo.v_Pedidos.OrdenCompra = '".$_REQUEST['OrdenCompra']."'
            GROUP BY
            dbo.Certificados.IdCertificado,
            dbo.Marcas.Descripcion
        ")->queryAll();
        
        $cons = str_pad($result[0]['Certy']+1, 4, "0", STR_PAD_LEFT); 
        $cliente = $result[0]['Cliente'];
        //var_dump($result[0]);
        return $cliente."-".$cons; 
    }
    
    /************************************************************
    *                    FUNCIONES EN GENERAL 
    *************************************************************/

    public function actionSaveCertificados(){
        //$data['Series'] = json_decode($_REQUEST['Series'],true);
        $data['DatosCertificado'] = json_decode($_REQUEST['DatosCertificado'],true);

        //$tipoFuncion = isset($data['DatosCertificado']['Realizo']) == true ? 1 : 3;
        //$empleado = isset($data['DatosCertificado']['Realizo']) == true ? explode("-",$data['DatosCertificado']['Realizo']) : explode("-", $data['DatosCertificado']['Inspecciono']);

        //var_dump($empleado);
        //exit();
        $model = new Certificados();
        $model->load([
            'Certificados'=>[
                'IdTipoCertificado' => $data['DatosCertificado']['IdTipoCertificado'],
                'NoCertificado' => $data['DatosCertificado']['NoCerty'],
                'IdEquipo' => Yii::$app->user->identity->username,
                'Fecha' => $data['DatosCertificado']['Fecha'],
                'OrdenCompra' => $data['DatosCertificado']['OrdenCompra'],
                'Observaciones' => $data['DatosCertificado']['Observaciones'],
                'IdNorma' => $data['DatosCertificado']['Norma'],
                'Factura' => $data['DatosCertificado']['Factura'],
            ] 
        ]);
        if(!$model->save()){
            return false;
        }

        return json_encode(Certificados::find()->where(['IdCertificado'=> $model->IdCertificado])->asArray()->one());
    }
    
    public function actionDeleteCertificado(){
        $model = Certificados::findOne($_REQUEST['IdCertificado'])->delete();
    }
    
    public function actionSaveCertificadosExtras(){
        $data['Series'] = json_decode($_REQUEST['Series'],true);
        $data['DatosCertificado'] = json_decode($_REQUEST['DatosCertificado'],true);

        $tipoFuncion = isset($data['DatosCertificado']['Realizo']) == true ? 1 : 3;
        $empleado = isset($data['DatosCertificado']['Realizo']) == true ? explode("-",$data['DatosCertificado']['Realizo']) : explode("-", $data['DatosCertificado']['Inspecciono']);

        //var_dump($empleado);
        //exit();
        $model = new Certificados();
        $model->load([
            'Certificados'=>[
                'IdTipoCertificado' => $data['DatosCertificado']['IdTipoCertificado'],
                'NoCertificado' => $data['DatosCertificado']['NoCerty'],
                'IdEquipo' => Yii::$app->user->identity->username,
                'Fecha' => $data['DatosCertificado']['Fecha'],
                'OrdenCompra' => $data['DatosCertificado']['OrdenCompra'],
                'IdNorma' => $data['DatosCertificado']['Norma'],
                'Factura' => $data['DatosCertificado']['Factura'],
            ] 
        ]);
        $model->save();
        //var_dump($model);

        if($data['DatosCertificado']['IdTipoCertificado'] != 10){
            $certyExten = new CertificadosExtendido();
            $certyExten->load([
                'CertificadosExtendido'=>[
                    'IdCertificado' => $model['IdCertificado'],
                    'Procedimiento' => $data['DatosCertificado']['Procedimiento'],
                ]
            ]);
            $certyExten->save();
        }

        $certyDetalles = new CertificadosDetalle();
        $certyDetalles->load([
            'CertificadosDetalle'=>[
                'IdCertificado' => $model['IdCertificado'],
                'IdProducto' => $data['DatosCertificado']['IdProducto'],
                'Cantidad' => $data['DatosCertificado']['Cantidad'],
                //'FechaMoldeo' => $_REQUEST
            ]
        ]);
        $certyDetalles->save();

        foreach ($data['Series'] as $key) {
            $certySeries = new CertificadosSeries();
            $certySeries->load([
                'CertificadosSeries'=>[
                    'IdSerie' => $key,
                    'IdCertificadoDetalle' => $certyDetalles['IdCertificadoDetalle'],
                    'Fecha' => $data['DatosCertificado']['Fecha'],
                ]
            ]);
            $certySeries->save();
        }

        $resp = new Responsables();
        $resp->load([
            'Responsables'=>[
                'IdCertificado' => $model['IdCertificado'],
                'IdEmpleado' => $empleado[0],
                'IdTipoFuncion' => $tipoFuncion,
            ]
        ]);
        $resp->save();
        //var_dump($resp);
 
        if($data['DatosCertificado']['IdTipoCertificado'] == 10){
            $certyAQ = new CertificadosAQ();
            $certyAQ->load([
                'CertificadosAQ'=>[
                    'IdCertificado' => $model['IdCertificado'],
                    'IdLancePm' => $data['DatosCertificado']['IdLance'],
                ]
            ]);
            $certyAQ->save();
            var_dump($certyAQ);
        }

        /*if($data['DatosCertificado']['IdTipoCertificado'] == 10){
            $broker =  VBrokerMuestras::find()->where("
                Colada = '".$data['DatosCertificado']['Colada']."'
                AND muestra LIKE '1OLLA FINAL%'
                AND calidad = '".$data['DatosCertificado']['Aleacion']."'
                AND DATEPART(year, Fecha) = ".$data['DatosCertificado']['AnioAnalisis']."
                AND elemento IN ('C','Si','Mn','P','S','Cr','Ni','Mo','Al','Cu','Co','Ti','Nb','V','W','N','Fe','EC')
            ")->asArray()->all();
            //var_dump($broker); 
        }
        
        foreach ($broker as $key => $value) {
            //echo "f - ".$value['elemento'];
            $datosAQ = new AnalisisQuimicos();
            $datosAQ->load([
                'AnalisisQuimicos'=>[
                    'IdCertificadoAQ'=> $certyAQ['IdCertificadoAQ'],
                    'Elemento' => $value['elemento'],
                    'Valor' => (float)$value['valor'],
                ]
            ]);
            $datosAQ->save();
        }*/

        //'IdEquipo' => Yii::$app->user->identity->username;
    }



    /************************************************************
     *                    FUNCIONES EN GENERAL TT
     ************************************************************/

    public function actionSavecertificadottdetalle(){
           var_dump($_REQUEST);
            $p = $_REQUEST['producto'];
            $producto = Productos::find()->where("identificacion = '$p'" )->One();
            // var_dump($producto);
            $IdProducto = $producto->IdProducto;
            $_REQUEST['IdProducto']= $IdProducto;

            $data = $_REQUEST ;
        
            $coladas = json_decode( "[".$data['colada']."]",true ) ;
            $series =  json_decode( "[".$data['serie']."]",true ) ;


            unset($data['colada']);
            unset($data['serie']);

              // var_dump($series);exit;



           $model = new CertificadoTTDetalle();
       
        
        if(!isset($data['IdCertificadoTTDetalle'])){
            $model->load([
                "CertificadoTTDetalle"=>$data
            ]);
             $model->save();
            // var_dump($data);
             var_dump($model);
        }else{
            $model = CertificadoTTDetalle::findOne($data['IdCertificadoTTDetalle']);
            $model->load([
                "CertificadoTTDetalle"=>$data
            ]);
            $model->update();
        }

            foreach ($coladas as $c ) {
                    $colada = new CertTTColada();
                    $c['IdCertificadoTTDetalle'] = $model->IdCertificadoTTDetalle;
                     if(!isset($c['IdCertTTColada'])){
                            $colada->load( ["CertTTColada"=> $c] );
                            $colada->save();
                     }else{
                            $colada = CertTTColada::findOne( $c['IdCertTTColada'] );
                            $colada->load( ["CertTTColada"=> $c] );
                            $colada->update();

                     }

                  var_dump($c);
                  var_dump($colada);
            }

            foreach ($series as $s ) {
                    $serie = new CertTTSerie();
                    $s['IdCertificadoTTDetalle'] = $model->IdCertificadoTTDetalle;
                     if(!isset($s['IdCertTTSerie'])){
                            $serie->load( ["CertTTSerie"=> $s] );
                            $serie->save();
                     }else{
                            $serie = CertTTSerie::findOne( $s['IdCertTTSerie'] );
                            $serie->load( ["CertTTSerie"=> $s] );
                            $serie->update();

                     }

                var_dump($s);
                var_dump($serie);
            }

            if ( count ( $series ) > 0){

                $model->Cantidad = count ( $series );
                $model->update();
            } 

    }

    public function actionDeletecertificadottdetalle(){
         $IdCertificadoTTDetalle = $_REQUEST['IdCertificadoTTDetalle'];


         $serie= CertTTSerie::deleteAll("IdCertificadoTTDetalle = ".$IdCertificadoTTDetalle);
         $colada = CertTTColada::deleteAll("IdCertificadoTTDetalle = ".$IdCertificadoTTDetalle);
         $detalle = CertificadoTTDetalle::deleteAll("IdCertificadoTTDetalle = ".$IdCertificadoTTDetalle);

         var_dump($detalle);
         var_dump($serie);
         var_dump($colada);



    }


public function actionLoaddetallecertificadott(){
        $id = $_REQUEST["id"];


       $model  =  CertificadoTTDetalle::find()
                            ->where("IdCertificadoTT = $id" )
                            ->with('certTTColadas')
                            ->with('certTTSeries')
                            ->with('idProducto')
                            ->asArray()
                            ->all();
        return json_encode($model);               

    }

    /* public function actionSavecertificadott(){
        $data = $_REQUEST;
        $coladas = $data['colada'];
        $series = $data['serie'];
        foreach ($coladas as $c) {
            var_dump($c);
        }
        foreach ($series as $s){
            var_dump($s);
        }*/


    

 public function actionSavecertificadott(){
            $data = $_REQUEST ;
            var_dump($_REQUEST);
        $model = new CertificadoTT();

        $model->load( ['CertificadoTT' => $_REQUEST]);
        $model->save();
         var_dump($model);

 }

    public function actionTratamientostermicos(){
       $model =  TratamientosTermicos::find()
       ->select( "IdTratamientoTermico,NoTT" ) 
       ->asArray()
       ->all();

       return json_encode($model);
    }

     public function actionTratamientotermico(){
        $IdTratamientoTermico = $_REQUEST["IdtratamientoTermico"] ;
        $tt =  TratamientosTermicos::find()
        ->where( "IdTratamientoTermico =  $IdTratamientoTermico")
        ->one();

        $model = Producciones::find()
                            ->where(" IdProduccion = ".$tt->IdProduccion)
                            ->with('idTratamientosTermicos')
                            ->asArray()
                            ->one(); 
     // var_dump($model);
       return json_encode($model);
    }

    public function actionBusquedacertt(){
        $connection = Yii::$app->db;
        $sql =  "
            SELECT
            dbo.Producciones.Fecha,
            dbo.TratamientosTermicos.NoTT,
            dbo.Turnos.Descripcion as turno,
            dbo.Maquinas.Identificador,
            dbo.TratamientosTermicos.ArchivoGrafica,
            dbo.ProduccionesDetalle.Hechas,
            dbo.ProduccionesDetalle.FechaMoldeo,
            dbo.Series.Serie,
            dbo.Productos.Identificacion as producto,
            dbo.Producciones.IdProduccion
            FROM
            dbo.TratamientosTermicos
            INNER JOIN dbo.Producciones ON dbo.TratamientosTermicos.IdProduccion = dbo.Producciones.IdProduccion
            INNER JOIN dbo.Turnos ON dbo.Producciones.IdTurno = dbo.Turnos.IdTurno
            INNER JOIN dbo.Maquinas ON dbo.Producciones.IdMaquina = dbo.Maquinas.IdMaquina
            LEFT JOIN dbo.ProduccionesDetalle ON dbo.ProduccionesDetalle.IdProduccion = dbo.Producciones.IdProduccion
            LEFT JOIN dbo.SeriesDetalles ON dbo.SeriesDetalles.IdProduccionDetalle = dbo.ProduccionesDetalle.IdProduccionDetalle
            LEFT JOIN dbo.Series ON dbo.SeriesDetalles.IdSerie = dbo.Series.IdSerie
            LEFT JOIN dbo.Productos ON dbo.ProduccionesDetalle.IdProductos = dbo.Productos.IdProducto
            left JOIN dbo.CentrosTrabajo ON dbo.Producciones.IdCentroTrabajo = dbo.CentrosTrabajo.IdCentroTrabajo
        ";

        $command = $connection->createCommand( $sql );
        $data = $command->queryAll();

        return  json_encode($data);
     }

    

      public function actionCertificadostt(){
        $model = CertificadoTT::find()
                    ->select("IdCertificadoTT")
                    ->asArray()
                    ->all();
         return json_encode($model);
     }

     public function actionCertificadottdata(){

         $IdCertificadoTT =  $_REQUEST['IdCertificadoTT'];

         $model = CertificadoTT::find()
                            ->where(" IdCertificadoTT = ".$IdCertificadoTT)
                            ->asArray()
                            ->one(); 

         return json_encode($model);
     }


}