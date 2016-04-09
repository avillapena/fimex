
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$title = '';
$title = "Control de Inventarios";
$this->title = $title;


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
        height:280px;
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
</style>
<div class="container-fluid" ng-controller="Inventarios" ng-init="
    CountRegistros();
    mostrar=true;
    Fecha = '<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>';
    IdTurno = 1;
    loadProductos();
    loadCentro();
    loadSubProcesos();
    loadEmpleados();
    activa();
    fmoldeo=false;
    First();
    ">
    <!--<div id="completo" ng-model="completo" >
        <div class="centrado">
            <div class="input-group">
                <span class="input-group-addon">Fecha:</span>
                <input class="form-control input-sm" type="date" ng-model="inventario.Fecha" format-date />
            </div><br />
            <div class="input-group">
                <span class="input-group-addon">Empleado:</span>
                <select aria-describedby="Empleados" class="form-control input-sm" ng-model="inventario.IdEmpleado" required>
                    <option ng-selected="inventario.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                </select>
            </div><br />
            <div class="input-group">
                <span id="Maquinas" class="input-group-addon">SubProceso:</span>
                <select id="aleacion" class="form-control input-sm" ng-model="inventario.IdSubProceso" required>
                    <option ng-selected="inventario.IdSubProceso == centro.IdSubProceso" value="{{centro.IdSubProceso}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                </select>
            </div><br />
            <div class="input-group" ng-model="msgError" id="msgError"></div>
            <div class="input-group" >
                <button class="btn btn-info" ng-click="loadDivFlotante()">Guardar</button>
            </div>
        </div>
    </div>-->
    <h4 style="margin-top:0;"><?=$title?></h4>
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Id:</span>
                            <input class="form-control input-sm" disabled="true" ng-model="inventario.IdInventario"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input class="form-control input-sm" type="date" ng-model="inventario.Fecha" format-date/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Empleado:</span>
                            <select aria-describedby="Empleados" class="form-control input-sm" ng-model="inventario.IdEmpleado" required>
                                <option ng-selected="inventario.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">SubProceso:</span>
                            <select id="aleacion" class="form-control input-sm" ng-model="inventario.IdSubProceso" required>
                                <option ng-selected="inventario.IdSubProceso == centro.IdSubProceso" value="{{centro.IdSubProceso}}" ng-repeat="centro in SubProcesos">{{centro.Descripcion}}</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" ng-click="mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="addInventario2();mostrar=true" ng-show="!mostrar">Generar</button>
                        <button class="btn btn-success" ng-click="loadProduccion();mostrar=true" ng-show="!mostrar">Cancelar</button>
                        <button class="btn btn-success" ng-click="updateProduccion();getChanges();saveChanges();" ng-show="mostrar">Guardar</button>
                        <button class="btn btn-danger" ng-click="deleteProducciones();" ng-show="mostrar">Eliminar</button>
                        <button class="btn" ng-click="produccion.IdProduccionEstatus=2;saveProduccion();" ng-show="mostrar">Cerrar Captura</button>
                        <button title="Buscar" class="btn" ng-click="buscar();" >Buscar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button title="Primer Registro" class="btn btn-default btn-sg" ng-click="First();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
                        <button title="Registro Anterior" class="btn btn-default btn-sg" ng-click="Prev();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
                        <b>Registro: {{index+1}} de {{TotalRegistros}}</b>
                        <button title="Siguiente Registro" class="btn btn-default btn-sg" ng-click="Next();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
                        <button title="Ultimo Registro" class="btn btn-default btn-sg" ng-click="Last();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
                        <b>Semana: {{produccion.Semana}}</b>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <hr />
        <div>
            <alert ng-repeat="alert in alerts" type="{{alert.type}}" close="closeAlert($index)">{{alert.msg}}</alert>
        </div>
    </div>
    
    
    <div class="row">
        
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render($transaccion ? 'FormTransacciones' : 'FormTransferencias');?>
                </div>
                
            </div>
        </div>
    </div>
    
</div>