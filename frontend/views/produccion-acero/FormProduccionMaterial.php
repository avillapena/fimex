
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materia Prima Utilizada</div>
    <div class="panel-body">
         <button class="btn btn-success"  ng-disabled="!isNow;" ng-show="mostrar" ng-click="addConsumo()">Agregar Material</button>
    </div>
    <div id="Temperaturas" class="scrollable">
        <table class="table table-condensed">
            <thead >
                <tr>
                    <th>Tipo</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="consumo in consumos">
					<th>{{consumo.idMaterial.idMaterialTipo.Descripcion}}</th>
                    <th><select class="form-control" ng-disabled="!isNow;" ng-model-options="{updateOn: 'blur'}" ng-disabled="false" ng-model="consumo.IdMaterial">
                            <optgroup ng-repeat="material in materiales" label="{{material.Descripcion}}">
                                <option ng-repeat="material2 in material.materiales" ng-selected="consumo.IdMaterial == material2.IdMaterial" value="{{material2.IdMaterial}}">{{ material2.Descripcion  + ' - '+ material.Descripcion}}</option>
                            </optgroup>
                    </select></th>
                    
                    <th><input class="form-control" ng-disabled="!isNow;" type="text" ng-model-options="{updateOn: 'blur'}" ng-model="consumo.Cantidad" value="{{consumo.Cantidad | currency:'':'2'}}"/></th>
                    <th>
                        <button class="btn btn-success btn-xs"  ng-disabled="!isNow;" ng-click="saveConsumo($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs"  ng-disabled="!isNow;" ng-click="deleteConsumo($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>