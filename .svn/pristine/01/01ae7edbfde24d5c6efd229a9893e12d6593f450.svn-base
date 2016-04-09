<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Captura de Calidad</div>
    <div id="detalle" class="contenido">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>No. Parte</th>
                <th>Fecha Colada</th>
                <th>Exist. Piezas</th>
                <th>Rev</th>
                <th>Acep</th>
                <th>Rep</th>
                <th>SCRAP</th>
            </tr>
            <tr ng-class="{'info': indexDetalle == $index}" ng-repeat="detalle in productosCalidad">
                <th>{{detalle.Id}}</th>
                <th>{{detalle.Identificacion}} 
                    <input type="hidden" ng-model="llevaSerie" ng-value="llevaSerie = detalle.LlevaSerie == 'Si' ? true : false">
                </th>
                <th>
                    {{detalle.FechaMoldeo || 'N/A'}}
                </th>
                <th>{{detalle.ExistenciaFechaMoldeo || detalle.Existencia}}</th>
                <th>
                    {{(detalle.Aceptadas*1) + (detalle.Reparaciones*1) + (detalle.Scrap*1)}}
                </th>
                <th>{{detalle.Aceptadas}}</th>
                <th>{{detalle.Reparaciones}}</th>
                <th>{{detalle.Scrap}}</th>

                <!--Captura de aceptadas-->
                <!--
                <th>
                    <div ng-click="ModelCapturaA($index, llevaSerie);">
                        <input type="text" ng-model="detalle.Aceptadas" ng-click="" ng-disabled="llevaSerie" ng-blur="sumarTotal($index);saveDetalleCalidad(1);" ng-value="detalle.Reparaciones">
                    </div>
                </th>
                -->
                <!--Captura de Reparaciones-->
                <!--
                <th>
                    <input type="text" ng-model="detalle.Reparaciones" ng-blur="sumarTotal($index);ModelCapturaR($index,1);saveDetalleCalidad(2);" ng-value="detalle.Reparaciones || 0">
                </th>
                -->
                <!--Captura de SCRAP-->
                <!--
                <th>
                    <input type="text" ng-model="detalle.Scrap" ng-blur="sumarTotal($index);ModelCapturaR($index,2);saveDetalleCalidad(3);" ng-value="detalle.Scrap || 0">
                </th>
                -->
            </tr>
        </table>
    </div>
</div>