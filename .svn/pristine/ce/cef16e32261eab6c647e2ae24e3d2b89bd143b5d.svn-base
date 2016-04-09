<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Series</div>
    <div class="panel-body">
    </div>
    <div id="series" class="scrollable">
        <table fixed-table-headers="series" ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <td>
                        <select class="form-control" ng-model="IdSerie">
                            <option ng-repeat="serie in listadoseries" value="{{serie.IdSerie}}" ng-selected="IdSerie == serie.IdSerie" >{{serie.Serie}}</option>
                        </select>
                    </td>
                    <td  ><btn-plus  ng-click="SaveCalidadSerie(IdSerie);"></btn-plus></td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="serie in seriesDetalle">
                    <td>{{serie.Serie}}</td>
                    <td><btn-minus ng-click="DeleteCalidadSerie(serie.IdSeriesDetalles);"></btn-minus></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>