<h1>SELECCION DE PEDIDOS PARA EMBARQUES</h1>
<div ng-controller="Embarques" ng-init="Fecha = '<?=date('Y-m-d')?>';IdArea = <?=$IdArea?>;loadPedidos();loadEmbarques();loadClientes();">
    <div class="row">
        Fecha: <input type="date" ng-model="Fecha" format-date/><button ng-click="loadEmbarques();">Ver</button>
        Buscar Producto: <input ng-model="filtro.ParteFimex" />
        Buscar Cliente: <select ng-model="filtro.NOMBRE">
            <option value="">Todos</option>
            <option ng-repeat="cliente in clientes" value="{{cliente.NOMBRE}}">{{cliente.NOMBRE}}</option>
        </select>
    </div>
    <div class="row">
        <div class="panel panel-default col-md-6">
            <div class="panel-heading">LISTA DE PEDIDOS POR SURTIR</div>
            <div class="panel-body" style="height: 700px; overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">
                                <ordenamiento title="Cliente" arreglo="arr" element="NOMBRE"></ordenamiento>
                            </th>
                            <th colspan="2" class="center"># Parte</th>
                            <th colspan="2" class="center">Fecha</th>
                            <th rowspan="2">
                                <ordenamiento title="OE" arreglo="arr" element="OE"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="OC" arreglo="arr" element="OC"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="QTY" arreglo="arr" element="QTY"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="TOTAL SHPIMPENT" arreglo="arr" element="TotalShipment"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="Balance" arreglo="arr" element="Balance"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="Descripcion" arreglo="arr" element="Descripcion"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="Material" arreglo="arr" element="Aleacion"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="Planta" arreglo="arr" element="Planta"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="CODYNUMPAR" arreglo="arr" element="CODYNUMPAR"></ordenamiento>
                            </th>
                            <th rowspan="2">
                                <ordenamiento title="Serie" arreglo="arr" element="Serie"></ordenamiento>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <ordenamiento title="Fimex" arreglo="arr" element="ParteFimex"></ordenamiento>
                            </th>
                            <th>
                                <ordenamiento title="Cliente" arreglo="arr" element="ParteCliente"></ordenamiento>
                            </th>
                            <th>
                                <ordenamiento title="Entrega" arreglo="arr" element="FechaEntrega"></ordenamiento>
                            </th>
                            <th>
                                <ordenamiento title="Embarque" arreglo="arr" element="FechaEmbarque"></ordenamiento>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="pedido in pedidos | filter:filtro | orderBy:arr" data-ng-dblclick="saveEmbarque(pedido,true)">
                            <td>{{pedido.NOMBRE}}</td>
                            <td>{{pedido.ParteFimex}}</td>
                            <td>{{pedido.ParteCliente}}</td>
                            <td>{{pedido.FechaEntrega}}</td>
                            <td>{{pedido.FechaEmbarque}}</td>
                            <td>{{pedido.OE}}</td>
                            <td>{{pedido.OC}}</td>
                            <td>{{pedido.QTY}}</td>
                            <td>{{pedido.QTY - pedido.Balance}}</td>
                            <td>{{pedido.Balance}}</td>
                            <td>{{pedido.Descripcion}}</td>
                            <td>{{pedido.Aleacion}}</td>
                            <td>{{pedido.Planta}}</td>
                            <td>{{pedido.CODYNUMPAR}}</td>
                            <td>{{pedido.Serie}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default col-md-6">
            <div class="panel-heading">PEDIDOS A EMBARCAR</div>
            <div class="panel-body" style="height: 700px; overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>OC</th>
                            <th>Fecha Entrega</th>
                            <th>Cantidad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button class="btn btn-success btn-xs" ng-click="saveEmbarque(emb,true);emb=[]"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></button></td>
                            <td ng-init="emb.IdArea = IdArea"><input ng-model="emb.Cliente"/></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="width: 50px"><input class="form-control" ng-model="emb.Cantidad"></td>
                            <td><textarea class="form-control" ng-model="emb.Observaciones"></textarea></td>
                        </tr>
                        <tr ng-repeat="embarque in embarques">
                            <td><button class="btn btn-danger btn-xs" ng-click="deleteEmbarque($index)"><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                            <td>{{embarque.Cliente}}</td>
                            <td>{{embarque.ParteFimex}}</td>
                            <td>{{embarque.OC}}</td>
                            <td>{{embarque.FechaEntrega}}</td>
                            <td style="width: 50px"><input class="form-control" ng-model="embarque.Cantidad" ng-model-options="{updateOn: 'blur'}" ng-change="saveEmbarque(embarque)"></td>
                            <td><textarea class="form-control" ng-model="embarque.Observaciones" ng-model-options="{updateOn: 'blur'}" ng-change="saveEmbarque(embarque)"></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>