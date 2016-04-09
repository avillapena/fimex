<div class="panel panel-primary" ng-controller="Inventarios" ng-init="IdArea = <?=$IdArea;?>;filtro=[];loadAleacionTipo();loadSubProcesos();loadCentrosTrabajo();loadCentro();">
    <!-- Default panel contents -->
    <div class="panel-heading">Rutas para Transferencias</div>
    <div class="panel-body">
    </div>
    <div id="detalle" class="scrollable" >
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th>Proceso</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Tipo Aleacion</th>
                    <th></th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-model="filtro.SubProceso" /></th>
                    <th><input class="form-control" ng-model="filtro.Origen" /></th>
                    <th><input class="form-control" ng-model="filtro.Destino" /></th>
                    <th><input class="form-control" ng-model="filtro.AleacionTipo" /></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="rutas in centrosDestino | filter:filtro">
                    <td><select ng-model="rutas.IdSubProceso" class="form-control">
                            <option ng-repeat="SubProceso in SubProcesos" ng-selected="rutas.IdSubProceso == SubProceso.IdSubProceso" value="{{SubProceso.IdSubProceso}}">{{SubProceso.Descripcion}}</option>
                        </select>
                    </td>
                    <td><select ng-model="rutas.IdCentroTrabajoOrigen" class="form-control">
                            <option ng-repeat="centro in centros" ng-selected="rutas.IdCentroTrabajoOrigen == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}">{{centro.Descripcion}}</option>
                        </select>
                    </td>
                    <td><select ng-model="rutas.IdCentroTrabajoDestino" class="form-control">
                            <option ng-repeat="centro in centros" ng-selected="rutas.IdCentroTrabajoDestino == centro.IdCentroTrabajo" value="{{centro.IdCentroTrabajo}}">{{centro.Descripcion}}</option>
                        </select>
                    </td>
                    <td><select ng-model="rutas.IdAleacionTipo" class="form-control">
                            <option ng-repeat="AleacionTipo in AleacionesTipo" ng-selected="rutas.IdAleacionTipo == AleacionTipo.IdAleacionTipo" value="{{AleacionTipo.IdAleacionTipo}}">{{AleacionTipo.Descripcion}}</option>
                        </select>
                    </td>
                    <td>
                        <btn-save ng-click="saveRuta($index)"></btn-save>
                        <btn-delete ng-click="deleteRuta($index)"></btn-delete>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>