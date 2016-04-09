<div class="panel panel-default">
    <div class="panel-body"></div>
    <div id="opacidad" ng-show="isLoading"></div>
    <div class="animacionGiro" ng-show="isLoading"></div>
    <div id="semanal" class="scrollable">
    <table fixed-table-headers="semanal" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th ng-show="mostrar" style="min-width: 30px;" rowspan="2"></th>
                <th ng-show="mostrar" style="max-width: 100px;min-width: 100px"  rowspan="2">
                    <ordenamiento title="Cliente" element="Marca" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model-options="{updateOn: 'blur'}" ng-model="filtro.Marca" />
                </th>
                <th ng-show="mostrar" style="max-width: 200px;min-width: 200px" rowspan="2">
                    <ordenamiento title="Descripcion" element="Descripcion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.Descripcion" />
                </th>
                <th ng-show="mostrar" style="max-width: 200px;min-width: 200px" rowspan="2">
                    <ordenamiento title="Cod Cliente" element="ProductoCasting" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.ProductoCasting" />
                </th>
                <th style="max-width: 200px;min-width: 200px" rowspan="2">
                    <ordenamiento title="No Parte" element="Producto" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.Producto" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px;min-width: 100px" rowspan="2">
                    <ordenamiento title="Material" element="Aleacion" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.Aleacion" />
                </th>
                <th ng-show="mostrar" style="max-width: 100px;min-width: 100px" rowspan="2">
                    <ordenamiento title="Peso Casting" element="PesoCasting" arreglo="arr"></ordenamiento>
                    <input class="form-control" ng-model="filtro.PesoCasting" />
                </th>
                
                <th rowspan="2">Pzas Pedido</th>  
                <th colspan="5">Existencias Almacenes</th>
                <th colspan="5">Existencias Internas</th>
                <?php for($x=1;$x<=2;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>" colspan="6">Semana {{semanas.semana<?=$x?>.week}},{{semanas.semana<?=$x?>.year}}</th>
                <?php endfor;?>
            </tr>
            <tr>
                <th style="max-width: 50px" >FA</th>
                <th style="max-width: 50px" >PLA</th>
                <th style="max-width: 50px" >PLA2</th>
                <th style="max-width: 50px" >CTA</th>
                <th style="max-width: 50px" >PTA</th>
                <th style="max-width: 100px" >Qu</th>
                <th style="max-width: 100px" >Lim</th>
                <th style="max-width: 100px" >Rack</th>
                <th style="max-width: 100px" >T.T.</th>
                <th style="max-width: 100px" >CA</th>
                <?php for($x=1;$x<=2;$x++):?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>2">
                    <ordenamiento title="Pr" element="Prioridad<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>">
                    <ordenamiento title="Prg" element="Programadas<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">
                    <ordenamiento title="Emb" element="CantidadEmbarque<?=$x?>" arreglo="arr"></ordenamiento>
                </th>
                <th class="<?=$class?>2">KG</th>
                <th class="<?=$class?>2">H</th>
                <th class="<?=$class?>2">F</th>
                <?php endfor;?>
            </tr>
        </thead>
        <tbody style="font-size: 10pt">
            <tr style="{{programacion.class}}"
                ng-show="programacion.PLA > 0 || programacion.PLA2 > 0 || programacion.CantidadEmbarque1 > 0 || programacion.CantidadEmbarque2 > 0 || programacion.ProgramadasMoldeo > 0"
                ng-repeat="programacion in programaciones | orderBy:arr | filter:filtro track by $index"
                ng-click="setSelected(programacion);"
                ng-class="{warning:selected.IdProgramacion == programacion.IdProgramacion}">
                <th class="fixed" ng-show="mostrar" ><input type="checkbox" class="form-control" name="Cerrado[]" value="{{programacion.IdProgramacion}}" /></th>
                <th ng-show="mostrar" style="max-width: 100px;">{{programacion.Marca}}</th>
                <th title="{{programacion.Descripcion}}" ng-show="mostrar">{{programacion.Descripcion | uppercase | limitTo : 15}}</th>
                <th style="background:{{programacion.ColorProducto}}" title="{{programacion.producto}}" ng-show="mostrar" >
                    {{programacion.ProductoCasting | uppercase | limitTo : 15}}
                </th>
                <th ng-show="{{programacion.ColorKamBan != ''}}" style="background:{{programacion.ColorKamBan}}">{{programacion.Producto}}</th>
                <th ng-show="!{{programacion.ColorKamBan != ''}}">{{programacion.Producto}}</th>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.Aleacion}}</th>
                <th ng-show="mostrar" style="max-width: 100px">{{programacion.PesoCasting}}</th>
                <th style="max-width: 50px">{{programacion.SaldoCantidad}}</th>
                <th style="max-width: 50px" class="info">{{programacion.ProgramadasMoldeo == 0 ? '' : programacion.ProgramadasMoldeo}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PLA == 0 ? '' : programacion.PLA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PLA2 == 0 ? '' : programacion.PLA2}}</th>
                <th style="max-width: 50px" class="info">{{programacion.CTA == 0 ? '' : programacion.CTA}}</th>
                <th style="max-width: 50px" class="info">{{programacion.PTA == 0 ? '' : programacion.PTA}}</th>
                <th style="max-width: 100px" class="warning">{{programacion.ExistenciaQuebrado}}</th>
                <th style="max-width: 100px" class="warning">{{programacion.ExistenciaLimpieza}}</th>
                <th style="max-width: 100px" class="warning">{{programacion.ExistenciaRack}}</th>
                <th style="max-width: 100px" class="warning">{{programacion.Tratamientos}}</th>
                <th style="max-width: 100px" class="warning">{{programacion.Calidad}}</th>
            <?php for($x=1;$x<=2;$x++): ?>
                <?php $class = $x % 2 != 0 ?'par' : 'impar'; ?>
                <th class="<?=$class?>2"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-disabled="TipoUsuario != 1" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Prioridad<?=$x?>" value="{{programacion.Prioridad<?=$x?>}}"></th>
                <th class="<?=$class?>"><input style="width: 50px;" ng-model-options="{updateOn: 'blur'}" ng-disabled="TipoUsuario != 1" ng-focus="setSelected(programacion);" ng-change="saveProgramacionSemanal(programacion,<?=$x?>);" ng-model="programacion.Programadas<?=$x?>" value="{{programacion.Programadas<?=$x?>}}"></th>
                <th class="<?=$class?>2">{{programacion.CantidadEmbarque<?=$x?>}}</th>
                <th class="<?=$class?>2">{{programacion.Programadas<?=$x?> * programacion.PesoCasting | currency:'':1}}</th>
                <th class="<?=$class?>2">{{(programacion.Hechas<?=$x?>) | number : 0}}</th>
                <th class="<?=$class?>2">{{(programacion.Programadas<?=$x?> - programacion.Hechas<?=$x?>) | number : 0}}</th>
            <?php endfor;?>
            </tr>
        </tbody>
    </table>
    </div>
</div>
<div id="encabezado" class="row">
    <div ng-repeat="resumen in resumenesSemana" ng-if="$index < 2" class="col-md-2">
        <table ng-class="{par:$index % 2 == 0, impar:$index % 2 != 0}" class="table table-bordered table-hover">
            <tr>
                <th rowspan="2">Resumen</th>
                <th colspan="4">Semana {{resumen.Semana}},{{resumen.Anio}}</th>
            </tr>
            <tr>
                <th>Pza</th>
                <th>Ton</th>
            </tr>
            <tr>
                <th>META</th>
                <th>{{resumen.PzaMeta | currency:'':0}}</th>
                <th>{{(resumen.TonMeta / 1000)| currency:'':2}}</th>
            </tr>
            <tr>
                <th>PRG</th>
                <th>{{resumen.PzaPrg}}</th>
                <th>{{(resumen.TonPrg / 1000) | currency:'':2}}</th>
            </tr>
            <tr>
                <th>ENV</th>
                <th>{{resumen.Hechas}}</th>
                <th>{{(resumen.TonHechas / 1000) | currency:'':2}}</th>
            </tr>
            <tr>
                <th>% ENV</th>
                <th>{{((resumen.Hechas / resumen.PzaPrg)*100)| currency:'':2}}%</th>
                <th>{{((resumen.TonHechas / resumen.TonPrg)*100)| currency:'':2}}%</th>
            </tr>
        </table>
    </div>
    <?= $this->render('resumenCelda');?>
</div>