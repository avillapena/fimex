
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Detalle de Capturas</div>
    <div class="contenido" ng-model="materiales">
        <div class="panel-body">
             <button class="btn btn-success" ng-show="mostrar" ng-click="addCapturas(2)">Agregar Captura</button>
        </div>
        <div id="Temperaturas" class="scrollable">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>No. Parte</th>
                        <th>Fecha Colada</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="captura in capturados" 
                        ng-init="captura.btnCaptura = true;
                            ">
    					<th>
                            {{captura.producto}}
                            <!-- <input  class="form-control input-sm" type="text" ng-show="!(captura.IdProducto == '')" ng-value="captura.IdMaterialTipo"  ng-model="captura.IdMaterialTipo"> -->
                        </th>
                        <th>
                            {{captura.FechaColada}}
                        </th>
                        <th>
                            <!-- <input class="form-control input-sm" type="text" ng-show="!(captura.IdProducto == '')" ng-value="captura.Tipo"  ng-model="captura.Tipo"> -->
                            <select class="form-control" ng-model="captura.tipo"  required>
                                <option  ng-repeat="tc in tipoCalidad" ng-selected="captura.tipo == tc.valor" value=" {{tc.valor}}"> {{tc.descripcion}}</option>
                               
                            </select>
                        </th>
                        <th>
                            <input class="form-control input-sm"  type="text" ng-model="captura.Cantidad" ng-value="captura.Cantidad" />
                        </th>                    
                        <th>
                            <button 
                                
                                class="btn btn-info btn-xs" 
                                ng-click="calidadSeries($index);loadCalidadSeries()" >
                                <span aria-hidden="true">Serie</span>
                            </button>
                            <button 
                                
                                class="btn btn-success btn-xs" 
                                ng-click="saveDetalleCalidad($index);" 
                               >
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                            </button>
                            <button ng-show="role == 1" class="btn btn-danger btn-xs" ng-click="deleteUsados($index)">
                                <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                            <button 
                                ng-show="captura.IdEstatus != 1 && captura.IdEstatus != ''"
                                class="btn btn-success btn-xs" 
                                ng-click="showEvidencias($index);calidadSeries($index);calidadSeries2($index)" >
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

 