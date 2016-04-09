<h1>PROGRAMA SEMANAL DE EMBARQUES</h1>
<div ng-controller="Embarques" ng-init="Junta = <?=$Junta?>;Fecha = '<?=date('Y-m-d')?>'; FechaFin = '<?=date('Y-m-d')?>'; IdArea = <?=$IdArea?>;loadEmbarques();">
    <div class="row">
        Fecha Inicial: <input type="date" ng-model="Fecha" format-date/>
        Fecha Final: <input type="date" ng-model="FechaFin" format-date/><button ng-click="loadEmbarques();">Ver</button>
    </div>
    <div class="row">
        <div class="panel panel-primary col-md-12" ng-repeat="fecha in Fechas">
            <div class="panel-heading">{{fecha | date : "EEEE, d 'de' MMMM 'de' y"}}</div>
            <div class="panel-body">
                <div
                    class="panel panel-info col-md-12"
                    ng-repeat="cliente in Clientes"
                    ng-if="(embarques | filter:{Fecha: fecha,Cliente: cliente}).length > 0"
                >
                    <div class="panel-heading"><h4>{{cliente}}</h4></div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="info">
                                    <th># Parte Fimex</th>
                                    <th>Balance</th>
                                    <th>Enviado</th>
                                    <th>Programado</th>
                                    <th>Observaciones</th>
                                    <th><span ng-if="IdArea == 2">PLA</span><span ng-if="IdArea == 3">PLB</span></th>
                                    <th><span ng-if="IdArea == 2">PLA2</span><span ng-if="IdArea == 3">PLB2</span></th>
                                    <th><span ng-if="IdArea == 2">CTA</span><span ng-if="IdArea == 3">CTB</span></th>
                                    <th><span ng-if="IdArea == 2">CTA2</span><span ng-if="IdArea == 3">CTB2</span></th>
                                    <th><span ng-if="IdArea == 2">PMA</span><span ng-if="IdArea == 3">PMB</span></th>
                                    <th><span ng-if="IdArea == 2">PMA2</span><span ng-if="IdArea == 3">PMB2</span></th>
                                    <th><span ng-if="IdArea == 2">PTA</span><span ng-if="IdArea == 3">PTB</span></th>
                                    <th ng-if="Junta">Aleacion</th>
                                    <th ng-if="Junta">Peso Cast</th>
                                    <th>Fecha Embarque</th>
                                    <th>Notas de la Junta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="font-size: 10pt;" ng-repeat="embarque in embarques | filter:{Fecha: fecha,Cliente: cliente}">
                                    <td style="min-width: 200px;max-width: 200px">{{embarque.ParteFimex}}</td>
                                    <td style="min-width: 20px;max-width: 20px">{{embarque.Balance | currency:"":0}}</td>
                                    <td style="min-width: 20px;max-width: 20px">{{embarque.QTY - embarque.Balance | currency:"":0}}</td>
                                    <td style="min-width: 20px;max-width: 20px">{{embarque.Cantidad | currency:"":0}}</td>
                                    <td style="min-width: 300px;max-width: 300px">{{embarque.Observaciones}}</td>
                                    <td>{{embarque.PL | currency:"":0}}</td>
                                    <td>{{embarque.PL2 | currency:"":0}}</td>
                                    <td>{{embarque.CT | currency:"":0}}</td>
                                    <td>{{embarque.CT2 | currency:"":0}}</td>
                                    <td>{{embarque.PM | currency:"":0}}</td>
                                    <td>{{embarque.PM2 | currency:"":0}}</td>
                                    <td>{{embarque.PT | currency:"":0}}</td>
                                    <td ng-if="Junta">{{embarque.Aleacion}}</td>
                                    <td ng-if="Junta">{{embarque.PesoCastingA}}</td>
                                    <td class="{{embarque.class}}">{{embarque.FechaEmbarque | date: 'd-MMM-y'}}</td>
                                    <td style="min-width: 300px;max-width: 300px"><textarea cols="49" ng-model="embarque.Nota" ng-model-options="{updateOn: 'blur'}" ng-change="saveEmbarque(embarque)" ng-if="Junta"></textarea><span ng-if="!Junta">{{embarque.Nota}}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>