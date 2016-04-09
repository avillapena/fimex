    <div class="panel panel-primary">
        <div id="capturaAceptadas">
            <div class="panel-heading">Relacion de materiales usados</div>
            <div class="contenido" ng-model="materiales">
                <div class="barBoton"><div class="boton">Agregar Material</div></div>
                <div class="contInformacion noMargin">
                    <div class="cntMaterial noBorder">
                        Tipo de Material
                    </div><div class="inpMaterial noBorder">
                        Marca
                    </div><div class="inpMaterial noBorder">
                        Tipo
                    </div><div class="inpMaterial noBorder">
                        Lote
                    </div>
                </div>
                <div class="contInformacion">
                    <div class="cntMaterial">
                        <select class="cntMat" ng-change="javascript:alert(this.value)" ng-model="tipoMaterial" required>
                            <option value="">--Tipo Material</option>
                            <option value="matPadre.IdMaterialTipo" ng-repeat="matPadre in materialesP">
                                {{matPadre.Descripcion}}
                            </option>
                        </select> 
                    </div><div class="inpMaterial">
                        <select class="cntMat" ng-model="RemMar" required>
                            <option value="">--Marca</option>
                            <option ng-show="marcaREM.Descripcion == 'Removedor' && marcaREM.Identificador == 'MARCA' " value="{{marcaREM.IdMaterial}}" ng-repeat="marcaREM in materiales">{{marcaREM.IdMaterial}} - {{marcaREM.Nombre}}</option>
                        </select>  
                    </div><div class="inpMaterial">
                        <select class="cntMat" ng-model="RemTip" required>
                            <option value="">--Tipo</option>
                            <option ng-show="marcaREM.Descripcion == 'Removedor' && marcaREM.Identificador == 'TIPO' " value="{{marcaREM.IdMaterial}}" ng-repeat="marcaREM in materiales">{{marcaREM.IdMaterial}} - {{marcaREM.Nombre}}</option>
                        </select>
                    </div><div class="inpMaterial">
                        <input class="cntMat" type="text" ng-model="loteRemovedor"/>
                    </div>
                </div>
            </div>
        </div>
    </div>