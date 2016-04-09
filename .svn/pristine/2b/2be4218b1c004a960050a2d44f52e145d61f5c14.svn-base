<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Carga de Probetas  </div>
    <div class="panel-body">
        <button class="btn btn-success" ng-disabled="!isNow" ng-show="mostrar" ng-click="addProbetaDetalleVaciado()">Agregar </button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-md-4">Cantidad</th>
                    <th class="col-md-4">Tipo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="probetadetalle in probetadetalles">
                                     <!-- TIPO C {{probetadetalles.TipoC}} TIPO D {{probetadetalles.TipoD}} TIPO T {{probetadetalles.TipoT}} -->
                                    
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}"  ng-model="probetadetalle.Cantidad" value="{{probetadetalle.Cantidad}}"/></td>
                    <td class="captura">
                    <select ng-model="probetadetalle.Tipo" ng-disabled="!isNow" aria-describedby="Colada" class="form-control"  required>
                        <option ng-selected = "probetadetalle.Tipo == tp.idTipoProbeta" value="{{tp.idTipoProbeta}}" ng-repeat="tp in tipoProbeta " > {{tp.Descripcion}} </option> 
                    </select>
                    </td>
                    
					
                    <td>
                        <button class="btn btn-success btn-xs" ng-disabled="!isNow" ng-click="saveProbetaDetallevaciado($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button class="btn btn-danger btn-xs" ng-disabled="!isNow" ng-click="deleteProbetaDetallevaciado($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>