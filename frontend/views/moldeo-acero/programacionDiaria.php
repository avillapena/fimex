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
<div ng-controller="Programacion" ng-init="filtro.Estatus = 'Abierto';TipoUsuario=<?=$TipoUsuario?>;IdArea=<?=$IdArea?>;IdProceso=<?=$IdProceso?>;Turno=1;loadDias();">
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
                    <th rowspan="2">
                        <ordenamiento title="No Parte" element="Producto" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Producto" />
                    </th>
                    <th rowspan="2">
                        <ordenamiento title="Cod Cliente" element="ProductoCasting" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.ProductoCasting" />
                    </th>
                    <th rowspan="2" style="width: 60px;">
                        <ordenamiento title="Embarque" element="FechaEmbarque" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.FechaEmbarque" />
                    </th>
                    <th rowspan="2" style="width: 60px;">
                        <ordenamiento title="Aleacion" element="Aleacion" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Aleacion" />
                    </th>
                    <th rowspan="2" style="width: 60px;">
                        <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Marca" />
                    </th>
                    <th rowspan="2" style="width: 33px;" >
                        <ordenamiento title="Pr" element="Prioridad" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.Prioridad" />
                    </th>
                    <th rowspan="2" style="width: 60px;">
                        <ordenamiento title="AreaAct" element="AreaAct" arreglo="arr"></ordenamiento>
                        <input class="form-control" ng-model="filtro.AreaAct" />
                    </th>
                    <th rowspan="2" style="width: 33px">
                        <ordenamiento title="Mold" element="Programadas" arreglo="arr"></ordenamiento>
                    </th>
                    <th rowspan="2" style="width: 33px">
                        <ordenamiento title="Prog" element="TotalProgramado" arreglo="arr"></ordenamiento>
                    </th>
                    <th rowspan="2" style="width: 33px">Falt</th>
                    <th class="cap" colspan="6" ng-repeat="dia in dias">{{dia}}</th>
                </tr>
                <tr>
                    <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    
                    <th class="cap" style="width: 36px"><ordenamiento title="Prg" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento></th>
                    <th class="cap" style="width: 36px">Hrs</th>
                    <th class="<?=$class?>" style="width: 36px">L</th>
                    <th class="<?=$class?>">C</th>
                    <th class="<?=$class?>" style="width: 36px">V</th>
                    <th class="<?=$class?>" style="width: 36px">F</th>
                    <?php endfor;?>
                </tr>
            </thead>
            <tbody style="font-size: 10pt">
                <tr ng-repeat="programacion in programaciones | filter:filtro | orderBy:arr track by $index"" 
                    ng-mousedown="setSelected(programacion);" 
                    ng-class="{info:selected.IdProgramacionSemana == programacion.IdProgramacionSemana}">
           
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Producto}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.ProductoCasting}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.FechaEmbarque | date:'dd-MM-yy'}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Aleacion}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.Marca}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}" style="width: 33px;">{{programacion.Prioridad == 0 ? '' : programacion.Prioridad}}</th>
                    <th ng-class="{warning2: (programacion.TotalProgramado*1) > (programacion.Programadas*1)}">{{programacion.AreaAct}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, warning: programacion.TotalProgramado < programacion.Programadas, danger: programacion.TotalProgramado == 0}">{{programacion.Programadas}}</th>
                    <th style="width: 33px" ng-class="{success: programacion.TotalProgramado >= programacion.Programadas, warning: programacion.TotalProgramado < programacion.Programadas, danger: programacion.TotalProgramado == 0}">{{programacion.TotalProgramado}}</th>
                    <th style="width: 33px" ng-init="programacion.Faltan = programacion.TotalProgramado - programacion.TotalHecho" ng-class="{success: programacion.Faltan <= 0, danger: programacion.Faltan == programacion.TotalProgramado, warning: (programacion.Faltan < programacion.TotalProgramado && programacion.Faltan > 0 )}">{{programacion.Faltan | currency :"":0}}</th>

                <?php for($x=1;$x<=6;$x++):?>
                    <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                    <th class="cap"><input ng-disabled="programacion.Estatus == 'Cerrado'" class="filter" style="width: 33px; font-size: 9pt;" ng-model-options="{updateOn: 'blur'}" onkeypress="return justNumbers(event)" ng-change="saveProgramacionDiaria(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>"></th>
                    <th class="cap">{{programacion.Programadas<?=$x?> / programacion.MoldesHora | currency:"":1}}</th>
                    <th class="<?=$class?>">{{programacion.Llenadas<?=$x?>}}</th>
                    <th class="<?=$class?>">{{programacion.Cerradas<?=$x?>}}</th>
                    <th class="<?=$class?>">{{programacion.Vaciadas<?=$x?>}}</th>
                    <th class="<?=$class?>">{{programacion.Programadas<?=$x?> - programacion.Vaciadas<?=$x?>}}</th>
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
                    <th>K</th>
                    <th>V</th>
                    <th>E</th>
                </tr>
                <tr>
                    <th>TON PRG</th>
                    <th>{{sumatoria(resumenes,'TonPrgK') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'TonPrgV') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'TonPrgE') | currency:'':2}}</th>
                    
                </tr>
                <tr>
                    <th>TON VAC</th>
                    <th>{{sumatoria(resumenes,'TonVacK') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'TonVacV') | currency:'':2}}</th>
                    <th>{{sumatoria(resumenes,'TonVacE') | currency:'':2}}</th>
                    
                </tr>
                <tr>
                    <th>Ciclos</th>
                    <th>{{(sumatoria(resumenes,'CiclosK'))}}</th>
                    <th>{{(sumatoria(resumenes,'CiclosV'))}}</th>
                    <th>{{(sumatoria(resumenes,'CiclosE'))}}</th>
                    
                </tr>
                <tr>
                    <th>Moldes</th>
                    <th>{{(sumatoria(resumenes,'MolPrgK'))}}</th>
                    <th>{{(sumatoria(resumenes,'MolPrgV'))}}</th>
                    <th>{{(sumatoria(resumenes,'MolPrgE'))}}</th>
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
                    <th>K</th>
                    <th>V</th>
                    <th>E</th>
                    
                </tr>
                <tr>
                    <th>TON PRG</th>
                    <th>{{resumen.TonPrgK | currency:'':2}}</th>
                    <th>{{resumen.TonPrgV | currency:'':2}}</th>
                    <th>{{resumen.TonPrgE | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>TON VAC</th>
                    <th>{{resumen.TonVacK | currency:'':2}}</th>
                    <th>{{resumen.TonVacV | currency:'':2}}</th>
                    <th>{{resumen.TonVacE | currency:'':2}}</th>
                </tr>
                <tr>
                    <th>CICLOS</th>
                    <th>{{(resumen.CiclosK)}}</th>
                    <th>{{(resumen.CiclosV)}}</th>
                    <th>{{(resumen.CiclosE)}}</th>
                </tr>
                <tr>
                    <th>MOL PRG</th>
                    <th>{{(resumen.MolPrgK)}}</th>
                    <th>{{(resumen.MolPrgV)}}</th>
                    <th>{{(resumen.MolPrgE)}}</th>
                </tr>
            </table>
        </div>
    </div>