<div class="panel panel-primary" ng-if="produccion.idMaquina.Descripcion == 'Soldadura'">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de Soldadura</div>
    <div class="panel-body">
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-md-1"></th>
                    <th>Tipo Soldadura</th>
                    <th class="col-md-1">Consumo Soldadura</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-md-1"><btn-plus ng-click="addConsumo(cons);saveConsumo(consumos.length -1 )"></btn-plus></td>
                    <td><select ng-model="cons.IdMaterial" class="form-control">
                            <option ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                    </select>{{cons.IdMaterial}}</td>
                    <td><input type="number" ng-model="cons.Cantidad" class="form-control" /></td>
                </tr>
                <tr 
                    ng-class="{'warning': detalle.change == true}"
                    ng-repeat="c in consumos"
                >
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    <btn-minus ng-click="deleteConsumo($index)"></btn-minus>
                                    <select class="form-control" ng-model="c.IdMaterial" ng-change="saveConsumo($index)">
                                        <option ng-selected="c.IdMaterial == material.IdMaterial" ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                                    </select>
                                </td>
                                <td class="col-md-1"><input ng-model="c.Cantidad" class="form-control" ng-change="saveConsumo($index)" ng-model-options="{updateOn: 'blur'}" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>