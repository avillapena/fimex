
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$this->title = $title;
//$minFecha = date('H')< 6 ? date('Y-m-d',strtotime('-1 day',strtotime(date()))) : date('Y-m-d');
?>
<style>
    .table{
        display: fixed;
    }
    
    .table input{
        width: 100%;
    }
    
    .table .captura{
        width: 50px;
    }
    
    .div-table-content {
      height:300px;
      overflow-y:auto;
    }
    .div-table-content2 {
      height:200px;
      overflow-y:auto;
    }
    .scrollable {
        width: 100%;
        margin: auto;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    thead {
        background: white;
    }
    table {
        width: 100%;
        border-spacing:0;
        margin:0;
    }
    table th , table td  {
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
    }
    
    #detalle, #rechazo, #TMuerto, #Temperaturas{
        overflow: auto;
    }
    #completo{
        width:97%;
        height:91%;
        position:absolute;
        display:block;
        background: #999999;
        z-index:99999;
        opacity:1;
        margin:0%;
        -webkit-transition: all 1s ease-in-out;
        -moz-transition: all 1s ease-in-out;
        -o-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
    }
    .centrado{
        width:50%;
        max-width: 400px;
        height:auto;
        position:relative;
        display:block;
        margin:auto;
        border:red solid 1px;
        top:30%;
        background:#ffffff;
        border:white solid 1px;
        padding:30px;
    }
     /*
     * Estilos para la captura de series de piezas OK
     * Daniel Huerta 
     * 14/10/15
     */
        .panel-heading{background:#416EB3;color:#ffffff;}
        .contenido{
            width:100%;
            /*height:auto;
            max-*/height: 280px;
            position:relative;
            display:block;
            margin:auto;
            
            overflow: auto;
            border:#cccccc solid 2px;
        }
        /*#contenido .form-group{display:none;}*/
        .left{text-align: left}
        .box-header{
            width:48%;
            height:auto;
            position:relative;
            display:inline-block;
            color:#000000;
            text-align: center;
            margin:5px;
            padding:5px 0;
        }
        .repetido{
            width:48%;
            height:200px;
            position:relative;
            display:inline-block;
            text-align:center;
            margin:0 5px;
            overflow:hidden;
            border:#999999 solid 1px;
            border-radius:10px;
        }
        .noScroll{
            width:100%;
            height:200px;
            position:absolute;
            display:block;
            margin:auto;
            padding-right:0;
            overflow:auto;
        }
        .con-series{
            width:95%;
            height:auto;
            position:relative;
            display:block;
            margin:3px auto;
            border-bottom:#eeeeee solid 1px;           
            cursor:pointer;
            text-align: left;
        }
        .con-series:hover{
            background:#999999;
            color:#ffffff;
        }
        .repetido.border{border:#999999 solid 1px;margin-bottom:5px;}
        #capturaAceptadas, #capturaRechazadas{
            display:block;
        }
    /*
     * Estilos para la captura de series de piezas OK
     * Daniel Huerta 
     * 14/10/15
     */


    /*
     * Estilos para la captura de evidencias, (series, motivos, comentarios e imagenes) de piezas rechazadas (reparacion y scrap)
     * Daniel Huerta 
     * 14/10/15
     */
        .repetir{
            width:98%;
            position:relative;
            display:block;
            margin:10px auto;
            text-align: center;
            border:#999999 solid 1px;
        }
        .titulo{
            width: 100%;
            height:auto;
            background: #999999;
            color:#ffffff;
            text-align: center;
        }
        .mid{
            width:50%;
            height:auto;
            position:relative;
            display:inline-block;
            vertical-align: top;
            margin:auto;           
            /*border:#eeeeee dotted 1px;*/
        }
        .imagen{
            width:100%;
            height:100px;
        }
        .imagen img{
            height:100%;
        }
        .contiene{
            width:100%;
            height:auto;
            /*border:#999999 dotted 1px;*/
        }
        .contiene select{
            width: 100%;
            height:30px;
            /*border:none;*/
        }
        .mid textarea{
            width:100%;
            height: 60px;
            /*border:none;*/
            resize:none;
        }
        .contiene .input{
            width:100%;
            height:40px;
            overflow: hidden;
            position: relative;
            border:#999999 solid 1px;
            margin:-5px 0 0 0;
            cursor: pointer;
        }
        .contiene .input .input-file {
            margin: 0;
            padding: 0;
            outline: 0;
            font-size: 10000px;
            border: 10000px solid transparent;
            opacity: 0;
            filter: alpha(opacity=0);
            position: absolute;
            right: -1000px;
            top: -1000px;
            cursor: pointer;
        }
        .barBoton{
            width:100%;
            height:auto;
            position:relative;
            display:block;
        }
        .barBoton .boton{
            width:150px;
            height:auto;
            position:relative;
            display:block;
            margin:0 10px;
            border-radius:5px;
            padding: 2px 0;
            background:green;
            color:white;
            cursor:pointer;
        }
        .contInformacion{
            width:100%;
            height:auto;
            max-height: 240px;
            overflow: auto;
            text-align: left;
            margin-bottom:10px;
        }
        .contInformacion.noMargin{margin-bottom:0px;margin-top:10px;}
        .cntMaterial, .inpMaterial{
            width:25%;
            height:auto;
            position:relative;
            display:inline-block;
            max-height:25px;
            overflow: hidden;
            border:gray solid 1px;
        }
        .cntMaterial.noBorder, .inpMaterial.noBorder{
            border:none;
        }
        .inpMaterial{width:20%;}
        .cntMat{
            width:100%;
            height:auto;
            border:none;
        }
        .listaSerie{
            position:relative;
            display:inline-block;
            margin:0 10px 10px 0;
            border-bottom:#999999 solid 1px;
            border-right:#999999 solid 1px;
        }
    /*
     * Estilos para la captura de evidencias, (series, motivos, comentarios e imagenes) de piezas rechazadas (reparacion y scrap)
     * Daniel Huerta 
     * 14/10/15
     */
</style>
<!--Codigo para subir archivos por medio de ajax-->

<script>
    function sendImagen(id){
        varIdNew = id.split("_");
        var valor = document.getElementById(id).value;
        idNew = "formuploadajax_"+varIdNew[1];
        var formData = new FormData(document.getElementById(idNew));
        formData.append("name", valor);
        $.ajax({
            url: "recibe",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
</script>
<!--Codigo para subir archivos por medio de ajax-->
<div class="container-fluid" ng-controller="ProduccionAceros" ng-init="
    IdTurno = 1;
    Fecha = '<?= date('Y-m-d')?>';
    countProduccionesC(<?=$IdSubProceso?>,<?=$IdArea?>,<?=$IdAreaAct?>);
    IdSubProceso = <?=$IdSubProceso?>;
    IdAreaAct = <?= is_null($IdAreaAct) ? 'null' : $IdAreaAct ?>;
    IdCentroTrabajo = <?= is_null($IdAreaAct) ? 'null' : $IdAreaAct ?>;
    IdMaquina = 1;
    IdArea = <?= $IdArea?>;
    IdEmpleado = <?=$IdEmpleado?>;
    loadProgramaciones(true);
    saveProduccion();
    loadEmpleados('4-5');
    loadDefectos();
    loadTurnos();
    loadMaterialPadre();
    datos.preparacion=[];">
    
    <!---Espacio para div que cubre toda la pantalla y pide informacion para hacer la busqueda-->
    <!--<div id="completo" ng-model="completo" >
        <div class="centrado">
            <div class="input-group">
                <span class="input-group-addon">Fecha de captura:</span>
                <input class="form-control input-sm" type="date" ng-change="loadProgramaciones(false); loadComponentes();" ng-model="Fecha" format-date min="<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>" />
            </div><br />
            <input type="hidden" ng-model="FechaMoldeo2">
            <div class="input-group">
                <span class="input-group-addon">Turno:</span>
                <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones(false); loadComponentes();" class="form-control" ng-model="IdTurno" required>
                    <option ng-selected="IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                </select>                    
            </div><br />
            <div class="input-group" ng-model="msgError" id="msgError"></div>
            <div class="input-group" >
                <button class="btn btn-info" ng-click="loadDivFlotante()">Guardar</button>
            </div>
        </div>
    </div>-->
    <h3><?=$title?> </h3>
    <div id="encabezado" class="row">
        <div class="col-md-12">ID:{{IdProduccion}}
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha de captura:</span>
                            <input class="form-control input-sm" type="date" ng-change="loadProgramaciones(false); loadComponentes();" ng-model="produccion.Fecha" format-date />
                        </div>                        
                        <div class="input-group">
                            <span class="input-group-addon">Turno:</span>
                            <select id="turnos" aria-describedby="Turnos" ng-change="loadProgramaciones(false)" class="form-control" ng-model="IdTurno" required>
                                <option ng-selected="produccion.IdTurno == turno.IdTurno" value="{{turno.IdTurno}}" ng-repeat="turno in turnos">{{turno.IdTurno}} - {{turno.Descripcion}}</option>
                            </select>                    
                        </div>
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select  aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Procedimiento:</span>
                            <input class="form-control input-sm" type="text" ng-model="procedimiento" />
                        </div>                        
                        <div class="input-group">
                            <span class="input-group-addon">Norma:</span>
                            <input class="form-control input-sm" type="text" ng-model="norma" />
                        </div>
                    </div>-->
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="saveProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                        <button class="btn btn-success" ng-click="saveProduccion();" ng-show="mostrar">Guardar</button>
                        <button class="btn btn-danger" ng-click="deleteProducciones();" ng-show="mostrar">Eliminar</button>
                        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        <?php if($IdSubProceso == 10):?>
                        <button ng-click="buscar2();" class="btn btn-info">Mantenimiento de Hornos</button>
                        <?php endif;?>
                        <button title="Buscar" class="btn" ng-click="buscar();" >Buscar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-default btn-sg" ng-click="First2();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
                        <button title="Registro Anterior" class="btn btn-default btn-sg" ng-click="Prev2();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
                        <b>Registro: {{index+1}} de {{producciones.length}}</b>
                        <button title="Siguiente Registro" class="btn btn-default btn-sg" ng-click="Next2();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
                        <button title="Ultimo Registro" class="btn btn-default btn-sg" ng-click="Last2();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
                        <b>Semana: {{produccion.Semana}}</b>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row"><hr /></div>
    <div class="row">
        <div class="col-md-4">
            <div class="row" style="width:100%;">
                <div class="col-md-6" style="width:100%">
                    <?= $this->render('FormCalidadExistencia',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row" style="width:100%;">
                <div class="col-md-6" style="width:100%">
                    <?= $this->render('FormCalidadDetallesPM',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row" style="width:100%;">
                <div class="col-md-6" style="width:100%">
                    <?= $this->render('FormCalidadDetallesPMseries',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="row" style="width:100%;">
                <div class="col-md-4" style="width:100%">
                    <?= $this->render('FormCalidadRechazadasPM',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="row" style="width:100%;">
                <div class="col-md-4" style="width:100%">
                    <?= $this->render('FormDetalleResumen',[
                        'IdSubProceso'=>$IdSubProceso,
                        'IdAreaAct' => $IdAreaAct,
                    ]);?>
                </div>
            </div>
        </div>
    </div>
</div>