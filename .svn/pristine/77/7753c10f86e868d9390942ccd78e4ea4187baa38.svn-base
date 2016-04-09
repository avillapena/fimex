<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body"></div>
    <div id="material" class="scrollable">
        <table class="table table-condensed" fixed-table-headers="material">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th ng-if="IdSubProceso == 12">Unidad</th>
                </tr>
                <tr>
                    <td>
                        <select class="form-control" ng-model="IdMaterial">
                            <option ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                        </select>
                    </td>
                    <td><input class="form-control" type="text" ng-model="Cantidad"/></td>
                    <td colspan="2">
                        <btn-plus ng-disabled="produccion.IdProduccion === undefined" ng-click="addConsumo()"></btn-plus>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="consumo in produccion.materialesVaciados">
                    <td>{{consumo.idMaterial.Descripcion}}</td>
                    <td><input class="form-control" type="text"  ng-model="consumo.Cantidad" value="{{consumo.Cantidad | currency:'':'2'}}"/></td>
                    <td ng-if="IdSubProceso == 12">KG</td>
                    <td>
                        <btn-save ng-click="saveConsumo($index)"></btn-save>
                        <btn-delete ng-click="deleteConsumo($index)"></btn-delete>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>