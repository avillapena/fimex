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
<div ng-controller="ProgramacionLimpieza" ng-init="filtro.Estatus = 'Abierto';IdArea=<?=$IdArea?>;Turno=1;IdProceso=<?=$IdProceso?>;IdSubProceso=<?=$IdProceso == 1 ? 6 : 12?>;loadDias();">
    <b style="font-size: 14pt;">Programacion Diaria: </b><input type="week" ng-model-options="{updateOn: 'blur'}" ng-model="semanaActual" ng-change="loadDias();" />
    <b style="font-size: 14pt;">Turno: </b><select ng-model="Turno" ng-change="loadDias();">
        <option ng-selected="Turno == 1" value="1">Dia</option>
        <option ng-selected="Turno == 3" value="3">Noche</option>
    </select>
    <button class="btn btn-success" ng-click="loadDias();">Actualizar</button>
    Mostrar Pedidos: <select  ng-model="filtro.Estatus">
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
                    <th rowspan="2">
                        <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="filtro.Marca" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Descripcion" element="Descripcion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.Descripcion" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Producto" element="Producto" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Producto" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Cod Cliente" element="Casting" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Casting" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Material" element="Aleacion" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Aleacion" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Peso Casting" element="PesoCasting" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.PesoCasting" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Pr" element="Prioridad" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Prioridad" />
                    </th>
                    <th rowspan="2" style="width: 33px">
                        <ordenamiento title="Prog" element="TotalProgramado" arreglo="arr"></ordenamiento>
                    </th>
                    <th rowspan="2" style="width: 33px" ng-show="mostrar">Falt</th>
                    <th class="cap" colspan="5" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
                <tr>
                    <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    
                    <th class="cap">Celda</th>
                    <th class="cap">Prog</th>
                    <th class="<?=$class?>">KG</th>
                    <th class="<?=$class?>">H</th>
                    <th class="<?=$class?>">F</th>
                <?php endfor; ?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:filtro | orderBy:orden" ng-mousedown="setSelected(programacion);" ng-class="{info:selected.IdProgramacionSemana == programacion.IdProgramacionSemana}">
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Marca}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Descripcion}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Producto}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.ProductoCasting}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Aleacion}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.PesoCasting}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="width: 33px;">{{programacion.Prioridad == 0 ? '' : programacion.Prioridad}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.Programadas}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, danger: programacion.TotalProgramado == 0, warning: programacion.TotalProgramado < programacion.Programadas}">{{programacion.TotalProgramado | currency :"":0}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <th class="cap"><select ng-model-options="{updateOn: 'blur'}" onkeypress="return justNumbers(event)" ng-change="saveProgramacionDiaria(programacion,<?=$x?>);" ng-model="programacion.IdCentroTrabajo<?=$x?>">
                            <option ng-selected="centro.IdCentroTrabajo == programacion.IdCentroTrabajo<?=$x?>" ng-if="centro.centrosTrabajoMaquinas.length > 0" ng-repeat="centro in centros" value="{{centro.IdCentroTrabajo}}">{{centro.Descripcion}}</option>
                        </select></th>
                    <th class="cap"><input ng-init="programacion.Maquina<?=$x?>" ng-disabled="programacion.Estatus == 'Cerrado'" class="filter" style="width: 33px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" onkeypress="return justNumbers(event)" ng-change="saveProgramacionDiaria(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>"></th>
                    <th class="<?=$class?>">{{programacion.Programadas<?=$x?> * programacion.PesoCasting | currency:"":1}}</th>
                    <th class="<?=$class?>">{{programacion.Hechas<?=$x?>}}</th>
                    <th class="<?=$class?>">{{programacion.Programadas<?=$x?> - programacion.Hechas<?=$x?>}}</th>
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
                    <th>PZAS</th>
                    <th>TON</th>
                </tr>
                <tr>
                    <th>META</th>
                    <th>{{resumenesSemana[0].PzaMeta | currency:'':0}}</th>
                    <th>{{(resumenesSemana[0].TonMeta / 1000) | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>PROG SEM</th>
                    <th>{{resumenesSemana[0].PzaPrg | currency:'':0}}</th>
                    <th>{{(resumenesSemana[0].TonPrg / 1000) | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>PROG</th>
                    <th>{{sumatoria(resumenes,'PzasProg') | currency:'':0}}</th>
                    <th>{{(sumatoria(resumenes,'TonProg') / 1000) | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>ENV</th>
                    <th>{{sumatoria(resumenes,'PzasHechas') | currency:'':0}}</th>
                    <th>{{(sumatoria(resumenes,'TonHechas') / 1000) | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>% ENV</th>
                    <th>{{(sumatoria(resumenes,'PzasHechas') / sumatoria(resumenes,'PzasProg')) | currency:'':2}}</th>
                    <th>{{(sumatoria(resumenes,'TonHechas') / sumatoria(resumenes,'TonProg')) | currency:'':2}}</th>
                </tr>
            </table>
        </div>
        <?= $this->render('resumenCelda');?>
        <div class="col-md-4">
            <div ng-repeat="resumen in resumenes" class="col-md-6">
                <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover" style="font-size: 11pt;">
                    <tr>
                        <th rowspan="2">Resumen</th>
                        <th colspan="5">{{dias[$index]}}</th>
                    </tr>
                    <tr>
                        <th>PZAS</th>
                        <th>TON</th>
                    </tr>
                    <tr>
                        <th>PROG</th>
                        <th>{{resumen.PzasProg | currency:'':0}}</th>
                        <th>{{(resumen.TonProg / 1000) | currency:'':2}}</th>
                    </tr>
                    <tr>
                        <th>ENV</th>
                        <th>{{resumen.PzasHechas | currency:'':0}}</th>
                        <th>{{(resumen.TonHechas / 1000) | currency:'':2}}</th>
                    </tr>
                    <tr>
                        <th>% ENV</th>
                        <th>{{(resumen.PzasHechas / resumen.PzasProg) | currency:'':2}}</th>
                        <th>{{(resumen.TonHechas / resumen.TonProg) | currency:'':2}}</th>
                </table>
            </div>
        </div>
    </div>