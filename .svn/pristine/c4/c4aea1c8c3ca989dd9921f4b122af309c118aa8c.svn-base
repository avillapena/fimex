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
                    <th>Fecha Moldeo</th>
                    <th rowspan="2">Prog</th>
                    <th rowspan="2">Existencia</th>
                    <th rowspan="2"></th>
                </tr>
                <tr>
                    <th><input class="form-control" ng-model="filtro.Producto"></th>
                    <th><input class="form-control" ng-model="filtro.FechaMoldeo"></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    ng-class="{'info': indexProgramacion == $index}"
                    ng-repeat="programacion in programadosTT | filter:filtro"
                    ng-click="selectProgramacion($index);"
                    ng-if="programacion.IdCentroTrabajo == IdCentroTrabajo;"
                >
                    <th>{{programacion.Prioridad}}</th>
                    <th>{{programacion.Identificacion}}</th>
                    <th>{{programacion.FechaMoldeo || 'N/A'}}</th>
                    <th>{{programacion.Programadas}}</th>
                    <th>{{programacion.ExistenciaFechaMoldeo || programacion.Existencia}}</th>
                    <th><button class="btn" ng-click="programacion.IdEstatus = 1;addDetalle(programacion)">Agregar</button></th>
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
