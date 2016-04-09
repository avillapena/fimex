<div ng-controller="Pruebas" ng-init="load('data-camisas',{semana:semanaActual,IdArea:<?=$IdArea;?>})"></div>
<b style="font-size: 14pt;"></b><input type="week" ng-model="semanaActual" /><button class="btn" ng-click="load('data-camisas',{semana:semanaActual,IdArea:<?=$IdArea;?>})">Ver</button>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th rowspan="2">Codigo Dux</th>
            <th rowspan="2">Marca</th>
            <th rowspan="2">Tamaño</th>
            <th rowspan="2">Total</th>
            <th rowspan="2">Cantidad por paquete</th>
            <th rowspan="2">Pzas. Por pedir</th>
            <th rowspan="2">Paq. Por pedir</th>
            <th colspan="2">Existencia</th>
            <th colspan="6">Semanas</th>
        </tr>
        <tr>
            <th>Pesos</th>
            <th>Dolares</th>
            <th ng-repeat="semana in data[0].semanas">{{semana.semana}}</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="dat in data" data-ng-click="dat.selected = !dat.selected" ng-class="{'info':dat.selected == true}">
            <td>{{dat.DUX_CodigoDolares}}</td>
            <td>{{dat.Descripcion}}</td>
            <td>{{dat.Tamano}}</td>
            <td>{{dat.total}}</td>
            <td>{{dat.CantidadPorPaquete}}</td>
            <td>{{(dat.total - dat.ExistenciaPesos - dat.ExistenciaDolares) | currency:"":0}}</td>
            <td>{{((dat.total - dat.ExistenciaPesos - dat.ExistenciaDolares) / dat.CantidadPorPaquete) | currency:"":2}}</td>
            <td>{{dat.ExistenciaPesos}}</td>
            <td>{{dat.ExistenciaDolares}}</td>
            <td ng-repeat="semana in dat.semanas">{{semana.Requeridas}}</td>
        </tr>
    </tbody>
</table>