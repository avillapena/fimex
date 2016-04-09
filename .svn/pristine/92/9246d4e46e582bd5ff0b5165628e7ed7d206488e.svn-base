<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Detalle Certificado Tratamientos</div>
    <div class="panel-body">
        <button class="btn btn-success" ng-click="addDetalle()">Agregar </button>
    </div>
    <div id="detalle" class="scrollable">
        <table ng-table class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-md-2">Orden de Compra</th>
                    <th class="col-md-2">Parte</th>
                    <th class="col-md-2">Descripcion</th>
                    <th class="col-md-2">Material</th>
                    <th class="col-md-2">Colada</th>
                    <th class="col-md-2">Series</th>
                    <th class="col-md-2">Cantidad</th>
                    <th class="col-md-2">notas</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr 
                    ng-class="{'info': indexDetalle == $index, 'warning': detalle.change == true}"
                    ng-click="selectDetalle($index);"
                    ng-repeat="detalle in detalles">
                    
                    <!-- <td class="col-md-5">
					<select aria-describedby="productos" class="form-control" ng-change="SetIdProgramacion(detalles[$index].IdProductos)" ng-model="detalle.IdProductos" required>
                        <option ng-selected="detalle.IdProductos == programado.IdProducto" value="{{programado.IdProducto}}" ng-repeat="programado in programadosTT"> {{programado.Identificacion}}   {{programado.Descripcion}} </option>
                    </select>     
					</td> -->
                     
                    <!-- <td class=" col-md-3"><input  ng-model-options="{updateOn: 'blur'}" ng-model="detalle.FechaMoldeo"  value="{{detalle.FechaMoldeo}}"</td> -->
                          
                    <!-- orden de compra -->
                    <td>
                    <select  class="form-control" ng-change="loadProducto()" ng-model="detalle.OrdenDeCompra" required>
                        <option ng-selected="detalle.OrdenDeCompra == ocs.OrdenCompra" value="{{ocs.OrdenCompra}}" ng-repeat="ocs in oc_s"> {{ocs.OrdenCompra}}  </option>
                    </select>   
                    </td>

                    <!-- producto -->
                    <td>
                    <select  class="form-control" ng-change="setProducto()" ng-model="detalle.idProducto.Identificacion" required>
                        <option  ng-selected="detalle.producto == prod.Producto" value="{{prod.Producto}}" ng-repeat="prod in productos"> {{prod.Producto}}  </option>
                    </select>  
                    </td>

                    <!-- Descripcion -->
                    <td ><input  ng-model-options="{updateOn: 'blur'}"  ng-model="detalle.descripcion" value="{{detalle.descripcion}}" readonly/></td>

                    <!-- Material -->
                    <td ><input  ng-model-options="{updateOn: 'blur'}"  ng-model="detalle.material" value="{{detalle.material}}" readonly/></td>
                    
                    <!-- colada -->
                    <td>
                   <!--  <select ng-change="selectColada(colada.Colada)" multiple="true"  ng-options="  colada.Colada for colada in coladas " class="form-control" ng-model="selcoladas" required>
                    </select>    -->
                    <div ng-repeat="series in coladas" class="listaSerie">
                        <div  > <input   type="checkbox" name="Colada[]" ng-checked="estacolada(series.Colada)" value="{{series}}"  > {{series.Colada}} </div>
                    </div>

                    </td>

                    <!-- serie -->
                    <td>
                    <!-- <select   ng-change="selectSerie();" multiple="true"  ng-options="  ser.Serie for ser in serie " class="form-control" ng-model="detalle.serie" required> -->
                       <div ng-repeat="series in serie" class="listaSerie">
                        <input  type="checkbox" name="Series[]"   ng-checked="estaserie(series.Serie) " value="{{series}}" >  {{series.Serie}} 
                    </div>
                    </td>
                    
                    <!-- cantidad -->
                    <td class="captura"><input  ng-model-options="{updateOn: 'blur'}"  ng-model="detalle.Cantidad" value="{{detalle.cantidad}}"/></td>
                    
                    <td>
                        
                    </td>

                    <td>
                        <button class="btn btn-success btn-xs" ng-click="saveDetalle($index)"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                        <button ng-if="detalle.IdCertificadoTTDetalle != null" class="btn btn-danger btn-xs" ng-click="deleteDetalle($index)"><span class="glyphicon glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>