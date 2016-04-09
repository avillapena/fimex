<h4 style="margin-top:0;">Reporte programacion Semanal Limpieza Acero</h4>
<div ng-controller="ProgramacionLimpieza" ng-init="showModal = false;IdProceso=<?=$IdProceso?>; IdArea=<?=$IdArea?>; TipoUsuario=<?=$TipoUsuario?>;Estatus='Abierto';loadSemanas();">
    <input type="week" ng-model="semanaActual" ng-model-options="{updateOn: 'blur'}" ng-change="loadSemanas();" format-date />
    <button class="btn btn-success" ng-click="loadSemanas();">Actualizar</button>
    <!--<button class="btn btn-info" ng-click="loadEmbarques()">Ver embarques</button>-->
    Mostrar Pedidos: <select  ng-model="Estatus" ng-change="loadSemanas();">
        <option value="">Todos</option>
        <option value="1">Abiertos</option>
        <option value="2003">Cerrados</option>
    </select>
    Ultima Actualizacion: {{actual}}
    
    <?= $this->render('programacionSemanal',[
        'IdProceso'=>$IdProceso,
        'IdArea'=>$IdArea
    ]);?>
</div>