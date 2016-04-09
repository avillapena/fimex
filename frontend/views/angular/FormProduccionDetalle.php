<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de produccion</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addDetalle()">Agregar Produccion</button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th ng-if="produccion.idMaquina.Descripcion == 'Soldadura'">Soldadura Utilizada</th>
                    <th>Producto</th>
                    <th ng-if="IdArea == 2">Fecha Moldeo</th>
                    <?php if($IdSubProceso == 6):?>
                    <th class="col-md-1">MolXHrs</th>
                    <th class="col-md-1">PzaXMol</th>
                    <?php endif?>
                    <?php if($IdSubProceso != 10 || $IdSubProceso != 12):?>
                    <th class="col-md-2">Inicio</th>
                    <th class="col-md-2">Fin</th>
                    <?php endif?>
                    <th class="col-md-1">OK</th>
                    <?php if($IdSubProceso != 10):?>
                    <th class="col-md-1">Rech</th>
                    <?php endif?>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="detalle in detalles"
                    ng-init="Eficiencia($index)"
                >
                    <td class="col-md-4" ng-if="produccion.idMaquina.Descripcion == 'Soldadura'">{{detalle.Soldadura.IdMaterialVaciado}}
                        <select class="form-control" ng-model="detalle.soldadura.IdMaterialVaciado" ng-change="saveDetalleConsumo(detalle.IdProduccionDetalle,detalle.soldadura.IdMaterialVaciado,$index)">
                            <option ng-selected="detalle.soldadura.IdMaterialVaciado == c.IdMaterialVaciado" ng-repeat="c in consumos" value="{{c.IdMaterialVaciado}}">{{c.idMaterial.Descripcion}} | {{c.Cantidad}} Kg</option>
                        </select>
                    </td>
                    <td class="col-md-3">{{detalle.idProductos.Identificacion}}</td>
                    <td ng-if="IdArea == 2">{{detalle.FechaMoldeo || 'N/A'}}</td>
                    <?php if($IdSubProceso == 6):?>
                    <td class="captura">{{detalle.CiclosMolde}}</td>
                    <td class="captura">{{detalle.PiezasMolde}}</td>
                    <?php endif?>
                    <?php if($IdSubProceso != 10 || $IdSubProceso != 12):?>
                    <td class="captura"><input ng-change="detalle.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Inicio" ng-focus="selectDetalle($index)" ng-model="detalle.Inicio" value="{{detalle.Inicio | date:'HH:mm'}}"/></td>
                    <td class="captura"><input ng-change="detalle.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Fin" ng-focus="selectDetalle($index)" ng-model="detalle.Fin" value="{{detalle.Fin | date:'HH:mm'}}"/></td>
                    <?php endif?>
                    <td class="captura"><input ng-change="detalle.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="OK" ng-model="detalle.Hechas" value="{{detalle.Hechas}}"/></td>
                    <?php if($IdSubProceso != 10):?>
                    <td class="captura">{{detalle.Rechazadas}}</td>
                    <?php endif?>
                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveDetalle($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button ng-if="detalle.IdProduccionDetalle != null" class="btn btn-danger btn-xs" ng-click="deleteDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>