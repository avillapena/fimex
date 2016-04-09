<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\URL;
$anio = substr(date('Y'), 2);
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
        height:380px;
    }

    .right{
        float: right;
    }

    .left{
        float: left;
    }

    .margin-top{
        margin-top: 15px;
    }

    .margin-bottom{
        margin-bottom: 20px;
    }

    .listaSerie{
        position:relative;
        display:inline-block;
        margin:0 10px 10px 0;
        border-bottom:#ccc solid 1px;
        border-right:#ccc solid 1px;
        border-top:#ccc solid 1px;
        border-left:#ccc solid 1px;
    }
</style>
<div ng-app="programa">
    <div class="container-fluid" ng-controller="Certificados" ng-init="
        IdArea = <?=$IdArea?>;
        CountRegistros();
        loadEmpleados();
        loadNormas();
        loadNumCertificado(); 
        loadTiposCerty();
    ">
        <h2><?= $title ?></h2><br>
        <!-- INICIO Encabezado del Certificado -->
        <div id="encabezado" class="row" >
            <div class="col-md-6" style="margin-bottom: 10px" >
                <p style="font-size: 17px" class="right" ><b>Num. Certificado {{nocerty}}-<?=$anio ?> {{nocliente}}</b></p>
            </div>ss{{certificados}}
            <div class="col-md-10">
                <form class="form-horizontal" id="formuploadajax" enctype="multipart/form-data" name="editableForm" >
                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">Fecha:</span>
                                <!--<input class="form-control input-sm" type="date" ng-model="Fecha" ng-value="certificado.Fecha" format-date/>
                                <input class="form-control input-sm" ng-model="certificado.Fecha"/>-->

                                <input ng-show="!mostrar" class="form-control input-sm" type="date" min="<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>" max="<?=strtotime(date('G:i:s')) < strtotime('06:00') ? date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))) : date('Y-m-d');?>" ng-model="Fecha" format-date/>

                                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{certificados.Fecha}}"/>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Tipo Certificado:</span>
                                <!--<select class="form-control input-sm" ng-change="TipoCerty()" ng-model="IdTipoCertificado" required>
                                    <option value="{{certificad.IdTipoCertificado}}" ng-repeat="certificad in tiposcerty">{{certificad.Certificado}}</option>
                                </select>-->

                                <!--<select class="form-control input-sm" ng-change="TipoCerty()" ng-model="Tipo" required>
                                    <option ng-selected="" value="{{t.IdTipoCertificado}}" ng-repeat="t in tiposcerty" >{{t.Certificado}}</option>
                                </select>
                                
                                <select ng-show="!mostrar" aria-describedby="TipoCertificado" class="form-control input-sm" ng-change="TipoCerty();" ng-model="IdTipoCertificado" required>
                                    <option ng-selected="certificado.IdTipoCertificado == certificad.IdTipoCertificado" ng-repeat="certificad in tiposcerty" ng-value="{{certificad.IdTipoCertificado}}">{{certificad.Certificado}}</option>
                                </select> -->
                                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{certificados.idTipoCertificado.Certificado}}"/>
                            </div>
                        </div>
                       
                        <div class="col-md-2">
                            <div ng-show="IdTipoCertificado == 10 || certificados.IdTipoCertificado == 10" class="input-group">
                                <span class="input-group-addon">Año de Analisis:</span>
                                <input class="form-control input-sm" type="text"  ng-model="AnioAnalisis"/>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" >
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-addon">Orden de Compra:</span>
                                <input ng-show="!mostrar" class="form-control input-sm" type="text" ng-change="loadPedidosCliente(); loadNumCliente();" ng-model="OrdenCompra"/>
                                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{certificado.OrdenCompra}}"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon">Factura:</span>
                                <input ng-show="!mostrar" class="form-control input-sm" type="text" ng-model="Factura"  />
                                <input ng-show="mostrar" disabled="" class="form-control input-sm" value="{{certificados.OrdenCompra}}"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span id="Observaciones" class="input-group-addon">Observaciones:</span>
                                <textarea ng-show="!mostrar" aria-describedby="Observaciones" class="form-control input-sm" ng-model="Observaciones"></textarea>
                                <textarea ng-show="mostrar" disabled="" aria-describedby="Observaciones" class="form-control input-sm">{{certificado.Observaciones}}</textarea>
                                
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" ng-click="certificados=[];mostrar=false" ng-show="mostrar">Nuevo Registro</button>
                            <button class="btn btn-primary" ng-click="saveCertificado();mostrar=true" ng-show="!mostrar">Generar</button>
                            <button class="btn btn-success" ng-click="loadCertificados();mostrar=true" ng-show="!mostrar">Cancelar</button>
                            <button class="btn btn-danger" ng-click="deleteCertificado();" ng-show="mostrar">Eliminar</button>
                            <button title="Buscar" class="btn" ng-click="buscar();">Buscar</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button title="Primer Registro" class="btn btn-default btn-sg" ng-click="First();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span></button>
                            <button title="Registro Anterior" class="btn btn-default btn-sg" ng-click="Prev();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-backward" aria-hidden="true"></span></button>
                            <b>Registro: {{index+1}} de {{TotalRegistros}}</b>
                            <button title="Siguiente Registro" class="btn btn-default btn-sg" ng-click="Next();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-forward" aria-hidden="true"></span></button>
                            <button title="Ultimo Registro" class="btn btn-default btn-sg" ng-click="Last();" ng-disabled="!mostrar"><span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span></button>
                            
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- FIN Encabezado del Certificado -->
        <div class="row"> <hr/>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">Producto:</span>
                    <select  class="form-control input-sm" ng-change="loadColadas()" ng-model="IdProducto" required>
                        <option ng-selected="" value="{{producto.IdProducto}}" ng-repeat="producto in pedidos" >{{producto.Producto}}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">Colada:</span>
                    <select class="form-control input-sm" ng-model="Colada" ng-change="loadSeries()" required>
                        <option ng-selected="" value="{{colada.Colada}}-{{colada.IdLance}}" ng-value="" ng-repeat="colada in coladas" >{{colada.Colada}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row margin-top">
            <div class="col-md-2 listaSerie" style="overflow-y: scroll; width:210px; height:150px; left:20px;">
                <div class="input-group">
                    <span>Series:</span>
                    <br>
                    <div ng-repeat="series in listadoseries" class="listaSerie">

                        <input type="checkbox" name="Series[]" ng-model="IdSerie" value="{{series.IdSerie}}-{{series.Serie}}"> {{series.Serie}} 
                    </div>
                </div>
            </div>

            <div class="col-md-2 listaSerie" style="overflow-y: scroll; width:210px; height:150px; left:110px;" >
                <div class="input-group">
                    <span>Fecha Moldeo:</span>
                    <br>
                    <div ng-repeat="fechas in listadoseries" ng-if="fechas.FechaMoldeo != null" class="listaFechaM">
                        <input type="checkbox" name="Fechas[]" ng-model="FechaMoldeo" value="{{fechas.FechaMoldeo}}"> {{fechas.FechaMoldeo}} 
                    </div>
                </div>
            </div>
        </div>

        <div class="row margin-top"> <hr/>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">Norma</span>
                    <select class="form-control input-sm" ng-model="Norma" required>
                        <option ng-selected="" value="{{norma.IdNorma}}" ng-repeat="norma in normas" >{{norma.NombreNorma}} {{norma.Identificador}}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group" ng-show="IdTipoCertificado != 10 && IdTipoCertificado != null">
                    <span class="input-group-addon">Proced/Revisión:</span>
                    <input class="form-control input-sm" type="text" ng-model="Procedimiento"/>
                </div>
            </div>

            <!--<div class="col-md-2 listaSerie" style="overflow-y: scroll; width:340px; height:160px; left:20px;">
                <div class="input-group">
                    <span><strong> Pruebas No Destructivas:</strong></span>
                    <br>
                    <div ng-repeat="certificado in tiposcerty" ng-if="certificado.TipoCert == 1" class="listaCertificados">
                        <input type="checkbox" name="Certificados[]" ng-model="IdTipoCertificado" value="{{certificado.IdTipoCertificado}}"> {{certificado.Certificado}} 
                    </div>
                </div>
            </div>

            <div class="col-md-2 listaSerie" style="overflow-y: scroll; width:280px; height:160px; left:20px;">
                <div class="input-group">
                    <span><strong>Tratamientos Termicos:</strong></span>
                    <br>
                    <div ng-repeat="certificado in tiposcerty" ng-if="certificado.TipoCert == 2" class="listaCertificados">
                        <input type="checkbox" name="Certificados[]" ng-model="IdTipoCertificado" value="{{certificado.IdTipoCertificado}}"> {{certificado.Certificado}} 
                    </div>
                </div>
            </div>-->
        </div>

        <div class="row margin-top"> <hr/>
            <div class="col-md-2" ng-show="IdTipoCertificado != 10 && IdTipoCertificado != null">
                <div class="input-group">
                    <span class="input-group-addon">Inspecciono</span>
                    <select class="form-control input-sm" ng-model="Inspecciono" required>
                        <option ng-selected="" value="{{empleado.IdEmpleado}}-{{empleado.Nombre}}-{{empleado.ApellidoPaterno}}-{{empleado.ApellidoMaterno}}" ng-repeat="empleado in empleados">{{empleado.Nombre}} {{empleado.ApellidoPaterno}}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2" ng-show="IdTipoCertificado == 10 || Inspecciono != null ">
                <div class="input-group">
                    <span class="input-group-addon">Realizo</span>
                    <select class="form-control input-sm" ng-model="Realizo" required>
                        <option ng-selected="" value="{{empleado.IdEmpleado}}-{{empleado.Nombre}}-{{empleado.ApellidoPaterno}}-{{empleado.ApellidoMaterno}}" ng-repeat="empleado in empleados" >{{empleado.Nombre}} {{empleado.ApellidoPaterno}}</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon">Aprob&oacute;</span>
                    <select class="form-control input-sm" ng-model="Aprobo" required>
                        <option ng-selected="" value="{{empleado.IdEmpleado}}-{{empleado.Nombre}}-{{empleado.ApellidoPaterno}}-{{empleado.ApellidoMaterno}}" ng-repeat="empleado in empleados" >{{empleado.Nombre}} {{empleado.ApellidoPaterno}}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" style="left: 50%;" ><hr/>
            <div class="col-md-6 right">
                <button ng-show="IdTipoCertificado == 10" class="btn btn-primary" data-dismiss="modal" ng-click="loadUrl(1);" class="btn btn-default">Generar PDF</button>
                <button ng-show="IdTipoCertificado != 10" class="btn btn-primary" data-dismiss="modal" ng-click="loadUrl(2);" class="btn btn-default">Generar PDF</button>
                <button class="btn btn-success" data-dismiss="modal" ng-click="SaveCertificado();" class="btn btn-default">Guardar Datos</button>
            </div>
        </div>

        <modal title="Certificado" visible="showModal" style="width: 2000px" >
            <h3></h3>
            <div style="height: 500px;">
                <div class="row"> 
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Tipo Certificado:</span>
                            <select class="form-control input-sm" ng-change="TipoCerty()" ng-model="IdTipoCertificado" required>
                                <option value="{{certificad.IdTipoCertificado}}" ng-repeat="certificad in tiposcerty">{{certificad.Certificado}}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="float:left; width:30%;">
                   <table>
                       <thead>
                           <th>  </th>
                       </thead>
                   </table>
                </div>
                
            </div>
        </modal>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" style="width: 70%" >
                <div class="modal-content">
                  <h3></h3>
                    <div style="height: 500px;">
                        <div class="row"> 
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Tipo Certificado:</span>
                                    <select class="form-control input-sm" ng-change="TipoCerty()" ng-model="IdTipoCertificado" required>
                                        <option value="{{certificad.IdTipoCertificado}}" ng-repeat="certificad in tiposcerty">{{certificad.Certificado}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="float:left; width:30%;">
                           <table>
                               <thead>
                                   <th>  </th>
                               </thead>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
