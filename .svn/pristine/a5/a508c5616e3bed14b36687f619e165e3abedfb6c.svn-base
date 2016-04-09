
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materiales Usados</div>
    <div class="contenido" ng-model="materiales">
        <div class="panel-body">
             <button class="btn btn-success" ng-show="mostrar" ng-click="addMatUsado()">Agregar Material</button>
        </div>
        <div id="Temperaturas" class="scrollable">
            <table class="table table-condensed">
                <thead >
                    <tr>
                        <th>Clase</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Lote</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="consumo in consumibles">
    					<th>
                            <select class="form-control" ng-model-options="{updateOn: 'blur'}" ng-disabled="false" ng-model="clase.IdMaterialTipo">
                                <option ng-repeat="clase in materialesP" ng-selected="clase.IdMaterialTipo == clase.IdMaterial" value="{{clase.IdMaterialTipo}}">{{clase.Descripcion}}</option>
                            </select>
                        </th>
                        <th>
                            <select class="form-control" ng-model="RemMar" required>
                                <option ng-show="marcaREM.Identificador == 'MARCA' " value="{{marcaREM.IdMaterial}}" ng-repeat="marcaREM in materiales">{{marcaREM.IdMaterial}} - {{marcaREM.Nombre}}</option>
                            </select>  
                        </th>
                        <th>
                            <select class="form-control" ng-model="RemTip" required>
                                <option ng-show="marcaREM.Identificador == 'TIPO' " value="{{marcaREM.IdMaterial}}" ng-repeat="marcaREM in materiales">{{marcaREM.IdMaterial}} - {{marcaREM.Nombre}}</option>
                            </select>
                        </th>
                        <th><input class="form-control input-sm" type="text" ng-model="LoteRevelador" /></th>
                        <th>
                            <button class="btn btn-success btn-xs" ng-click="saveUsados($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                            <button class="btn btn-danger btn-xs" ng-click="deleteUsados($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>