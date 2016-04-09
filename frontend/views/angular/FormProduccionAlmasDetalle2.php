<div class="panel panel-primary">
    <!-- Default panel contents -->
	
    <div class="panel-heading">Captura de produccion almas (pintado)</div>
	
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addAlmasDetalle2()">Agregar Produccion</button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width 200px">Alma</th>
                    <th class="col-md-2">Inicio</th>
                    <th class="col-md-2">Fin</th>
                    <th class="col-md-2">OK</th>
                    <th class="col-md-1">Rech</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': alma.change == true}"
                    ng-mousedown="selectDetalle($index);"
                    ng-repeat="alma in detalles">
                    <!--<td class="col-md-3">{{alma.idProducto.Identificacion}}/{{alma.idAlmaTipo.Descripcion}}</td>-->
                    <td tyle="width 200px">
                        <select id="alma" aria-describedby="Almas" class="form-control input-sm" ng-change="datosAlmas(IdProducto);" ng-model="IdProducto" required>
                            <option ng-selected="alma.idProducto.IdProducto == programaciones.IdProducto" value="{{programaciones.IdProducto}}" ng-repeat="programaciones in programacionalmas">{{programaciones.Producto}} / {{programaciones.Alma}}</option>
                        </select>
                    </td>
                    <td class="captura"><input ng-change="alma.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Inicio" ng-focus="selectAlmasDetalle($index)" ng-model="alma.Inicio" value="{{alma.Inicio | date:'HH:mm'}}"/></td>
                    <td class="captura"><input ng-change="alma.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Fin" ng-focus="selectAlmasDetalle($index)" ng-model="alma.Fin" value="{{alma.Fin | date:'HH:mm'}}"/></td>
                    <td class="captura"><input ng-change="alma.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="OK" ng-model="alma.Hechas" value="{{alma.Hechas}}"/></td>
                    <td class="captura">{{alma.Rechazadas}}</td>
                    <td class="col-md-2">
                        <button class="btn btn-success btn-xs" ng-click="saveAlmasDetalle2($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs" ng-click="deleteAlmasDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>