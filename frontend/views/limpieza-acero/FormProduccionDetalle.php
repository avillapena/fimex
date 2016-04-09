<div class="panel panel-<?= $tipo == 1 ? 'primary' : 'danger'?>">
    <!-- Default panel contents -->
    <div class="panel-heading"><?=$titulo?></div>
    <div class="panel-body"></div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th ng-if="produccion.idMaquina.Descripcion == 'Soldadura'">Soldadura Utilizada</th>
                    <th>Producto</th>
                    <th>Fecha Moldeo</th>
                    <?php if($tipo == 1):?>
                    <th class="col-md-2">Inicio</th>
                    <th class="col-md-2">Fin</th>
                    <?php endif;?>
                    <?php if($tipo == 2 || $tipo == 3):?><th class="col-md-3">Defecto</th><?php endif;?>
                    <th class="col-md-1">Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="detalle in produccion.produccionesDetalles"
                    ng-init="Eficiencia($index)"
                    ng-if="<?= $tipo == 1 ? "detalle.IdEstatus == 1" : "detalle.IdEstatus == 2 || detalle.IdEstatus == 3"?>"
                >
                    <td class="col-md-4" ng-if="produccion.idMaquina.Descripcion == 'Soldadura'">{{detalle.Soldadura.IdMaterialVaciado}}
                        <select class="form-control" ng-model="detalle.soldadura.IdMaterialVaciado" ng-change="saveDetalleConsumo(detalle.IdProduccionDetalle,detalle.soldadura.IdMaterialVaciado,$index)">
                            <option ng-selected="detalle.soldadura.IdMaterialVaciado == c.IdMaterialVaciado" ng-repeat="c in produccion.materialesVaciados" value="{{c.IdMaterialVaciado}}">{{c.idMaterial.Descripcion}} | {{c.Cantidad}} Kg</option>
                        </select>
                    </td>
                    <td class="col-md-3">{{detalle.idProductos.Identificacion}}</td>
                    <td ng-if="IdArea == 2">{{detalle.FechaMoldeo || 'N/A'}}</td>
                    
                    <td class="captura" ng-if="detalle.IdEstatus == 1"><input class="form-control" type="time" ng-change="detalle.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Inicio" ng-focus="selectDetalle($index)" ng-model="detalle.Inicio"/></td>
                    <td class="captura" ng-if="detalle.IdEstatus == 1"><input class="form-control" type="time" ng-change="detalle.change = true" ng-model-options="{updateOn: 'blur'}" placeholder="Fin" ng-focus="selectDetalle($index)" ng-model="detalle.Fin"/></td>
                    <td class="captura" ng-if="detalle.IdEstatus == 2 || detalle.IdEstatus == 3">
                        <select class="form-control" ng-model="detalle.produccionesDefectos[0].IdDefectoTipo">
                            <option ng-repeat="defecto in defectos" ng-selected="detalle.produccionesDefectos[0].IdDefectoTipo === defecto.IdDefectoTipo" value="{{defecto.IdDefectoTipo}}">{{defecto.Tipo}} - {{defecto.NombreTipo}}</option>
                        </select>
                    </td>
                    <td class="captura">
                        <input class="form-control" ng-change="detalle.change = true" ng-if="detalle.IdEstatus == 1" ng-model-options="{updateOn: 'blur'}" placeholder="OK" ng-model="detalle.Hechas"/>
                        <input class="form-control" ng-if="detalle.IdEstatus == 2 || detalle.IdEstatus == 3" ng-model-options="{updateOn: 'blur'}" ng-model="detalle.produccionesDefectos[0].Rechazadas"/>
                    </td>
                    <td>
                        <btn-save ng-click="saveRechazo($index);" ng-if="detalle.IdEstatus == 2 || detalle.IdEstatus == 3"></btn-save>
                        <btn-save ng-click="saveDetalle($index);" ng-if="detalle.IdEstatus == 1"></btn-save>
                        <btn-delete ng-if="detalle.IdProduccionDetalle != null && detalle.IdEstatus == 2 || detalle.IdEstatus == 3" ng-click="deleteRetrabajo($index);"></btn-delete>
                        <btn-delete ng-if="detalle.IdProduccionDetalle != null && detalle.IdEstatus == 1" ng-click="deleteDetalle($index);"></btn-delete>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>