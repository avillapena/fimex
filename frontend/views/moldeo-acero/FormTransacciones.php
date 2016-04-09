<div class="row">
    <div class="col-md-10">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Captura de produccion</div>
            <div class="panel-body">
                <button class="btn btn-success" ng-if="inventario.IdEstatusInventario != 3" ng-click="addMovimiento();">Agregar Produccion</button>
            </div>
            <div id="detalle" class="scrollable" >
                <table ng-table class="table table-condensed table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Fecha Moldeo</th>
                            <th>Area</th>
                            <th>Almacen</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Observaciones</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="inv in inventario.inventarioMovimientos track by inv.IdInventarioMovimiento">
                            <td>
                                <select class="form-control" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.IdProducto" ng-change="revisaExistencia($index)">
                                    <option ng-selected="producto.IdProducto == inv.IdProducto" ng-repeat="producto in productos" value="{{::producto.IdProducto}}">   
                                        {{::producto.Identificacion}}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" ng-disabled="inventario.IdEstatusInventario == 3" type="text" ng-model="inv.FechaMoldeo">
                                <select ng-show="inv.fmoldeo" class="form-control" ng-model="inv.FechaMoldeo" ng-change="revisaExistencia($index)">
                                    <option value="{{::fmolde.FechaMoldeo}}" ng-repeat="fmolde in inv.fechasMoldeo">{{::fmolde.FechaMoldeo}}</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.IdSubProceso">
                                    <option ng-selected="subproceso.IdSubProceso == inv.IdSubProceso" value="{{subproceso.IdSubProceso}}" ng-repeat="subproceso in SubProcesos">{{::subproceso.Descripcion}}</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.IdCentroTrabajo" ng-change="revisaExistencia($index)">
                                    <option ng-selected="centro.IdCentroTrabajoDestino == inv.IdCentroTrabajo" value="{{centro.IdCentroTrabajoDestino}}" ng-repeat="centro in centrosDestino | filter:{IdSubProceso: inventario.IdSubProceso}">{{::centro.Destino}}</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.Tipo" ng-change="revisaExistencia($index)">
                                    <option ng-selected="'E' == inv.Tipo" value="E" >Entrada</option>
                                    <option ng-selected="'S' == inv.Tipo" value="S" >Salida</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="text" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.Cantidad">
                            </td>
                            <td><textarea class="form-control" type="text" ng-disabled="inventario.IdEstatusInventario == 3" ng-model="inv.Observaciones"></textarea></td>
                            <td>
                                <btn-save ng-if="inventario.IdEstatusInventario != 3" ng-click="saveMovimiento($index)"></btn-save>
                                <btn-delete ng-if="inventario.IdEstatusInventario != 3" ng-click="deleteMovimiento($index)"></btn-delete>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-primary">
            <!-- Default panel contents -->
            <div class="panel-heading">Series</div>
            <div class="panel-body">
            </div>
            <div id="detalle" class="scrollable">
                <table ng-table class="table table-condensed table-striped table-bordered">
                    <thead>
                        <tr ng-if="inventario.inventarioTransferencias[indexInventario].idInventarioMovimientoEntrada.idProducto.LlevaSerie == 'Si' && inventario.IdEstatusInventario != 3">
                            <td>
                                <select class="form-control" ng-model="IdSerie">
                                    <option ng-repeat="serie in series" ng-selected="IdSerie == serie.IdSerie" ng-if="existeSerie($index)" value="{{serie.IdSerie}}">{{serie.Serie}}</option>
                                </select>
                            </td>
                            <td><btn-plus ng-click="addSerie(IdSerie);"></btn-plus></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="serie in inventario.inventarioTransferencias[indexInventario].idInventarioMovimientoEntrada.serieMovimientos">
                            <td>{{serie.idSerie.Serie}}</td>
                            <td><btn-minus ng-if="inventario.IdEstatusInventario != 3" ng-click="deleteSerie(serie.IdSerieMovimiento);"></btn-minus></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>