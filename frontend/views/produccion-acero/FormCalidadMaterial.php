
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Materiales Usados</div>
    <div class="contenido" ng-model="materiales">
        <div class="panel-body">
             <button class="btn btn-success" ng-show="mostrar" ng-click="addCapturas(1)">Agregar Material</button>
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
                    <tr ng-repeat="consumo in consumibles" ng-init="consumo.btnMaterial = true;">
    					<th>
                            <input  class="form-control input-sm" type="text" ng-show="!(consumo.IdMaterialesUsados == '')" ng-value="consumo.ClaseDescripcion"  ng-model="consumo.ClaseDescripcion">
                            <select ng-show="consumo.IdMaterialesUsados == ''" class="form-control" ng-model="consumo.clase" ng-change="sumarMateriales($index);loadMarcas($index);">
                                <option 
                                    ng-repeat="clas in materialesP" 
                                    value="{{clas.IdMaterialTipo}}">
                                    {{clas.Descripcion}}
                                </option>
                            </select>
                        </th>
                        <th>
                            <input  class="form-control input-sm" type="text" ng-show="!(consumo.IdMaterialesUsados == '')" ng-value="consumo.MarcaDescripcion"  ng-model="consumo.MarcaDescripcion">
                            <select ng-show="consumo.IdMaterialesUsados == ''" class="form-control" ng-model="consumo.marca" required ng-change="sumarMateriales($index)">
                                <option 
                                    ng-show="marcaREM.Identificador == 'MARCA'"
                                    value="{{marcaREM.IdMaterial}}" 
                                    ng-repeat="marcaREM in consumo.materiales">
                                    {{marcaREM.IdMaterial}} - {{marcaREM.Nombre}}
                                </option>
                            </select>  
                        </th>
                        <th>
                            <input  class="form-control input-sm" type="text" ng-show="!(consumo.IdMaterialesUsados == '')" ng-value="consumo.TipoDescripcion"  ng-model="consumo.TipoDescripcion">
                            <select ng-show="consumo.IdMaterialesUsados == ''" class="form-control" ng-model="consumo.tipo" required ng-change="sumarMateriales($index)">
                                <option 
                                    ng-show="tipoREM.Identificador == 'TIPO'"
                                    value="{{tipoREM.IdMaterial}}" 
                                    ng-repeat="tipoREM in consumo.materiales">
                                    {{tipoREM.IdMaterial}} - {{tipoREM.Nombre}}
                                </option>
                            </select>
                        </th>
                        <th>
                            <input 
                                class="form-control input-sm" 
                                type="text" 
                                ng-model="consumo.Lote"
                                ng-change="sumarMateriales($index)"/>
                        </th>
                        <th>
                            <button 
                                ng-show="consumo.btnMaterial == ''"
                                class="btn btn-success btn-xs" 
                                ng-click="saveUsados($index)"
                                ng-disabled="consumo.btnMaterial">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                            </button>
                            <button  ng-show="role == 1" class="btn btn-danger btn-xs" ng-click="deleteUsados($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>