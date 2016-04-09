app.controller('Produccion2', function($scope, $filter, $modal, $http, $log, $timeout){
    
    $scope.CountRegistros = function(){
        return $http.get('count-produccion',{params:{
            IdArea:$scope.IdArea,
            IdSubProceso:$scope.IdSubProceso
        }}).success(function(data){
            $scope.TotalRegistros = parseInt(data);
            if($scope.index == undefined){
                $scope.index = $scope.TotalRegistros - 1;
                $scope.loadProduccion();
            }
            $timeout(function() {$scope.CountRegistros();}, 10000);
        });
    };
    
    $scope.confirm = function(){
        var r = confirm("¿Realmente desas eliminar el registro?");
        console.log(r);
        return r;
    };
    
    $scope.buscar = function(){
        where = '';
        if($scope.transaccion != 1){
            where = 'IdInventario IN (SELECT dbo.InventarioTransferencias.IdInventario FROM dbo.InventarioTransferencias)';
        }
        
        return $http.get('get-inventarios',{params:{limit:50,offset:$scope.index,where:where}})
        .success(function(data){
            $scope.inventario = data[0];
        });
    };
    
    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.show($scope.index - 1);
        }
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.TotalRegistros-1){
            $scope.show($scope.index + 1);
        }
    };
    
    $scope.First = function(){
        $scope.show(0);
    };
    
    $scope.Last = function(){
        $scope.show($scope.TotalRegistros-1);
    };
    
    $scope.show = function(index){
        $scope.index = index;
        $scope.loadProduccion();
    };
    
    $scope.addProduccion = function(){
        $scope.produccion = [];
    };
    
    $scope.loadProduccion = function(){
        return $http.get('get-producciones',{params:{
            limit:1,
            offset:$scope.index,
            where:{
                IdArea:$scope.IdArea,
                IdSubProceso:$scope.IdSubProceso
            }
        }}).success(function(data){
            $scope.mostrar = true;
            $scope.produccion = data[0];
            
            $scope.produccion.produccionesDetalles.forEach(function(value,key){
                $scope.produccion.produccionesDetalles[key].Inicio = new Date(value.Inicio.substring(0,16));
                $scope.produccion.produccionesDetalles[key].Fin = new Date(value.Fin.substring(0,16));
            });
            
            $scope.loadProgramacion();
        });
    };
    
    $scope.findProduccion = function(data){
        var guardar = true;

        return $http.get('find-produccion',{params:{
            where:{
                Fecha: $scope.Fecha,
                IdArea:$scope.IdArea,
                IdMaquina:$scope.IdMaquina,
                IdCentroTrabajo:$scope.IdCentroTrabajo,
                IdEmpleado:$scope.IdEmpleado,
                IdTurno:$scope.IdTurno,
                IdSubProceso:$scope.IdSubProceso
            }
        }}).success(function(data){
        console.log(data);
            if(data === 'false'){
                $scope.saveProduccion();
            }else{
                $scope.index = data;
                $scope.loadProduccion();
            }
        });
    };
    
    $scope.saveProduccion = function (){
        console.log($scope.produccion,$scope.IdMaquina);
        return $http.get('save-produccion',{params:{
            Fecha: $scope.Fecha,
            IdArea:$scope.IdArea,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdTurno:$scope.IdTurno,
            IdSubProceso:$scope.IdSubProceso,
            IdAleacion:$scope.IdAleacion,
            IdProduccionEstatus:1
        }}).success(function(data) {
            $scope.index = undefined;
            $scope.CountRegistros();
        }).error(function(){
            $scope.addAlert('Error al intentar guardar la produccion','danger');
        });
    };
    
    $scope.loadProgramacion = function(timeout){
        if($scope.control === false){
            return $timeout(function() {$scope.loadProgramacion(true);}, 3000);
        }
        
        if($scope.produccion === undefined){
            data = {
                Dia: $scope.Fecha,
                IdArea: $scope.IdArea,
                IdSubProceso: $scope.IdSubProceso,
                IdTurno: $scope.IdTurno,
                IdCentroTrabajo: $scope.IdCentroTrabajo
            };
        }else{
            data = {
                Dia: $scope.produccion.Fecha,
                IdArea: $scope.produccion.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                IdTurno: $scope.produccion.IdTurno,
                IdCentroTrabajo: $scope.produccion.IdCentroTrabajo
            };
        }
        
        return $http.get('programacion',{params:data}).success(function(data) {
            $scope.programaciones = data;
            if(timeout === true){
                $timeout(function() {$scope.loadProgramacion(true);}, 50000);
            }
        });
    };
    
    $scope.loadDefectos = function(){
        return $http.get('defectos',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea,
            }}).success(function(data){
            $scope.defectos = data;
        });
    };
    
    $scope.loadRetrabajo = function(){
        return $http.get('inventario',{params:{data: 'IdArea = ' + $scope.IdArea + ' AND IdCentroTrabajo IN (53,54)'}
        }).success(function(data) {
            $scope.retrabajos = data;
            $timeout(function() {$scope.loadRetrabajo();}, 30000);
        }).error(function(){
            $timeout(function() {$scope.loadRetrabajo();}, 30000);
        });
    };
    
    $scope.loadMaterial = function(){
        return $http.get('material',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea
            }}).success(function(data) {
            $scope.materiales = data;
        });
    };
    
    $scope.loadCentros = function(){
        $http.get('centros-trabajo',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.centros = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadMaquinas = function(){
        $http.get('maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea,
            IdCentroTrabajo:$scope.IdCentroTrabajo
        }}).success(function(data){
            $scope.maquinas = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadEmpleados = function(depto){
        $http.get('empleados',{params:{
            depto:depto
        }}).success(function(data){
            $scope.empleados = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadTurnos = function(){
        $http.get('turnos').success(function(data){
            $scope.turnos = data;
        }).error(function(){
            
        });
    };
    
    $scope.addDetalle = function(programacion){
        if($scope.produccion.IdProduccion !== null){
            $scope.inserted = {
                Fecha: $scope.produccion.Fecha,
                IdProduccionDetalle: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdProgramacion: programacion.IdProgramacion,
                IdProductos: programacion.IdProducto,
                Inicio: new Date(),
                Fin: new Date(),
                CiclosMolde: programacion.CiclosMolde || 0,
                PiezasMolde: programacion.PiezasMolde || 0,
                Programadas: programacion.Programadas || 0,
                FechaMoldeo: programacion.FechaMoldeo || '',
                Hechas: 0,
                Rechazadas: 0,
                IdEstatus: programacion.IdEstatus,
                Eficiencia: $scope.produccion.idMaquina.Eficiencia,
                idProductos: {Identificacion:programacion.Producto}
            };
            $scope.produccion.produccionesDetalles.push($scope.inserted);
            $scope.saveDetalle($scope.produccion.produccionesDetalles.length - 1);
        }
    };
    
    $scope.saveDetalle = function(index){
        $scope.produccion.produccionesDetalles[index].Fecha = $scope.produccion.Fecha;
        return $http.get('save-detalle',{params:$scope.produccion.produccionesDetalles[index]}).success(function(data) {
            data.Inicio = new Date(data.Inicio);
            data.Fin = new Date(data.Fin);
            $scope.produccion.produccionesDetalles[index] = data;
            $scope.loadProgramacion();
        }).error(function(){
            $scope.loadProduccion();
        });
    };
    
    $scope.saveRechazo = function(index){
        $scope.produccion.produccionesDetalles[index].produccionesDefectos[0].IdProduccionDetalle = $scope.produccion.produccionesDetalles[index].IdProduccionDetalle;
        
        return $http.get('save-rechazo',{params:$scope.produccion.produccionesDetalles[index].produccionesDefectos[0]}).success(function(data) {
            $scope.produccion.produccionesDetalles[index] = data;
        }).error(function(){});
    };
    
    $scope.deleteRetrabajo = function(index){
        return $http.get('delete-retrabajo',{params:$scope.produccion.produccionesDetalles[index]}).success(function(data) {
            $scope.produccion.produccionesDetalles.splice(index,1);
        }).error(function(){});
    };
    
    $scope.saveDetalleConsumo = function(IdProduccionDetalle,IdMaterialVaciado,index){
        return $http.get('save-consumo-detalle',{params:{
                IdProduccionDetalle:IdProduccionDetalle,
                IdMaterialVaciado:IdMaterialVaciado
            }}).success(function(data) {
            data.Inicio = new Date(data.Inicio);
            data.Fin = new Date(data.Fin);
            
            $scope.produccion.produccionesDetalles[index] = data;
        }).error(function(){});
    };
    
    $scope.addConsumo = function() {
        if($scope.IdMaterial === undefined){
            return;
        }
        
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdMaterialVaciado: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdMaterial: $scope.IdMaterial,
                Cantidad: $scope.Cantidad
            };
            
            $scope.produccion.materialesVaciados.push($scope.inserted);
            $scope.saveConsumo($scope.produccion.materialesVaciados.length-1);
        }
    };
    
    $scope.saveConsumo = function(index){
        return $http.get('save-consumo',{params:$scope.produccion.materialesVaciados[index]}).success(function(data) {
            $scope.produccion.materialesVaciados[index] = data;
        }).error(function(){});
    };
    
    $scope.deleteDetalle = function(index){
        if(!$scope.confirm())
            return;
        return $http.get('delete-detalle',{params:{IdProduccionDetalle: $scope.produccion.produccionesDetalles[index].IdProduccionDetalle}}).success(function(data) {
            $scope.produccion.produccionesDetalles.splice(index,1);
        }).error(function(){
            
        });
    };
    
    $scope.deleteConsumo = function(index){
        if(!$scope.confirm())
            return;
        return $http.get('delete-consumo',{params:{IdMaterialVaciado: $scope.produccion.materialesVaciados[index].IdMaterialVaciado}}).success(function(data) {
            $scope.produccion.materialesVaciados.splice(index,1);
        }).error(function(){
            alert('No se puede eliminar el material debido a que esta siendo utilizado');
        });
    };
});