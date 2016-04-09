<?php

namespace frontend\controllers;

use yii;
use frontend\models\produccion\TiemposMuerto;
use frontend\models\produccion\ProduccionesDetalle;
use frontend\models\produccion\ProduccionesDefecto;
use frontend\models\produccion\Producciones;
use frontend\models\produccion\MaterialesVaciado;
use frontend\models\vistas\VCamisasAcero;
use common\models\vistas\VCamisas;
use common\models\vistas\VTiemposMuertos;
use common\models\catalogos\Materiales;
use common\models\catalogos\Maquinas;
use common\models\vistas\VMaterialArania;
use common\models\datos\Cajas;
use common\models\catalogos\Areas;
use frontend\models\programacion\VProgramaciones;
use frontend\models\vistas\VCamisasDia;
use frontend\models\vistas\VCamisasDiaAcero;
use frontend\models\vistas\VFiltros;
use frontend\models\vistas\VFiltrosDia;
use frontend\models\vistas\VFiltrosDiaAcero;
use frontend\models\vistas\VFiltrosAcero;
use frontend\models\vistas\VMetalDia;
use common\models\catalogos\Turnos;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ReportesController extends Controller
{
    protected $areas;
    
    public function init(){
        $this->areas = new Areas();
    }
    
    public function LoadSemana($semana1= ''){
        if($semana1 == ''){
            $mes = date('m');
            $semana1 = $mes == 12 && date('W') == 1 ? [date('Y')+1,date('W'),date('Y-m-d')] : [date('Y'),date('W'),date('Y-m-d')];
        }else{
            $semana1 = date('Y-m-d',strtotime($semana1));
            $mes = date('m',strtotime($semana1));

            $semana1 = $mes == 12 && date('W',strtotime($semana1)) == 1 ? [date('Y',strtotime($semana1))+1,1* date('W',strtotime($semana1)),$semana1] : [date('Y',strtotime($semana1)),1 * date('W',strtotime($semana1)),$semana1];
        }
        
        $semanas['semana1'] = ['year'=>$semana1[0],'week'=>$semana1[1],'val'=>$semana1[2]];
        $semanas['semana2'] = $this->checarSemana($semanas['semana1']);
        $semanas['semana3'] = $this->checarSemana($semanas['semana2']);
        $semanas['semana4'] = $this->checarSemana($semanas['semana3']);
        $semanas['semana5'] = $this->checarSemana($semanas['semana4']);
        $semanas['semana6'] = $this->checarSemana($semanas['semana5']);
         
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

    public function LoadDias($semana = '')
    {
        $year = $semana == '' ? date('Y') : date('Y',strtotime($semana));
        $week = $semana == '' ? date('W') : date('W',strtotime($semana));
        $fecha = strtotime($year."W".$week."1");
        $fecha = date('Y-m-d',$fecha);
        
        for($x=1;$x<7;$x++){

            $dias['dia'.$x] = date('Y-m-d',strtotime($fecha));
            $fecha = date('Y-m-d',strtotime("+1 Day",strtotime($fecha)));
        }

        return $dias;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionVaciadoAcero(){
        return $this->render('VaciadoAceros');
    }
    
    public function actionDataVaciado(){
        
        if(!isset($_REQUEST['Fecha'])){
            return "";
        }
        
        $Fecha = date('Y-m-d',strtotime($_REQUEST['Fecha']));
        
        $model = Producciones::find()->where([
            'IdArea' => 2,
            'IdSubProceso' => 10,
            'Fecha' => $Fecha
        ])
        ->with('lances')
        ->with('produccionesDetalles')
        ->with('temperaturas')
        ->asArray()
        ->all();
        
        $lances = [];
        $productos = [];
        $material = [];
        
        foreach($model as $mod){
            $TempHorno = '';
            $x = 1;
            foreach ($mod['temperaturas'] as $temperatura){
                if($mod['IdMaquina'] == $temperatura['IdMaquina']){
                    $TempHorno = $temperatura['Temperatura'] * 1;
                }else{
                    ${"Olla$x"} = $temperatura['Temperatura'] * 1;
                    $x++;
                }
                //var_dump($temperatura);
            }
            
            $lances[] = [
                'Colada' => $mod['lances']['Colada'],
                'Lance' => $mod['lances']['Lance'] * 1,
                'HornoConsecutivo' => $mod['lances']['HornoConsecutivo'],
                'Probetas' => $mod['lances']['Probetas'],
                'KellBlock' => $mod['lances']['Kellblocks'],
                'Lingotes' => $mod['lances']['Lingotes'],
                'TempHorno' => $TempHorno,
                'TempOlla1' => $Olla1,
                'TempOlla2' => $Olla2,
                'TempOlla3' => isset($Olla3) ? $Olla3 : '',
                'Peso' => 0
            ];
            
            foreach($mod['produccionesDetalles'] as $producto){
                $lances[count($lances)-1]['Peso'] += ($producto['Hechas'] + $producto['Rechazadas']) * $producto['idProductos']['PesoArania'];
                
                $productos[$producto['IdProductos']]['Producto'] = $producto['idProductos']['Identificacion'];
                $productos[$producto['IdProductos']]['PiezasMolde'] = $producto['idProductos']['PiezasMolde'];
                $productos[$producto['IdProductos']]['Moldes'] = (isset($productos[$producto['IdProductos']]['Moldes']) ? $productos[$producto['IdProductos']]['Moldes'] : 0 ) + (($producto['Hechas'] + $producto['Rechazadas']) * 1);
                $productos[$producto['IdProductos']]['Piezas'] = $producto['idProductos']['PiezasMolde'] * $productos[$producto['IdProductos']]['Moldes'];
                
                $productos[$producto['IdProductos']]['Lance'. $mod['lances']['Lance']]['MoldesOk'] = $producto['Hechas'] * 1;
                $productos[$producto['IdProductos']]['Lance'. $mod['lances']['Lance']]['Moldesrec'] = $producto['Rechazadas'] * 1;
                $productos[$producto['IdProductos']]['Lance'. $mod['lances']['Lance']]['PiezasOk'] = $producto['Hechas']  * $producto['idProductos']['PiezasMolde'];
                $productos[$producto['IdProductos']]['Lance'. $mod['lances']['Lance']]['Piezasrec'] = $producto['Rechazadas'] * $producto['idProductos']['PiezasMolde'];

            }
            //$productos[];
        }
        return json_encode([
            'lances' => $lances,
            'productos' => $productos
        ]);
    }
    
    public function actionMoldeo()
    {
        return $this->render('index',[
            'vista' => 'moldeo',
            'IdSubProceso' => 6
        ]);
    }
    
    public function actionCamisas(){
        return $this->render('index',[
            'vista' => 'Camisas',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionCamisasBronce(){
        return $this->render('index',[
            'vista' => 'Camisas',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    
    public function actionCamisasProducto(){
        return $this->render('index',[
            'vista' => 'CamisasProducto',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionCamisasDia(){
        return $this->render('index',[
            'vista' => 'CamisasDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionCamisasDiaBronce(){
        return $this->render('index',[
            'vista' => 'CamisasDia',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    
    public function actionFiltrosAcerosDia(){
        return $this->render('index',[
            'vista' => 'FiltrosDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionFiltrosBronces(){
        return $this->render('index',[
            'vista' => 'Filtros',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    
    public function actionFiltrosAceros(){
        return $this->render('index',[
            'vista' => 'Filtros',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionMetalDia(){
        return $this->render('index',[
            'vista' => 'MetalDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }

    public function actionMetalSemana(){
        return $this->render('index',[
            'vista' => 'MetalSemana',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionTiemposMuertos(){
        return $this->render('index',[
            'vista' => 'TiemposMuertos',
            'IdSubProceso' => 6,
            'IdArea' => 3
        ]);
    }
    
    public function actionTiemposMuertosAceros(){
        return $this->render('index',[
            'vista' => 'TiemposMuertos',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);
    }
    
    public function actionSeriesAceros(){
        if (isset($_GET['serie'])) {
            $serie = $_GET['serie'];
        }else{
            $serie = false;
        }
        return $this->render('index',[
            'vista' => 'seriesAceros',
            'IdSubProceso' => 6,
            'IdArea' => 2,
            'serie' => $serie
            ]);
    }
    
    public function actionAlmas()
    {
        return $this->render('index',[
            'vista' => 'moldeo',
            'IdSubProceso' => 2,
            'IdArea' => 3
        ]);
    }
    
    public function actionAlmasCatalogo(){
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 3
        ]);
    }

    public function actionAlmasCatalogoac(){
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 2
        ]);
    }
    
    public function actionAlmasCatalogoAcero()
    {
        return $this->render('index',[
            'vista' => 'almasCatalogo',
            'IdSubProceso' => 2,
            'IdArea' => 2
        ]);
    }
    
    public function actionVaciado()
    {
        return $this->render('index',[
            'vista' => 'vaciado',
            'IdSubProceso' => 10
        ]);
    }
    
    public function actionPedidosBronces()
    {
        return $this->render('pedidos',[
            'IdArea' => 3
        ]);
    }

    public function actionTurnos(){
        $model = Turnos::find()->asArray()->all();
        return json_encode($model);
    }

    public function actionPromolDia(){
        if (isset($_REQUEST["Turno"]) && isset($_REQUEST["Dia"])){
            $turno = $_REQUEST["Turno"];
            $dia = date('Y-m-d',strtotime($_REQUEST['Dia']));
        }else{
            $turno = '1';
            // $dia = '2015-10-22';
			$dia = date('Y-m-d');
        }

        echo "fecha ".$dia;
        
        return $this->render('PromolDia', ['Turno' => $turno, 'Dia' => $dia ]);                 
        /*return $this->render('index',[
            'vista' => 'PromolDia',
            'IdSubProceso' => 6,
            'IdArea' => 2
        ]);*/
    } 
	
	public function actionGraficaKloster(){
        
		return $this->render('GraficaKloster');      
    }
	
	public function actionGraficaVarel(){
        
		return $this->render('GraficaVarel');      
    }
	
	public function actionMoldesciclos(){
        
		return $this->render('moldesciclos');      
    }

	public function actionProduccionSemanalAcero(){
        
		return $this->render('ProduccionSemanalAcero');      
    }
	
    public function actionPromolSemana(){

        if (isset($_REQUEST["Semanaini"]) ){
            $sem = $_REQUEST["Semanaini"];
        }else{
            $sem = date("W");
        }
      
        return $this->render('PromolSemana', ['Semanaini' => $sem ]);                 
    }
    
	 public function actionSeriesA(){
 
        return $this->render('SeriesBirt');                 
    }
	
    
    public function actionMaterial(){
        
        $semanas = '';
        $cantidad = isset($_GET['cantidad']) && $_GET['cantidad'] != ''? $_GET['cantidad'] : 4;
        if(isset($_GET['semana'])){
            $semana = explode('-W',$_GET['semana']);
            $anio = $semana[0];
            $semana = $semana[1];
            $fecha = strtotime($anio."W".$semana."1");
            $fecha = date('Y-m-d',$fecha);
        }  else { 
            $semana = date("W");
            $anio = date("Y");
            $fecha = strtotime($anio."W".$semana."1");
            $fecha = date('Y-m-d',$fecha);
        }
        //var_dump($_GET['semana']);exit;
        
        $semanas['semana1'] = ['year'=>$anio,'week'=>$semana,'val'=>$fecha];
        $sem[] = "[".$semanas['semana1']['year']."-S".($semanas['semana1']['week']*1)."]";
        
        for($x=1; $x < $cantidad; $x++){
            $semanas['semana'.($x+1)] = $this->checarSemana($semanas['semana'.$x]);
            $sem[] = "[".$semanas['semana'.($x+1)]['year']."-S".($semanas['semana'.($x+1)]['week']*1)."]";
        }
        
        $model = VMaterialArania::find()->asArray()->all();
        $commad = new VMaterialArania();
        $Material = $commad->getMaterial($sem,$cantidad,$this->areas->getCurrent());
        $MaterialCasting = $commad->getMaterialCasting($sem,$cantidad,$this->areas->getCurrent());
       
        //var_dump($Material);
        return $this->render('Material',[
            'semanas'=>$semanas,
            'model'=>$Material,
            'model2'=>$MaterialCasting,
        ]);
    }



    public function actionDataPromolDia(){
       $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMetalDia::find()->distinct()->select("Aleacion,Anio")->where([
            'IdArea' => $this->areas->getCurrent()
        ])->asArray()->all();
       
        foreach ($metales as &$metal) {
            $semanas = '';
            $x = 1;
            $metal['Totales'] = 0;
            foreach ($dias as $dia) {
               // $semanas .= "[".$dia."],";
                $metalTot = VMetalDia::find()->select("SUM(TonTotales) AS TonTotales")->where(
                    "IdArea = ".$_GET['IdArea']." AND 
                    Anio = ".date('Y',strtotime($_GET['semana']))." AND 
                    Dia = '".$dia."' AND 
                    Aleacion = '".$metal['Aleacion']."'
                    ")->asArray()->all();

                $metal['dias']["dia$x"]['dia'] = $dia;
                $metal['dias']["dia$x"]['TonTotales'] = $metalTot[0]['TonTotales'];
                $metal['Totales'] += $metalTot[0]['TonTotales'];
                $x++;
            }

        }
       
        return json_encode($metales);
    }

    public function actionDataMetal(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMaterialArania::find()->distinct()->select("Aleacion")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        
        foreach ($metales as &$metal) {
            $x=1;
            $metal['total'] = 0;
            
            foreach ($semanas as $semana){
                $metal['semanas']["semana$x"] = VMaterialArania::find()->select("SUM(TonTotales) AS TonTotales")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'Aleacion' => $metal['Aleacion'],
                    'IdArea' => $_GET['IdArea']
                ])->asArray()->one();
                    $metal['semanas']["semana$x"]['semana'] = $semana['week'];
                    $metal['total'] += $metal['semanas']["semana$x"]['TonTotales'];
                $x++;
            }
            
        }
        //print_r($metales);
        return json_encode($metales);
    }

    public function actionDataMetalDia(){
        
        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        $metales = VMetalDia::find()->distinct()->select("Aleacion")->where([
            'IdArea' => $this->areas->getCurrent()
        ])->asArray()->all();
        
        foreach ($metales as &$metal) {
            $semanas = '';
            $x = 1;
            $metal['Totales'] = 0;
            foreach ($dias as $dia) {
               // $semanas .= "[".$dia."],";
                $metalTot = VMetalDia::find()->select("SUM(TonTotales) AS TonTotales")->where(
                    "IdArea = ".$_GET['IdArea']." AND 
                    Anio = ".date('Y',strtotime($_GET['semana']))." AND 
                    Dia = '".$dia."' AND 
                    Aleacion = '".$metal['Aleacion']."'
                    ")->asArray()->all();

                $metal['dias']["dia$x"]['dia'] = $dia;
                $metal['dias']["dia$x"]['TonTotales'] = $metalTot[0]['TonTotales'];
                $metal['Totales'] += $metalTot[0]['TonTotales'];
                $x++;
            }

        }
       
        return json_encode($metales);
    }
    
    public function actionDataProduccion()
    {
        $where = '';
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $IdSubProceso = $_REQUEST['IdSubProceso'];
            $where .= " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        $where .= " AND IdArea = ".$_REQUEST['IdArea'];
        if($IdSubProceso != 10){
            $model = Producciones::find()
                ->where("IdSubProceso = $IdSubProceso".$where)
                ->joinWith('lances')
                ->joinWith('produccionesDetalles')
                ->joinWith('almasProduccionDetalles')
                ->joinWith('idEmpleado')
                ->joinWith('idMaquina')
                ->asArray()->all();
        }else{
            $model = Producciones::find()
                ->where("IdSubProceso = $IdSubProceso".$where)
                ->with('materialesVaciados')
                ->with('idTurno')
                ->asArray()->all();
            $fechas = '';

            foreach ($model as &$mod){
                $fecha = date('Y-m-d',strtotime($mod['Fecha']));
                $turno = $mod['idTurno']['Descripcion'];
                $fechas["$fecha-$turno"]['Fecha'] = $fecha;
                $fechas["$fecha-$turno"]['Turno'] = $turno;
                foreach ($mod['materialesVaciados'] as &$material){
                    //var_dump($material);
                    $IdMaterial = $material['IdMaterial'];
                    
                    if(!isset($fechas["$fecha-$turno"]['Material'][$IdMaterial])){
                        $fechas["$fecha-$turno"]['Material'][$IdMaterial]['Cantidad'] = 0;
                    }
                    $fechas["$fecha-$turno"]['Material'][$IdMaterial]['Identificador'] = $material['idMaterial']['Identificador'];
                    $fechas["$fecha-$turno"]['Material'][$IdMaterial]['Material'] = $material['idMaterial']['Descripcion'];
                    $fechas["$fecha-$turno"]['Material'][$IdMaterial]['Cantidad'] += $material['Cantidad'];
                }
            }
            return json_encode($fechas);
        }
        return json_encode($model);
    }
    
    public function actionDataPedidos()
    {
        $model = VProgramaciones::find()
                ->where($_GET)
                ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionCatalogoAlmas()
    {
        $model = \common\models\datos\VAlmas::find()
                ->where($_GET)
                ->asArray()->all();
        return json_encode($model);
    }
    
    public function actionDataTiemposMuertos(){
        $whereFecha = '';
        $filtro = isset($_REQUEST['Filtro']) ? $_REQUEST['Filtro'] : 'false';
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $IdArea = $_REQUEST['IdArea'];
            $IdTurno = isset($_REQUEST['IdTurno']) ? $_REQUEST['IdTurno'] : 1;
            $whereFecha = " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        
        $dataProvider = VTiemposMuertos::find()->select('IdTiempoMuerto,IdMaquina,Identificador,Descripcion,Fecha,Inicio,Fin,Minutos,Observaciones,IdCausa,Causa,IdCausaTipo,ClaveTipo,Tipo,IdArea,IdTurno,IdEmpleado,Orden')->distinct()->where("IdTurno = $IdTurno AND IdArea = $IdArea $whereFecha")->orderBy('Inicio ASC')->asArray()->all();
       
        $HIni = $IdTurno == 1 ? '07:00' : '22:00';
        $HFin = $IdTurno == 1 ? '17:00' : '07:00';
        $producciones = new ProduccionesDetalle();

        foreach ($dataProvider as &$value) {
            if($value['IdArea'] == 3){
                $value['FechaInicio'] = date('Y-m-d',strtotime($value['Inicio']));
                $value['FechaFin'] = date('Y-m-d',strtotime($value['Fin']));
                $value['Inicio'] = date('H:i',strtotime($value['Inicio']));
                $value['Fin'] = date('H:i',strtotime($value['Fin']));

                $Fecha = $value['Fecha'];
                $Fecha2 = strtotime($value['Inicio']) > strtotime($value['Fin']) ? date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) : $Fecha;

                $value['Inicio'] = "$Fecha ".date('H:i',strtotime($value['Inicio']));
                $value['Fin'] = "$Fecha2 ".date('H:i',strtotime($value['Fin']));

                if($filtro == 'true'){
                    $res = $producciones->limiteHoras($value['Inicio'], $value['Fin'], "$Fecha $HIni",($HIni <= $HFin ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))))." $HFin");

                    $value['Inicio'] = $res[0];
                    $value['Fin'] = $res[1];
                }
            }
            
            $value['Minutos'] = (strtotime($value['Fin']) - strtotime($value['Inicio']))/60;

            /*$a = date("d",strtotime($value['Fin']));
            $b = date("d",strtotime($value['Inicio']));
            $c = date("H",strtotime($value['Fin']));
            $d = date("H",strtotime($value['Inicio']));

            if(($a > $b))
                $value['Minutos'] = (strtotime(date('H:i', strtotime($value['Fin']))) - strtotime(date('H:i', strtotime($value['Inicio']))))/60;
            elseif(($a == $b) && ($c < $d))
                $value['Minutos'] = (strtotime(date('Y-m-d H:i',strtotime('+1 day',strtotime($value['Fin'])))) - strtotime(date('Y-m-d H:i',strtotime($value['Inicio']))))/60;
            else
                $value['Minutos'] = (strtotime($value['Fin']) - strtotime($value['Inicio']))/60;*/
            if($value['IdArea'] == 3){
                $value['Inicio'] = date('H:i',strtotime($value['Inicio']));
                $value['Fin'] = date('H:i',strtotime($value['Fin']));
            }else{
                $value['Inicio'] = date('Y-m-d H:i',strtotime($value['Inicio']));
                $value['Fin'] = date('Y-m-d H:i',strtotime($value['Fin']));
            }
        }
        
        return json_encode($dataProvider);
    }
    
    public function actionPiezascajas(){
       
        $command = \Yii::$app->db;
        
        if(isset($_GET['semana_ini'])){
            $semana1 = explode('-W',$_GET['semana_ini']);
            $semana2 = explode('-W',$_GET['semana_fin']);
            
            $anio1 = $semana1[0];
            $semana_ini = $semana1[1];
            
            $anio2 = $semana2[0];
            $semana_fin = $semana2[1];
        }else{
            $semana_ini = date("W");
            $anio1 = date("Y");
            
            $semana_fin = date("W");
            $anio2 = date("Y");
        }
        
        $model = new Cajas();
        $datos_cajas = $model->getDetalleCajas($semana_ini,$anio1,$semana_fin,$anio2);      
        $datos_pcajas = array();
    
        foreach ($datos_cajas as $key => $value) {
            if(!isset($datos_pcajas[$value['Tamano']]['Requerido'])){
                $datos_pcajas[$value['Tamano']]['Requerido'] = 0;
            }

            $datos_pcajas[$value['Tamano']]['Tamano'] = $value['Tamano'];
            $datos_pcajas[$value['Tamano']]['Requerido'] += $value['Requiere'];
            $datos_pcajas[$value['Tamano']]['CodigoDll'] = $value['CodDlls'];
            $datos_pcajas[$value['Tamano']]['CodigoPesos'] = $value['CodPesos'];
            $datos_pcajas[$value['Tamano']]['ExitTot'] = $value['CodPesos']+$value['CodDlls'];
        }
        
       // var_dump($datos_cajas);
        
        return $this->render('piezascajas', [
           'model' => $datos_pcajas,
           'detalle' => $datos_cajas,
        ]);
    }
    
    public function actionDataFiltros(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        
        if($_GET['IdArea'] === '2'){
            $area = new VFiltrosAcero();
        }else{
            $area = new VFiltros();
        }
        
        //var_dump($semanas);
        $filtros = $area->find()->distinct()->select("Descripcion,IdFiltroTipo,CantidadPorPaquete,DUX_CodigoPesos,DUX_CodigoDolares,ExistenciaDolares,ExistenciaPesos")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        //$filtros = \common\models\catalogos\FiltrosTipo::find()->where("IdFiltroTipo <> 1")->with('filtros')->asArray()->all();
        
        foreach ($filtros as &$filtro) {
            $x=1;
            $filtro['total'] = 0;
            foreach ($semanas as $semana){
                
                $filtro['semanas']["semana$x"] = $area->find()->select("sum(Requeridas) AS Requeridas")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'IdFiltroTipo' => $filtro['IdFiltroTipo']
                ])
                ->asArray()
                ->one();
                
                $filtro['semanas']["semana$x"]['semana'] = $semana['week'];
                if($x<3){
                    $filtro['total'] += $filtro['semanas']["semana$x"]['Requeridas'];
                }
                $x++;
            }
        }
        return json_encode($filtros);
    }


    public function actionDataFiltrosDia(){
        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        
        if($_GET['IdArea'] === '2'){
            $area = new VFiltrosDiaAcero();
        }else{
            $area = new VFiltrosDia();
        }
        
        $filtros = $area->find()->distinct()->select("Descripcion,IdFiltroTipo,CantidadPorPaquete,DUX_CodigoPesos,DUX_CodigoDolares,ExistenciaDolares,ExistenciaPesos")->where([
            'IdArea' => $_GET['IdArea']
        ])->asArray()->all();
        //$filtros = \common\models\catalogos\FiltrosTipo::find()->where("IdFiltroTipo <> 1")->with('filtros')->asArray()->all();
        
        foreach ($filtros as &$filtro) {
            $x=1;
            $filtro['total'] = 0;
            foreach ($dias as $dia){
                $filtro['dias']["dia$x"] = $area->find()->select("sum(Requeridas) AS Requeridas")->where([
                    'Anio' => date('Y',strtotime($dia)),
                    'Dia' => $dia,
                    'IdFiltroTipo' => $filtro['IdFiltroTipo']
                ])->asArray()->one();
                //$filtro['dias']["dias$x"]['dia'] = $semana['week'];
                $filtro['dias']["dia$x"]['dia'] = $dia;
                $filtro['total'] += $filtro['dias']["dia$x"]['Requeridas'];
                $x++;
            }
        }
        
        return json_encode($filtros);
    }
    
    public function actionDataCamisas(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        if($_GET['IdArea'] === '2'){
            $area = new VCamisasAcero();
        }else{
            $area = new VCamisas();
        }
    
        $camisas = \common\models\catalogos\VCamisasTipo::find()->where("IdCamisaTipo <> 1")->asArray()->all();
        
        foreach ($camisas as &$camisa) {
            $x=1;
            $camisa['total'] = 0;
            $camisa['ExistenciaDolares'] *=1;
            $camisa['ExistenciaPesos'] *=1;
            
            foreach ($semanas as $semana){
                $camisa['semanas']["semana$x"] = $area->find()->select("sum(Requeridas) AS Requeridas, ExistenciaDolares, ExistenciaPesos")->where([
                    'Anio' => $semana['year'],
                    'Semana' => $semana['week'],
                    'IdCamisaTipo' => $camisa['IdCamisaTipo'],
                    'IdArea' => $_GET['IdArea']
                ])
                ->groupBy('IdCamisaTipo, ExistenciaPesos, ExistenciaDolares')
                ->asArray()
                ->one();
                //var_dump($camisa['semanas']["semana$x"]);
                if(count($camisa['semanas']["semana$x"])>0){
                    if($x<3 && isset($camisa['semanas']["semana$x"]['Requeridas'])){
                        $camisa['total'] += $camisa['semanas']["semana$x"]['Requeridas'];
                    }
                }
                $camisa['semanas']["semana$x"]['semana'] = $semana['week'];
                $x++;
            }
        }

        return json_encode($camisas);
    }
    public function actionDataCamisasProducto(){
        
        $semanas = $this->LoadSemana(!isset($_GET['semana']) ? '' : $_GET['semana']);
        
        if($_GET['IdArea'] === '2'){
            $area = new VCamisasAcero();
        }else{
            $area = new VCamisas();
        }
        
        $camisas = $area->find()
            ->where([
                'Anio' => date('Y',  strtotime($_GET['semana'])),
                'Semana' => date('W',  strtotime($_GET['semana'])),
            ])
            ->asArray()
            ->all();
        
        foreach ($camisas as $camisa) {
            if($camisa['Requeridas'] !== null){
                $datos[$camisa['IdProducto']]['Producto'] = $camisa['Producto'];
                $datos[$camisa['IdProducto']]['Camisas'][] = [
                    'Descripcion' => $camisa['Descripcion'],
                    'Tamano' => $camisa['Tamano'],
                    'Requeridas' => $camisa['Requeridas'],
                    'Observaciones' => $camisa['Observaciones']
                ];
            }
        }

        return json_encode($datos);
    }

    public function actionDataCamisasDia(){
        
        $dias = $this->LoadDias(!isset($_GET['semana']) ? '' : $_GET['semana']);
        
        if($_GET['IdArea'] === '2'){
            $semana = new VCamisasAcero();
            $area = new VCamisasDiaAcero();
        }else{
            $semana = new VCamisas();
            $area = new VCamisasDia();
        }
        
        $camisas = $semana->find()
            ->select("IdCamisaTipo, Tamano, Descripcion, sum(Requeridas) AS total, ExistenciaDolares, ExistenciaPesos, DUX_CodigoPesos, DUX_CodigoDolares")
            ->where([
                'Anio' => date('Y',strtotime($_GET['semana'])),
                'Semana' => date('W',strtotime($_GET['semana'])),
                'IdArea' => $_GET['IdArea']
            ])
            ->groupBy('IdCamisaTipo, Tamano, Descripcion, ExistenciaPesos, ExistenciaDolares, DUX_CodigoPesos, DUX_CodigoDolares')
            ->asArray()->all();
        
        //var_dump($camisas);exit;
        
        foreach ($camisas as &$camisa) {
            $x=1;
            foreach ($dias as $dia){
               //echo date('Y',strtotime($dia));
                $camisa['dias']["dia$x"] = $area->find()->select("sum(Requeridas) AS Requeridas, avg(ExistenciaDolares) AS ExistenciaDolares, avg(ExistenciaPesos) AS ExistenciaPesos")->where([
                    'Anio' => date('Y',strtotime($dia)),
                    'Dia' => $dia,
                    'IdCamisaTipo' => $camisa['IdCamisaTipo']
                ])->asArray()->one();
                
                //var_dump($camisa['dias']);
                
                $camisa['dias']["dia$x"]['dia'] = $dia;
                $x++;
            }
        }
        //print_r($camisas); exit();
        return json_encode($camisas);
    }
    
    /*public function actionVaciado(){
        
        $model = MaterialesVaciado::find()
                ->joinWith('idMaterial')
                ->joinWith('idProduccion')
                ->asArray()->all();
        //var_dump($model);exit;
        
        return $this->render('MaterialVaciado', [
            'model' => $model,
        ]);
    }*/

    

    public function Data_tiemposmuertos($ini, $fin){

        if($ini == 0){
            $where  = "";
        }else{
            $where = "WHERE tm.Fecha BETWEEN '$ini' AND '$fin' ";
        }
        //echo $where;
        
        //Pasar al modelo
        $command = \Yii::$app->db;
        $model =$command->createCommand("
            SELECT
            tm.IdTiempoMuerto,
            tm.IdCausa,
            tm.Inicio,
            tm.Fin,
            tm.Descripcion,
            m.Identificador AS Maquina,
            ct.Identificador AS TipoCausa,
            ct.Descripcion AS Tipo,
            c.Descripcion AS Causa

            FROM TiemposMuerto AS tm                 
            LEFT JOIN Maquinas AS m ON tm.IdMaquina = m.IdMaquina
            LEFT JOIN Causas AS c ON tm.IdCausa = c.IdCausa
            LEFT JOIN CausasTipo AS ct ON c.IdCausaTipo=ct.IdCausaTipo $where ")->queryAll();
        return $model;
    }
    
    public function actionDataEte(){
        $IdSubProceso = $_REQUEST['IdSubProceso'];
        $IdArea = $_REQUEST['IdArea'];
        $turno = 0;
        
        if(isset($_REQUEST['IdTurno'])){
            $turno = $_REQUEST['IdTurno'] != 0 ? " AND Producciones.IdTurno = ". $_REQUEST['IdTurno'] : "";
        }
        
        $where = " IdSubProceso = $IdSubProceso AND IdArea = $IdArea $turno";
        
        if(isset($_REQUEST['FechaIni']) && isset($_REQUEST['FechaFin'])){
            $FechaIni = date('Y-m-d',strtotime($_REQUEST['FechaIni']));
            $FechaFin = date('Y-m-d',strtotime($_REQUEST['FechaFin']));
            $where .= " AND Fecha between '$FechaIni' AND '$FechaFin'";
        }
        
        $model = Producciones::find()
            ->where($where)
            ->joinWith('produccionesDetalles')
            ->joinWith('almasProduccionDetalles')
            ->joinWith('idEmpleado')
            ->joinWith('idMaquina')
            ->asArray()
            ->all();
        
        foreach ($model as &$mod){
            $mod['Fecha'] = date('Y-m-d',strtotime($mod['Fecha']));
            $mod['Semana'] = date('W',strtotime($mod['Fecha']));
            $IdMaquina = $mod['IdMaquina'];
            $IdEmpleado = $mod['IdEmpleado'];

            foreach ($mod['almasProduccionDetalles'] as &$almas){
                $Fecha = $mod['Fecha'];
                $tIni = date('G:i:s',  strtotime($almas['Inicio']));
                $tFin = date('G:i:s',  strtotime($almas['Fin']));

                $almas['Inicio'] = "$Fecha ".date('G:i:s',  strtotime($tIni));
                $almas['Fin'] = (strtotime($tIni) <= strtotime($tFin) ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) )." ".date('G:i:s',  strtotime($tFin));
                
                $almas['Minutos'] = (strtotime($almas['Fin']) - strtotime($almas['Inicio']))/60;
                $almas['Hechas'] *= 1;
                $almas['Rechazadas'] *= 1;
                $almas['PiezasHora'] *= 1;
                
                $almas['SU'] = 0;
                $almas['MC'] = 0;
                $almas['MP'] = 0;
                $almas['TT'] = 0;
                $almas['MI'] = 0;
                $almas['MPRO'] = 0;
                /*$tiempos = VTiemposMuertos::find()->distinct()->select('Identificador,Descripcion,IdArea,Habilitado,IdMaquina,ClaveMaquina,Maquina,Eficiencia')->where(
                    "IdEmpleado = $IdEmpleado AND IdMaquina = $IdMaquina AND Fecha = '$Fecha'"
                )->asArray()->all();*/
                $tiempos = VTiemposMuertos::find()->distinct()->select('IdTiempoMuerto,IdMaquina,Identificador,Descripcion,Fecha,Inicio,Fin,Minutos,Observaciones,IdCausa,Causa,IdCausaTipo,ClaveTipo,Tipo,IdArea,IdTurno,IdEmpleado,Orden')->where(
                    "IdEmpleado = $IdEmpleado AND IdMaquina = $IdMaquina AND Fecha = '$Fecha'"
                )->asArray()->all();
                
                foreach ($tiempos as $time){
                    $tIni = date('G:i:s',  strtotime($time['Inicio']));
                    $tFin = date('G:i:s',  strtotime($time['Fin']));
                    
                    $time['Inicio'] = "$Fecha ".date('G:i:s',  strtotime($tIni));
                    $time['Fin'] = (strtotime($tIni) <= strtotime($tFin) ? $Fecha : date('Y-m-d',strtotime('+1 day',strtotime($Fecha))) )." ".date('G:i:s',  strtotime($tFin));
                    
                    $tIni = strtotime($time['Inicio']) > strtotime($almas['Inicio']) ? $time['Inicio'] : $almas['Inicio'];
                    $tIni = strtotime($almas['Fin']) > strtotime($tIni) ? $tIni : $almas['Fin'];
                    
                    $tFin = strtotime($time['Fin']) > strtotime($almas['Fin']) ? $almas['Fin'] : $time['Fin'];
                    $tFin = strtotime($almas['Inicio']) > strtotime($tFin) ? $almas['Inicio'] : $tFin;
                    
                    $tIni = strtotime($tIni);
                    $tFin = strtotime($tFin);
                    
                    $min = ($tFin - $tIni)/60;

                    $almas[$time['ClaveTipo']] +=$min;
                    
                    /*echo "Nomina: ".$mod['idEmpleado']['Nomina'] ." Nombre: ".$mod['idEmpleado']['Nombre'] ." :::: Tiempo: ". $almas['Inicio']." - " . $almas['Fin'];
                    echo "Tiempo calculado: ".date('Y-m-d H:i',$tIni)." - ".date('Y-m-d H:i',$tFin)." ";
                    echo " :::::: ". $time['Inicio']." - ".$time['Fin']." -". $time['ClaveTipo']." = ".$min."<br />";*/
                }
                
                $almas['Inicio'] = date('H:i',strtotime($almas['Inicio']));
                $almas['Fin'] = date('H:i',strtotime($almas['Fin']));
            }
        }
        return json_encode($model);
    }
    
    public function actionEteAlmas(){
         return $this->render('EteAlmas');
    }
    
    public function actionEte(){
        $maquina = 0;
        $IdArea = 3;
        $ini = 0;
        $fin = 0;
        $turno = 1;
        
        if(isset($_GET['maquina'])){ 
            $maquina = $_GET['maquina'];
            $ini = $_GET['ini'];
            $fin = $_GET['fin'];
            $turno = $_GET['IdTurno'];
        }

        $model = new ProduccionesDetalle();
        $datos_ete = $model->getDatos($maquina,$ini,$fin, 3,$_GET['subProceso'],$turno);

        $ResumenSem = array();
        $Totales = array();
        foreach ($datos_ete as &$key) {
            
            if(!isset( $ResumenSem[$key['Semana']]['TTOT'])){
                $ResumenSem[$key['Semana']]['TTOT'] = 0;
                $ResumenSem[$key['Semana']]['TDISPO'] = 0;
                $ResumenSem[$key['Semana']]['SU'] = 0;
                $ResumenSem[$key['Semana']]['MC'] = 0;
                $ResumenSem[$key['Semana']]['MP'] = 0;
                $ResumenSem[$key['Semana']]['TT'] = 0;
                $ResumenSem[$key['Semana']]['MI'] = 0;
                $ResumenSem[$key['Semana']]['MPRO'] = 0;
                $ResumenSem[$key['Semana']]['DISPO'] = 0;
                $ResumenSem[$key['Semana']]['PESPERADO'] = 0;
                $ResumenSem[$key['Semana']]['PREAL'] = 0;
                $ResumenSem[$key['Semana']]['EFICIENCIA'] = 0;
                $ResumenSem[$key['Semana']]['Rechazadas'] = 0;
                $ResumenSem[$key['Semana']]['OK'] = 0;
                $ResumenSem[$key['Semana']]['CALIDAD'] = 0;
                $ResumenSem[$key['Semana']]['ETE'] = 0;
                $ResumenSem[$key['Semana']]['TotalDA'] = 0;
            }
            
            $Ti = strtotime($key['Inicio'])/ 60 ;
            $Tf = strtotime($key['Fin']) / 60 ;
            
            $Producesperada = (($key['MoldesHora']*0.86)/60);
            
            $ttot = $Tf - $Ti - ($key['TT'] + $key['MP']);
            $tdispo = $ttot - ($key['SU'] + $key['MC']);
            $dispo = $ttot <= 0 ? 0 : ($tdispo / $ttot)*100;
            $pesperado = round($Producesperada*$tdispo);
            $preal = $pesperado == 0 ? 0 : ($key['Hechas']/$pesperado)*100;
            $key['OK'] = abs($key['OK']);
            $key['Rec'] =abs($key['Rec']);
            $key['PRODUCESPERADO'] = $Producesperada; 
            $key['TTOT'] = $ttot;
            $key['TDISPO'] = $tdispo;
            $key['DISPO'] = $dispo;
            $key['PESPERADO'] =  $pesperado;
            $key['PREAL'] = $key['Hechas'];
            $key['EFICIENCIA'] = $preal;
            $key['CALIDAD'] = $key['OK'] == 0 ? 0 :($key['OK']/($key['OK']+$key['Rec']))*100;
            $key['ETE'] = ((($key['DISPO']/100)*($key['EFICIENCIA']/100)*($key['CALIDAD']/100))*100);

            $ResumenSem[$key['Semana']]['TTOT'] += $ttot;
            $ResumenSem[$key['Semana']]['TDISPO'] += $tdispo;
            $ResumenSem[$key['Semana']]['SU'] += $key['SU'];
            $ResumenSem[$key['Semana']]['MC'] += $key['MC'];
            $ResumenSem[$key['Semana']]['MP'] += $key['MP'];
            $ResumenSem[$key['Semana']]['TT'] += $key['TT'];
            $ResumenSem[$key['Semana']]['MI'] += $key['MI'];
            $ResumenSem[$key['Semana']]['MPRO'] += $key['MPRO'];
            $ResumenSem[$key['Semana']]['DISPO'] += $dispo;
            $ResumenSem[$key['Semana']]['PESPERADO'] += $pesperado;
            $ResumenSem[$key['Semana']]['PREAL'] += $key['Hechas'];
            $ResumenSem[$key['Semana']]['EFICIENCIA'] += $preal;
            $ResumenSem[$key['Semana']]['Rechazadas'] = $key['Rec'];
            $ResumenSem[$key['Semana']]['OK'] = $key['OK'];
            $ResumenSem[$key['Semana']]['CALIDAD'] = $key['CALIDAD'];
            $ResumenSem[$key['Semana']]['ETE'] += $key['ETE'];
            $ResumenSem[$key['Semana']]['TotalDA'] ++;
            
        
        } 
        //exit;
        return $this->render('Ete', [
            'model' => $datos_ete,
            'resumen'=>$ResumenSem,
            //'totales' =>$Totales,
        ]);
        
        
    }
    
    public function actionMaquinas(){
        $maquinas =Maquinas::find()->asArray()->all();
         
        return json_encode(
           $maquinas
        );   
    }

    public function actionProductoscolli(){

        $command = \Yii::$app->db;
        $model =$command->createCommand("SELECT
                                            dbo.Productos.IdProducto,
                                            dbo.Pedidos.IdPedido,
                                            dbo.Pedidos.IdAlmacen,
                                            dbo.Pedidos.OrdenCompra,
                                            dbo.Pedidos.EstatusEnsamble,
                                            dbo.Pedidos.SaldoExistenciaPT,
                                            dbo.Pedidos.Cantidad,
                                            dbo.Pedidos.SaldoCantidad,
                                            dbo.Pedidos.Cliente,
                                            dbo.Productos.Ensamble,
                                            dbo.Pedidos.FechaEmbarque,
                                            dbo.Pedidos.Observaciones,
                                            dbo.Productos.Identificacion
                                        FROM
                                            dbo.Productos
                                        INNER JOIN dbo.Pedidos ON dbo.Productos.IdProducto = dbo.Pedidos.IdProducto
                                        WHERE dbo.Productos.Ensamble = 1 ORDER BY dbo.Productos.IdProducto, dbo.Pedidos.IdPedido ASC"
                                        )->queryAll();
       

        //var_dump($Material);
        return $this->render('ProductosColli',['model'=>$model,]);
        
    }
            
    function calcular_tiempo($hora1,$hora2){
        
        $tiempo1 = date('H:i:s',strtotime($hora1));
        $fecha1 = date('Y-m-d',strtotime($hora1));
        
        $tiempo2 = date('H:i:s',strtotime($hora2));
        $fecha2 = date('Y-m-d',strtotime($hora2));
        
        $horas[1]=explode(':',$tiempo1);
        $fecha[1]=explode('-',$fecha1);
        
        $horas[2]=explode(':',$tiempo2);
        $fecha[2]=explode('-',$fecha2);
        
        //                 horas       minutos     segundos        mes          dia          año
        $fecha1=mktime($horas[1][0],$horas[1][1],$horas[1][2],$fecha[1][1],$fecha[1][2],$fecha[1][0]);
        $fecha2=mktime($horas[2][0],$horas[2][1],$horas[2][2],$fecha[2][1],$fecha[2][2],$fecha[2][0]);
        
        $segundos=$fecha2-$fecha1;
        $minutos=$segundos/60;  
        
      return $minutos;
    }
/*************MANTENIMIENTO***********/

    /*SOLICITUDES DE MANTENIMIENTO*/
    public function actionSolicitudMantenimiento(){
        return $this->render('mantenimiento',[
            'vista' => 'FormSolMantenimiento',
            'tipo' => 'solicitud'
        ]);
    }
    /*Solicitudes mantenimiento abiertas*/
    public function actionSolicitudesAbiertas(){
        return $this->render('mantenimiento',[
            'vista' => 'FormSolMantenimiento',
            'tipo' => 'abiertos'
        ]);
    }
    /*Solicitudes mantenimiento cerradas*/
    public function actionSolicitudesCerradas(){
        return $this->render('mantenimiento',[
            'vista' => 'FormSolMantenimiento',
            'tipo' => 'cerrados'
        ]);
    }
    /*Solicitudes mantenimiento cerradas*/
    public function actionSolicitudesPruebas(){
        return $this->render('mantenimiento',[
            'vista' => 'FormSolMantenimiento',
            'tipo' => 'pruebas'
        ]);
    }
/*************FIN MANTENIMIENTO***********/
}