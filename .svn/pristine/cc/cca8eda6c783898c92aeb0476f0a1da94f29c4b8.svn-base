<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\URL;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\programacion\ProgramacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
?>
<style>
    .filter{
        width: 100px;
        height: 22px;
        font-size: 10pt;
    }
    th, td{
        text-align: center;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding: 4px;
    }
    h3{
        margin: 0;
    }
    #scrollable-area {
        margin: auto;
        height: 668px;
        border: 2px solid #ccc;
        overflow-y: scroll; /* <-- here is what is important*/
    }
    thead {
        background: white;
    }
    table {
        width: 100%;
        border-spacing:0;
        margin:0;
    }
    table th , table td  {
        border-left: 1px solid #ccc;
        border-top: 1px solid #ccc;
    }
    .success2{
        background-color: lightgreen;
    }
    .cap{
        background-color: rgb(142,187,245);
    }
    .par{
        background-color: #E6EDD7;
    }
    .impar{
        background-color: #A4D5E2;
    }
</style>
<h4 style="margin-top:0;"><?=$title?></h4>
<div ng-controller="Programacion" ng-init="filtro.Estatus = 'Abierto';TipoUsuario=<?=$TipoUsuario?>;IdArea=<?=$IdArea?>;Turno=1;IdProceso=<?=$IdProceso?>;loadDias();">
    <b style="font-size: 14pt;">Programacion Diaria: </b><input type="week" ng-model-options="{updateOn: 'blur'}" ng-model="semanaActual" ng-change="loadDias();" />
    <b style="font-size: 14pt;">Turno: </b><select ng-model="Turno" ng-change="loadDias();">
        <option ng-selected="Turno == 1" value="1">Dia</option>
        <option ng-selected="Turno == 3" value="3">Noche</option>
    </select>
    <button class="btn btn-success" ng-click="loadProgramacionDiaria();loadResumenDiario();">Actualizar</button>
    Mostrar Pedidos: <select ng-model="filtro.Estatus">
        <option value="">Todos</option>
        <option value="Abierto">Abiertos</option>
        <option value="Cerrado">Cerrados</option>
    </select>
    <div class="panel panel-default">
        <div class="panel-body">
        </div>
        <div id="opacidad" ng-show="isLoading"></div>
        <div class="animacionGiro" ng-show="isLoading"></div>
        <div id="scrollable-area">
        <table ng-table fixed-table-headers="scrollable-area" class="table table-striped table-bordered table-hover ">
            <thead>
                <tr>
                    <th rowspan="2" style="max-width: 100px; min-width: 100px;">
                        <ordenamiento title="Producto" element="Producto" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Producto" />
                    </th>
                    <th rowspan="2" style="max-width: 100px; min-width: 100px;">
                        <ordenamiento title="Casting" element="ProductoCasting" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.ProductoCasting"/>
                    </th>
                    <th ng-show="mostrar" style="max-width: 100px" rowspan="2">
                        <ordenamiento title="Aleacion" element="Aleacion" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Aleacion" />
                    </th>
                    <th rowspan="2" style="max-width: 100px; min-width: 100px;">
                        <ordenamiento title="Mold x Hrs" element="MoldesHora" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.MoldesxHora" />
                    </th>
                    <th ng-show="mostrar" rowspan="2" style="max-width: 100px; min-width: 100px;">
                        <ordenamiento title="Embarque" element="FechaEmbarque" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.FechaEmbarque" />
                    </th>
                    <th ng-show="mostrar" rowspan="2" style="max-width: 100px; min-width: 100px;">
                        <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Marca" />
                    </th>
                    <th ng-show="mostrar" rowspan="2" style="width: 33px;">
                        <ordenamiento title="Pr" element="Prioridad" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Prioridad" />
                    </th>
                    <th rowspan="2" style="width: 33px"><ordenamiento title="Mold" element="Programadas" arreglo="arr"></ordenamiento></th>
                    <th rowspan="2" style="width: 33px"><ordenamiento title="Prog" element="TotalProgramado" arreglo="arr"></ordenamiento></th>
                    <th rowspan="2" style="width: 33px" ng-show="mostrar">Falt</th>
                    <th class="cap" colspan="5" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
                <tr>
                <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <th class="cap" style="min-width: 35px; max-width: 35px"><ordenamiento title="Prg" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento></th>
                    <th class="cap" style="min-width: 30px; max-width: 30px">Hrs</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">Mol</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">Vac</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">F</th>
                <?php endfor;?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:filtro | orderBy:arr track by $index" 
                    ng-mousedown="setSelected(programacion);" 
                    ng-class="{info:selected.IdProgramacionSemana == programacion.IdProgramacionSemana}">
           
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.Producto}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.ProductoCasting}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.Aleacion}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.MoldesHora}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.FechaEmbarque | date:'dd-MM-yy'}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="max-width: 100px; min-width: 100px;">{{programacion.Marca}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="width: 33px;">{{programacion.Prioridad == 0 ? '' : programacion.Prioridad}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.Programadas}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.TotalProgramado | currency :"":0}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.Faltan <= 0, danger: programacion.Faltan == programacion.TotalProgramado, warning: (programacion.Faltan < programacion.TotalProgramado && programacion.Faltan > 0 )}" ng-show="mostrar">{{programacion.Faltan | currency :"":0}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <th class="cap" style="min-width: 35px; max-width: 35px">
                        <input ng-disabled="programacion.Estatus == 'Cerrado' || TipoUsuario !== 1" style="width: 30px; font-size: 9pt" class="filter" ng-model-options="{updateOn: 'blur'}" onkeypress="return justNumbers(event)" ng-change="saveProgramacionDiaria(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" />
                    </th>
                    <th class="cap" style="min-width: 30px; max-width: 30px">{{programacion.Programadas<?=$x?> / programacion.MoldesHora | currency:"":1}}</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">{{programacion.Llenadas<?=$x?>}}</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">{{programacion.Vaciadas<?=$x?>}}</th>
                    <th class="<?=$class?>" style="min-width: 30px; max-width: 30px">{{programacion.Programadas<?=$x?> - programacion.Llenadas<?=$x?>}}</th>
                <?php endfor; ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div id="encabezado" class="row">
        <div class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5"><input type="week" disabled="" ng-model="semanaActual" ng-change="loadDias();" /></th>
                </tr>
                <tr>
                    <th>Mol</th>
                    <th>Pzas</th>
                    <th>Ton</th>
                    <th>Ton P</th>
                    <th>Hrs</th>
                </tr>
                <tr>
                    <th>PRG</th>
                    <th>{{sumatoria(resumenes,'PrgMol')}}</th>
                    <th>{{sumatoria(resumenes,'PrgPzas') | currency:'':0}}</th>
                    <th>{{(sumatoria(resumenes,'PrgTon') / 1000) | currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'PrgTonP') / 1000) | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'PrgHrs') | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>PROD</th>
                    <th>{{sumatoria(resumenes,'HecMol')}}</th>
                    <th>{{sumatoria(resumenes,'HecPzas') | currency:'':0}}</th>
                    <th>{{(sumatoria(resumenes,'HecTon') / 1000) | currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'HecTonP') / 1000) | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'HecHrs') | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>FALTAN</th>
                    <th>{{(sumatoria(resumenes,'PrgMol') - sumatoria(resumenes,'HecMol'))}}</th>
                    <th>{{(sumatoria(resumenes,'PrgPzas') - sumatoria(resumenes,'HecPzas'))| currency:'':0}}</th>
                    <th>{{((sumatoria(resumenes,'PrgTon') - sumatoria(resumenes,'HecTon')) / 1000)| currency:'':2}}</th>
                    <th>{{((sumatoria(resumenes,'PrgTonP') - sumatoria(resumenes,'HecTonP')) / 1000)| currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'PrgHrs') - sumatoria(resumenes,'HecHrs'))| currency:'':2}}</th>
                </tr>
                <tr>
                    <th>% PROD</th>
                    <th>{{(sumatoria(resumenes,'HecMol') / sumatoria(resumenes,'PrgMol')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecPzas') / sumatoria(resumenes,'PrgPzas')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecTon') / sumatoria(resumenes,'PrgTon')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecTonP') / sumatoria(resumenes,'PrgTonP')) * 100 | currency:'':2}}%</th>
                    <th>{{(sumatoria(resumenes,'HecHrs') / sumatoria(resumenes,'PrgHrs')) * 100 | currency:'':2}}%</th>
                </tr>
            </table>
        </div>
        <div ng-repeat="resumen in resumenes" class="col-md-3">
            <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                <tr>
                    <th rowspan="2">Resumen</th>
                    <th colspan="5">{{dias[$index]}}</th>
                </tr>
                <tr>
                    <th>Mol</th>
                    <th>Pzas</th>
                    <th>Ton</th>
                    <th>Ton P</th>
                    <th>Hrs</th>
                </tr>
                <tr>
                    <th>PRG</th>
                    <th>{{resumen.PrgMol}}</th>
                    <th>{{resumen.PrgPzas | currency:'':0}}</th>
                    <th>{{(resumen.PrgTon / 1000) | currency:'':2}}</th>
                    <th>{{(resumen.PrgTonP / 1000) | currency:'':2}}</th>
                    <th>{{resumen.PrgHrs | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>PROD</th>
                    <th>{{resumen.HecMol}}</th>
                    <th>{{resumen.HecPzas | currency:'':0}}</th>
                    <th>{{(resumen.HecTon / 1000) | currency:'':2}}</th>
                    <th>{{(resumen.HecTonP / 1000) | currency:'':2}}</th>
                    <th>{{resumen.HecHrs | currency:'':1}}</th>
                </tr>
                <tr>
                    <th>FALTAN</th>
                    <th>{{(resumen.PrgMol - resumen.HecMol)}}</th>
                    <th>{{(resumen.PrgPzas - resumen.HecPzas)| currency:'':0}}</th>
                    <th>{{((resumen.PrgTon - resumen.HecTon) / 1000)| currency:'':2}}</th>
                    <th>{{((resumen.PrgTonP - resumen.HecTonP) / 1000)| currency:'':2}}</th>
                    <th>{{(resumen.PrgHrs - resumen.HecHrs)| currency:'':2}}</th>
                </tr>
                <tr>
                    <th>% PROD</th>
                    <th>{{((resumen.HecMol / resumen.PrgMol)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecPzas / resumen.PrgPzas)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecTon / resumen.PrgTon)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecTonP / resumen.PrgTonP)*100)| currency:'':1}}%</th>
                    <th>{{((resumen.HecHrs / resumen.PrgHrs)*100)| currency:'':1}}%</th>
                </tr>
            </table>
        </div>
    </div>