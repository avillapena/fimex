    <div class="panel panel-primary">
        <div id="capturaRechazadas">
            <div class="panel-heading">Captura de Evidencias (Reparaciones/Scrap) </div>
            <div class="contenido" >
                <div class="form-group left">
                    <div class="repetir" ng-repeat="datar in datos.preparacion">
                        <form enctype="multipart/form-data" ng-attr-id="{{'formuploadajax_'+$index}}" method="post">
                            <div class="titulo">
                                ID: {{datar.IdEvidenciasCalidad}} 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Pieza {{piezaLetrero}} no. {{$index+1}} 
                            </div>
                            <div class="mid"><!--Contenido mitad izquierdo-->
                                <div class="contiene"><!--Parte superior mitad izquierda-->
                                    <div class="mid">
                                        <div class="contiene"><!--Contiene el motivo-->
                                            <select ng-model="datar.IdMotivo" ng-attr-id="{{'motivos_'+$index}}" name="motivos">
                                                <option ng-selected="datar.IdMotivo == defecto.IdDefectoTipo" ng-repeat="defecto in defectos" value="{{defecto.IdDefectoTipo}}">{{defecto.NombreTipo}}</option>
                                            </select>
                                        </div>
                                        <div class="contiene"><!--contiene la serie-->
                                            <select ng-model="datar.IdSerie" ng-attr-id="{{'series_'+$index}}" name="IdSerie">
                                                
                                                <option ng-selected=" datar.IdSerie = serie.IdSerie " ng-repeat="serie in listadoseries2" value="{{serie.IdSerie}}">{{serie.Serie}}</option>
                                            </select>
                                        </div>
                                    </div><div class="mid"><!--contiene las observaciones-->
                                        <textarea ng-model="datar.Comentarios" placeholder="Escriba sus comentarios" ng-attr-id="{{'observaciones_'+$index}}" name="observaciones"></textarea>
                                    </div>
                                </div>
                                <div class="contiene"><!--Contiene espacio para imagen-->
                                    <div class="input">
                                        <input type="file" class="input-file" ng-attr-id="{{'archivo_'+$index}}" name="{{'archivo_'+$index}}" ng-model="archivo_$index" onchange="sendImagen(this.id)"/>
                                        Click para subir Imagen y guradar registro
                                    </div>
                                </div>
                                <input type="hidden" name="nombreImagen" ng-model="nombreImagen" id="nombreImagen" value="{{'archivo_'+$index}}" >
                                <input type="hidden" name="IdEvidencia" ng-model="datar.IdEvidenciasCalidad" id="IdEvidencia" value="{{datar.IdEvidenciasCalidad}}" >
                            </div><div class="mid">
                                <div class="imagen" id="imagen_{{$index+1}}">
                                    <img src="preview.png" ng-model="datar.imgCompleta" ng-src="../{{datar.imgCompleta}}">
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>