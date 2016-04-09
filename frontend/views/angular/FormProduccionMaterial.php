<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-show="mostrar" ng-click="addConsumo()">Agregar Material</button>
    </div>
    <table class="table table-condensed">
        <thead >
            <tr>
                <th>Material</th>
                <th>Cantidad</th>
                <th ng-if="IdSubProceso == 12">Unidad</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="consumo in consumos">
                <th><select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-disabled="consumo.IdMaterialVaciado" ng-change="saveConsumo($index)" ng-model="consumo.IdMaterial">
                        <option ng-selected="consumo.IdMaterial == material.IdMaterial" ng-repeat="material in materiales" value="{{material.IdMaterial}}">{{material.Descripcion}}</option>
                </select></th>
                <th><input class="form-control" type="text" ng-model-options="{updateOn: 'blur'}" ng-change="saveConsumo($index)" ng-model="consumo.Cantidad" value="{{consumo.Cantidad | currency:'':'2'}}"/></th>
                <th ng-if="IdSubProceso == 12">KG</th>
            </tr>
        </tbody>
    </table>
</div>