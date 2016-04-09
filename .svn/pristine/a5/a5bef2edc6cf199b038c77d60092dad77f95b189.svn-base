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
    <div class="panel-heading">Programacion del dia</div>
    <div class="panel-body">
    </div>
    <div id="existencia" class="scrollable">
        <table ng-table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Pr</th>
                    <th>Producto</th>
                    <th>Aleacion</th>
                    <th rowspan="2">Prog</th>
                    <th rowspan="2"></th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-model="filtro.Producto"></th>
                    <th><input class="form-control" ng-model="filtro.Aleacion"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index}"
                    ng-repeat="programacion in programaciones | filter:filtro"
                    ng-click="selectProgramacion($index);"
                >
                    <th>{{programacion.Prioridad}}</th>
                    <th>{{programacion.Producto}}</th>
                    <th>{{programacion.Aleacion}}</th>
                    <th>{{programacion.Programadas}}</th>
                    <th><button class="btn btn-primary" ng-disabled="produccion.IdProduccion === undefined" ng-click="programacion.IdEstatus = 1;addDetalle(programacion)">Agregar</button></th>
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
