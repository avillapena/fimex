<div class="col-md-5">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="2">Celda</th>
                <th colspan="2">Lun</th>
                <th colspan="2">Mar</th>
                <th colspan="2">Mie</th>
                <th colspan="2">Jue</th>
                <th colspan="2">Vie</th>
                <th colspan="2">Sab</th>
                <th colspan="2">Total</th>
            </tr>
            <tr>
                <?php for($x = 1;$x<=6;$x++): ?>
                <th class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>">Pza</th>
                <th class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>">Ton</th>
                <?php endfor; ?>
                <th>Pza</th>
                <th>Ton</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="celda in resumenesCelda" ng-init="celda.TotalPzas=0;celda.TotalTON = 0">
                <th>{{celda.Descripcion}}</th>
                <?php for($x = 1;$x<=6;$x++): ?>
                <td class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>" ng-init="celda.TotalPzas = celda.TotalPzas + celda.Pzas<?=$x?>">{{celda.Pzas<?=$x?> }}</td>
                <td class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>" ng-init="celda.TotalTON = celda.TotalTON + celda.TON<?=$x?>">{{celda.TON<?=$x?> / 1000 | currency:"":2}}</td>
                <?php endfor; ?>
                <th>{{celda.TotalPzas}}</th>
                <th>{{celda.TotalTON / 1000 | currency:"":2}}</th>
            </tr>
        </tbody>
        <tfoot
            <tr>
                <th>Total</th>
                <?php for($x = 1;$x<=6;$x++): ?>
                <th class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>">{{sumatoria(resumenesCelda,'Pzas<?=$x?>')}}</th>
                <th class="<?=$x % 2 == 0 ? 'par' : 'impar' ?>">{{sumatoria(resumenesCelda,'TON<?=$x?>') / 1000 | currency:"":2}}</th>
                <?php endfor; ?>
                <th>{{sumatoria(resumenesCelda,'TotalPzas')}}</th>
                <th>{{sumatoria(resumenesCelda,'TotalTON') / 1000 | currency:"":2}}</th>
            </tr>
        </tfoot>
    </table>
</div>