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
                    <th>Almacen Salida</th>
                    <th>Almacen Entrada</th>
                    <th>Cantidad</th>
                    <th>Existencias</th>
                    <th>Hechas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="inv in productoInventarios">
                    <td class="col-md-3">
                        <select class="form-control" ng-model="inv.prods" ng-change="revisaExistencia($index)">
                            <option ng-repeat="producto in productos" value="{{producto.IdProducto}}">   
                                {{producto.IdProducto}} - {{producto.Identificacion}}
                            </option>
                        </select>
                    </td>
                    <td class="col-md-3">
                        <input class="form-control" type="text" ng-model="inv.fechaMoldeo" ng-show="!inv.fmoldeo" readonly="true">
                        <select ng-show="inv.fmoldeo" class="form-control" ng-model="inv.fechaMoldeo" ng-change="revisaExistencia($index)">
                            <option value="{{fmolde.FechaMoldeo}}" ng-repeat="fmolde in inv.fechasMoldeo">{{fmolde.FechaMoldeo}}</option>
                        </select>
                    </td>
                    <td class="col-md-3">
                        <select class="form-control" ng-model="inv.aSalida" ng-change="revisaExistencia($index)">
                            <option value="{{centroSalida.IdCentroTrabajo}}" ng-repeat="centroSalida in centros">{{centroSalida.IdCentroTrabajo}} - {{centroSalida.Descripcion}}</option>
                        </select>
                    </td>
                    <td class="col-md-3">
                        <select class="form-control" ng-model="inv.aEntrada">
                            <option value="{{centroEntrada.IdCentroTrabajo}}" ng-repeat="centroEntrada in centros">{{centroEntrada.Descripcion}}</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control" type="text" ng-model="inv.cantidad">
                    </td>
                    <td class="col-md-3"><input class="form-control" type="text" ng-model="inv.porHacer" readonly="true"></td>
                    <td class="col-md-3"><input class="form-control" type="text" ng-model="inv.hechas" readonly="true"></td>
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveInventario($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>