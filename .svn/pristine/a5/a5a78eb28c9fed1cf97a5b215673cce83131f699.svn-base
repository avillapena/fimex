<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-click="addInventario();">Agregar Produccion</button>
    </div>
    <div id="detalle" class="scrollable" >
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Fecha Moldeo</th>
                    <th>Subproceso</th>
                    <th>Centro Trabajo</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Existencias</th>
                    <th>Observaciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="inv in inventario.inventarioMovimientos">
                    <td class="col-md-2">
                        <select class="form-control" ng-model="inv.IdProducto" ng-change="revisaExistencia($index)">
                            <option ng-selected="producto.IdProducto == inv.IdProducto" ng-repeat="producto in productos" value="{{producto.IdProducto}}">   
                                {{producto.Identificacion}}
                            </option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" type="text" ng-model="inv.FechaMoldeo" ng-show="!inv.FechaMoldeo" readonly="true">
                        <select ng-show="inv.fmoldeo" class="form-control" ng-model="inv.FechaMoldeo" ng-change="revisaExistencia($index)">
                            <option value="{{fmolde.FechaMoldeo}}" ng-repeat="fmolde in inv.fechasMoldeo">{{fmolde.FechaMoldeo}}</option>
                        </select>
                    </td>
                    <td class="col-md-2">
                        <select class="form-control" ng-model="inv.IdSubProceso">
                            <option ng-selected="subproceso.IdSubProceso == inv.IdSubProceso" value="{{subproceso.IdSubProceso}}" ng-repeat="subproceso in SubProcesos">{{subproceso.Descripcion}}</option>
                        </select>
                    </td>
                    <td class="col-md-2">
                        <select class="form-control" ng-model="inv.IdCentroTrabajo" ng-change="revisaExistencia($index)">
                            <option ng-selected="centro.IdCentroTrabajo == inv.IdCentroTrabajo" value="{{centroSalida.IdCentroTrabajo}}" ng-repeat="centro in centros">{{centro.Descripcion}}</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" ng-model="inv.Tipo" ng-change="revisaExistencia($index)">
                            <option ng-selected="'E' == inv.Tipo" value="E" >Entrada</option>
                            <option ng-selected="'S' == inv.Tipo" value="S" >Salida</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" type="text" ng-model="inv.Cantidad">
                    </td>
                    <td><input class="form-control" type="text" ng-model="inv.Existencia" readonly="true"></td>
                    <td><input class="form-control" type="text" ng-model="inv.Observaciones" readonly="true"></td>
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveInventario($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>