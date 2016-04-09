<div class="col-md-4"><div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Almacen salida</div>
    <div class="panel-body">
        <select class="form-control" ng-disabled="inventario.inventarioTransferencias.length > 0" ng-model="inventario.IdCentroTrabajo" ng-change="updateInventario();loadExistencias()">
            <option
                ng-selected="{{inventario.IdCentroTrabajo == centroSalida.IdCentroTrabajo}}"
                value="{{centroSalida.IdCentroTrabajoOrigen}}"
                ng-repeat="centroSalida in centrosOrigen | filter:{IdSubProceso:inventario.IdSubProceso}"
            >{{centroSalida.Origen}}</option>
        </select>
    </div>
    <div id="existencias" class="scrollable">
        <table fixed-table-headers="existencias" ng-table class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th>Producto</th>
                    <th>Fecha Moldeo</th>
                    <th rowspan="2">Existencias</th>
                    <th rowspan="2">Disponible</th>
                    <th rowspan="2">Serie</th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-model="filtro.Identificacion"></th>
                    <th><input class="form-control" ng-model="filtro.FechaMoldeo"></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="Existencia in Existencias | filter:filtro"
                    data-ng-click="Existencia.selected = !Existencia.selected"
                    ng-class="{'info':Existencia.selected == true}"
                    ng-if="Existencia.ExistenciaFechaMoldeo > 0 || Existencia.Existencia > 0"
                >
                    <td><button ng-disabled="inventario.IdEstatusInventario == 3 || inventario.IdInventario == undefined" ng-click="addMovimiento(true,Existencia);" class="btn btn-success">Agregar</button></td>
                    <td>{{Existencia.Identificacion}}</td>
                    <td>{{Existencia.FechaMoldeo || 'N/A'}}</td>
                    <td>{{Existencia.ExistenciaFechaMoldeo || Existencia.Existencia}}</td>
                    <td>{{Existencia.HechoFechaMoldeo || Existencia.Hecho}}</td>
                    <td>{{Existencia.LlevaSerie}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div></div>
<div class="col-md-6"><div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Transferencias (Click sobre la linea para ver las series)</div>
    <div class="panel-body">
    </div>
    <div id="detalle" class="scrollable">
        <table fixed-table-headers="detalle" ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Almacen Salida</th>
                    <th>Producto</th>
                    <th>Fecha Moldeo</th>
                    <th>Lleva Serie</th>
                    <th>Almacen Entrada</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="inv in inventario.inventarioTransferencias" ng-click="getSeries($index);" ng-class="{info:indexInventario==$index}">
                    <td class="col-md-3">{{inv.idInventarioMovimientoSalida.idSubProceso.Descripcion}} - {{inv.idInventarioMovimientoSalida.idCentroTrabajo.Descripcion}}</td>
                    <td class="col-md-3">{{inv.idInventarioMovimientoSalida.idProducto.Identificacion}}</td>
                    <td class="col-md-2">{{inv.idInventarioMovimientoSalida.FechaMoldeo || 'N/A'}}</td>
                    <td>{{inv.idInventarioMovimientoSalida.idProducto.LlevaSerie}}</td>
                    <td class="col-md-3"><span ng-if="inventario.IdEstatusInventario == 3">{{inv.idInventarioMovimientoEntrada.idSubProceso.Descripcion}} - {{inv.idInventarioMovimientoEntrada.idCentroTrabajo.Descripcion}}</span>
                        <select class="form-control" ng-if="inventario.IdEstatusInventario != 3" ng-model="inv.idInventarioMovimientoEntrada.IdCentroTrabajo" ng-change="inv.idInventarioMovimientoEntrada.IdSubProceso = buscarSubproceso(centrosDestino,'IdCentroTrabajoDestino','IdSubProcesoDestino',inv.idInventarioMovimientoEntrada.IdCentroTrabajo);">
                            <option
                                ng-selected="{{inv.idInventarioMovimientoEntrada.IdCentroTrabajo === centroEntrada.IdCentroTrabajo}}"
                                value="{{centroEntrada.IdCentroTrabajoDestino}}" 
                                ng-repeat="centroEntrada in centrosDestino | filter:{
                                    IdCentroTrabajoOrigen: inv.idInventarioMovimientoSalida.IdCentroTrabajo,
                                    IdAleacionTipo: inv.idInventarioMovimientoSalida.idProducto.idAleacion.IdAleacionTipo
                                }:true"
                            >{{centroEntrada.Destino}}</option>
                        </select>
                    </td>
                    <td class="col-md-1"><span ng-if="inventario.IdEstatusInventario == 3">{{inv.idInventarioMovimientoEntrada.Cantidad}}</span>
                        <input class="form-control" ng-if="inventario.IdEstatusInventario != 3" ng-disabled="inv.idInventarioMovimientoEntrada.idProducto.LlevaSerie == 'Si'" type="text" ng-model="inv.idInventarioMovimientoEntrada.Cantidad">
                    </td>
                    <td>
                        <btn-save ng-if="inventario.IdEstatusInventario != 3" ng-click="saveMovimiento($index)"></btn-save>
                        <btn-delete ng-if="inventario.IdEstatusInventario != 3" ng-click="deleteMovimiento($index)"></btn-delete>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div></div>
<div class="col-md-2">
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Series</div>
    <div class="panel-body">
    </div>
    <div id="series" class="scrollable">
        <table fixed-table-headers="series" ng-table class="table table-condensed table-striped table-bordered">
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
                    <td><btn-minus ng-if="inventario.IdEstatusInventario != 3" ng-click="deleteSerie(serie.IdSerie);"></btn-minus></td>
                </tr>
            </tbody>
        </table>
    </div>
</div></div>