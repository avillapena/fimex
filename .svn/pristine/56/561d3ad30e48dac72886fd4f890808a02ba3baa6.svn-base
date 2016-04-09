<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Por Retrabajo</div>
    <div class="panel-body">
    </div>
    <div id="existencia" class="scrollable">
        <table ng-table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Fecha Moldeo</th>
                    <th>Tipo</th>
                    <th rowspan="2">Aleacion</th>
                    <th rowspan="2">Existencia</th>
                    <th rowspan="2"></th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-model="filtro2.Producto"></th>
                    <th><input class="form-control" ng-model="filtro2.FechaMoldeo"></th>
                    <th><input class="form-control" ng-model="filtro2.Defecto"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index}"
                    ng-repeat="retrabajo in retrabajos | filter:filtro2"
                    ng-click="selectProgramacion($index);"
                >
                    <th>{{retrabajo.Identificacion}}</th>
                    <th>{{retrabajo.FechaMoldeo || 'N/A'}}</th>
                    <th>{{retrabajo.Descripcion}}</th>
                    <th>{{retrabajo.Aleacion}}</th>
                    <th>{{retrabajo.ExistenciaFechaMoldeo || retrabajo.Existencia}}</th>
                    <th><button class="btn btn-primary" ng-disabled="produccion.IdProduccion === undefined" ng-click="retrabajo.IdCentroTrabajo == 53 ? retrabajo.IdEstatus = 2 : retrabajo.IdEstatus = 3;addDetalle(retrabajo)">Agregar</button></th>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="13">&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>