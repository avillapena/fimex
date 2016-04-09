
<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;

$title = "Limpieza acero";
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
    
    #detalle, #existencia, #rechazo, #TMuerto, #Temperaturas, #material{
        height:280px;
    }
</style>
<h4 style="margin-top:0;"><?=$title?></h4>
<div class="container-fluid" ng-controller="Produccion2" ng-init="
    Fecha = '<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>';
    IdTurno = 1;
    IdSubProceso = <?=$IdSubProceso?>;
    IdArea = <?=$IdArea?>;
    CountRegistros();
    loadProgramacion(true);
    loadRetrabajo();
    loadCentros();
    loadFallas();
    loadDefectos();
    loadMaterial();
    loadTurnos();
    loadEmpleados('1-6');
">
    <div id="encabezado" class="row">
        <div class="col-md-10">
            <form class="form-horizontal" name="editableForm" onaftersave="saveProduccion()">
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Fecha:</span>
                            <input ng-show="!mostrar" class="form-control input-sm" type="date" ng-change="produccion.Fecha = Fecha;loadProgramacion();" max="<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>" ng-model="Fecha" format-date/>
                            <input ng-show="mostrar" type="date" disabled="" class="form-control input-sm" ng-model="produccion.Fecha" format-date/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Centros" class="input-group-addon">Proceso:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Centros" class="form-control input-sm" ng-change="produccion.IdCentroTrabajo = IdCentroTrabajo;loadMaquinas();loadProgramacion();" ng-model="IdCentroTrabajo" required>
                                <option ng-selected="produccion.IdCentroTrabajo == centro.IdCentroTrabajo" ng-if="centro.centrosTrabajoMaquinas.length > 0" value="{{centro.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idCentroTrabajo.Descripcion}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Maquinas" class="input-group-addon">Herramienta:</span>
                            <select ng-show="!mostrar" id="aleacion" aria-describedby="Maquinas" class="form-control input-sm" ng-change="produccion.IdMaquina = IdMaquina;loadProgramacion();" ng-model="IdMaquina" required>
                                <option ng-selected="produccion.IdMaquina == maquina.IdMaquina" value="{{maquina.IdMaquina}}" ng-repeat="maquina in maquinas">{{maquina.Maquina}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idMaquina.Descripcion}}"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span id="Empleados" class="input-group-addon">Empleado:</span>
                            <select ng-show="!mostrar" aria-describedby="Empleados" class="form-control input-sm" ng-model="IdEmpleado" required>
                                <option ng-selected="produccion.IdEmpleado == e.IdEmpleado" ng-repeat="e in empleados" ng-value="{{e.IdEmpleado}}">{{e.NombreCompleto}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idEmpleado.ApellidoPaterno}} {{produccion.idEmpleado.ApellidoMaterno}} {{produccion.idEmpleado.Nombre}}"/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span id="Turnos" class="input-group-addon">Turno:</span>
                            <select ng-show="!mostrar" aria-describedby="Turnos" class="form-control input-sm" ng-change="produccion.IdTurno = IdTurno;loadProgramacion();" ng-model="IdTurno" required>
                                <option ng-selected="IdTurno == t.IdTurno" ng-repeat="t in turnos" ng-value="{{t.IdTurno}}">{{t.Descripcion}}</option>
                            </select>
                            <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{produccion.idTurno.Descripcion}}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span id="Observaciones" class="input-group-addon">Observaciones:</span>
                            <textarea aria-describedby="Observaciones" class="form-control input-sm" ng-model="produccion.Observaciones">{{produccion.Observaciones}}</textarea>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary" ng-click="addProduccion();mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                        <button class="btn btn-primary" ng-click="findProduccion();mostrar=true" ng-show="!mostrar">Generar</button>
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
        <div class="col-md-4">
            <?= $this->render('programacionExistencia',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
            <?= $this->render('programacionExistenciaRetrabajo',[
                'IdSubProceso'=>$IdSubProceso,
            ]);?>
        </div>
        <div class="col-md-5">
            <?= $this->render('FormProduccionDetalle',[
                'IdSubProceso'=>$IdSubProceso,
                'titulo' => "Captura de produccion",
                'tipo' => 1
            ]);?>
            <?= $this->render('FormProduccionDetalle',[
                'IdSubProceso'=>$IdSubProceso,
                'titulo' => "Captura Retrabajo",
                'tipo' => 2
            ]);?>
        </div>
        <div class="col-md-3">
            <?= $this->render('FormProduccionMaterial',[
                'subProceso'=>$IdSubProceso,
            ]);?>
        </div>
    </div>
    <modal title="Buscar Produccion" visible="showModal">
        <div id="Busqueda" style="height: 400px;overflow: auto;" scrolly="buscar(filtro);"><table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th rowspan="2"><button class="form-control btn-primary" ng-click="reset();buscar(filtro);">Filtrar</button></th>
                    <th>Semana</th>
                    <th>Fecha</th>
                    <th>Turno</th>
                    <th>Empleado</th>
                    <th>Maquina</th>
                    <th>Producto</th>
                    <th rowspan="2">Buenas</th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Semana"></th>
                    <th><input type="date" class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Fecha"></th>
                    <th>
                        <select class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Turno">
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                        </select>
                    </th>
                    <th><input class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Empleado"></th>
                    <th><input class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Maquina"></th>
                    <th><input class="form-control" ng-change="reset();buscar(filtro);" ng-model="filtro.Producto"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': produccion.IdProduccion == busqueda.IdProduccion}"
                    ng-repeat="busqueda in busquedas"
                >
                    <td><button class="btn" ng-click="buscarIndex(busqueda.IdProduccion);">Ver</button></td>
                    <td>{{busqueda.Semana}}</td>
                    <td>{{busqueda.Fecha | date:'dd-MMM-yyyy'}}</td>
                    <td>{{busqueda.Turno}}</td>
                    <td ng-show="IdSubProceso == 10">{{busqueda.Lance}}</td>
                    <td>{{busqueda.Empleado}}</td>
                    <td>{{busqueda.Maquina}}</td>
                    <td>{{busqueda.Producto}}</td>
                    <td>{{busqueda.Hechas}}</td>
                    <td>{{busqueda.Rechazadas}}</td>
                </tr>
            </tbody>
        </table></div>
    </modal>
</div>