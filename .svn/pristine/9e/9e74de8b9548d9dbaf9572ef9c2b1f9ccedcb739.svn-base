<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Detalle Resumen</div>
    <div id="detalle" class="contenido">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <tr>
                <th>No. Parte</th>
                <th>Inspeccionadas</th>
                <th>Aceptadas</th>
                <th>Reparaciones</th>
                <th>Scrap</th>
            </tr>
            <tr 
           
                ng-repeat="resumen in resumenes">
                <th>{{resumen.Producto}} 
                    <input type="hidden" ng-model="llevaSerie" ng-value="llevaSerie = detalle.LlevaSerie == 'Si' ? true : false">
                </th>
                <th>{{(resumen.Aceptadas*1) + (resumen.Reparaciones*1) + (resumen.Scrap*1)}}</th>
                <th>{{resumen.Aceptadas*1}}</th>
                <th>{{resumen.Reparaciones}}</th>
                <th>{{resumen.Scrap}}</th>
            </tr>
        </table>
    </div>
</div>