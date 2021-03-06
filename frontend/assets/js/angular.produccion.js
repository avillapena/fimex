app.controller('Produccion', function($scope, $filter, $modal, $http, $log, $timeout){
    //$scope.Fecha = new Date();
    $scope.control = false;
    $scope.produccion = [{
        Fecha: new Date(),
        IdArea: null,
        IdCentroTrabajo:null,
        IdEmpleado:null,
        IdTurno:null,
        IdMaquina:null,
        IdProduccion:null,
        IdProduccionEstatus:null,
        IdSubProceso:null,
    }];

    $scope.arr = [];
    $scope.aleaciones = [];
    $scope.changes = [];
    $scope.busquedas = [];
    $scope.maquinas = [];
    $scope.centrosTrabajo = [];
    $scope.empleados = [];
    $scope.defectos = [];
    $scope.fallas = [];
    $scope.materiales = [];
    $scope.turnos = [];
    
    //Catalogos para las Capturas
    
    $scope.programaciones = [];
    $scope.programacionEmpaque = [];
    $scope.detalles = [];
    $scope.rechazos = [];
    $scope.almasRechazos = [];
    $scope.consumos = [];
    $scope.TiemposMuertos = [];
    $scope.temperaturas = [];
    
    $scope.mostrar = false;
    $scope.showModal = false;
    $scope.delete = false;
    $scope.newLance = true;
    
    $scope.index = undefined;
    $scope.indexAlmasDetalle = undefined;
    $scope.indexProgramacion = null;
    $scope.indexDetalle = null;
    $scope.indexMaquina = null;
    
    $scope.aleacionSelect = null;
    $scope.maquinaSelect = null;
	
	 $scope.campostt= false;

    $scope.maintenance = function(){
        alert("test");
    };

    $scope.confirm = function(){
        var r = confirm("¿Realmente desas eliminar el registro?");
        return r;
    };
    
    $scope.alerts = [];
    
    $scope.addAlert = function(msg,type) {
        $scope.alerts.push({
            msg: msg,
            type: type
        });
        $timeout(function() {$scope.alerts.splice($scope.alerts.length-1, 1);}, 5000);
    };

    $scope.closeAlert = function(index) {
        $scope.alerts.splice(index, 1);
    };
    
    $scope.countProducciones = function(IdSubProceso,IdArea){
        return $http.post('count-produccion',{
            IdSubProceso:IdSubProceso,
            IdArea:IdArea
        }).success(function(data){
            $scope.producciones = [];
            $scope.producciones = data;
            if($scope.index === undefined){
                $scope.index = $scope.producciones.length - 1;
                $scope.loadProduccion();
            }
        });
    };
    
    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.show($scope.index - 1);
        }
    };
    
    $scope.Next = function(){
        if($scope.index < $scope.producciones.length-1  ){
            $scope.show($scope.index + 1);
        }
    };
    
    $scope.First = function(){
        $scope.show(0);
    };
    
    $scope.Last = function(){
        $scope.show($scope.producciones.length - 1);
    };
    
    $scope.show = function(index){
        $scope.getChanges();
        if($scope.changes.length > 0){
            respuesta = confirm("¿Deseas guardar los cambios en el reporte?");
            if(respuesta){
                var res = $scope.saveChanges();
                
                if(!res)
                    return $scope.addAlert('Error al intentar guardar la produccion','danger');
            }
            $scope.changes = [];
        }
        
        $scope.index = index;
        $scope.loadProduccion();
        if($scope.produccion.IdProduccionEstatus != 1){
            $scope.mostrar = false;
        }else{
            $scope.mostrar = true;
        }
        $scope.almasRechazos = [];
        $scope.rechazos = [];
        $scope.indexDetalle = null;
        $timeout(function() {$scope.loadProgramacion();}, 1000);
        //$scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
    };
    
    $scope.buscarIndex = function(IdProduccion){
        console.log("entro");
        $scope.producciones.forEach(function(value,key){
            console.log(value,IdProduccion);
            if(value.IdProduccion == IdProduccion){
                $scope.show(key);
            }
        });
        //$scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
    };
    
    $scope.reset = function(){
        $scope.limitBusqueda = 15;
        $scope.offsetBusqueda = 0;
        $scope.busquedas = [];
        console.log("entro");
    };
    
    $scope.buscar = function(filtro){
        if(!$scope.showModal){
            $scope.filtro = [];
            $scope.showModal = !$scope.showModal;
            $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
            $scope.limitBusqueda = 15;
            $scope.offsetBusqueda = 0;
            $scope.busquedas = [];
        }
        
        $scope.filtro = filtro;
        
        console.log(filtro);
        
        return $http.get('produccion',{params:{
            filtro:$scope.filtro,
            busqueda: true,
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea,
            limit:$scope.limitBusqueda,
            offset:$scope.offsetBusqueda
                
        }}).success(function(data){
            console.log($scope.filtro);
            if(data.length > 0){
                data.forEach(function(value, key){
                    $scope.busquedas.push(value);
                });
                $scope.offsetBusqueda += $scope.limitBusqueda;
                //$scope.buscar();
            }
        });
    };
    
    $scope.buscar2 = function(){
        $scope.showModal2 = !$scope.showModal2;
    };
    
    $scope.getChanges = function(){
        $scope.changes = [];
        
        for(x=0;x < $scope.detalles.length; x++){
            console.log($scope.detalles[x]);
            if($scope.detalles[x].change == true){
                if($scope.IdSubProceso == 2 || $scope.IdSubProceso == 3){
                    save = 'saveAlmasDetalle('+x+')';
                }else{
                    save = 'saveDetalle('+x+')';
                }
                $scope.changes.push(save);
            }
        }
        
        for(x=0;x < $scope.almasRechazos.length; x++){
            console.log($scope.almasRechazos[x]);
            if($scope.almasRechazos[x].change == true){
                $scope.changes.push('saveAlmaRechazo('+x+')');
            }
        }
        
        for(x=0;x < $scope.rechazos.length; x++){
            console.log($scope.rechazos[x]);
            if($scope.rechazos[x].change == true){
                $scope.changes.push('saveRechazo('+x+')');
            }
        }
        
        for(x=0;x < $scope.temperaturas.length; x++){
            console.log($scope.temperaturas[x]);
            if($scope.temperaturas[x].change == true){
                $scope.changes.push('saveTemperatura('+x+')');
            }
        }
        
        for(x=0;x < $scope.TiemposMuertos.length; x++){
            if($scope.TiemposMuertos[x].change == true){
                $scope.changes.push('saveTiempo('+x+')');
            }
        }

        console.log($scope.changes);
    };
    
    $scope.saveChanges = function(){
        for(x=0;x < $scope.changes.length; x++){
            $scope.$eval($scope.changes[x]);
        }
        return true;
    };
    
    $scope.loadData = function(){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina == $scope.produccion.IdMaquina){
                $scope.indexMaquina = key;
            }
        });
        $scope.produccion.IdSubProceso == 2 || $scope.produccion.IdSubProceso == 3 || $scope.produccion.IdSubProceso == 4 ? $scope.loadAlmasDetalle() : $scope.loadDetalle();
        $scope.loadConsumo();
        $scope.loadTemperaturas();
        $scope.loadTiempos();
        $scope.loadProgramacionesAlmas($scope.produccion.Fecha);
        console.log("soraya1 "+$scope.produccion.Fecha);
    };

    $scope.loadEmpleados = function(depto){
        return $http.get('/fimex/angular/empleados',{params:{depto:depto}}).success(function(data){
            $scope.empleados = data;
        });
    };
    
    $scope.loadMaquinas = function(){
        return $http.get('/fimex/angular/maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea,
            IdCentroTrabajo:$scope.IdCentroTrabajo
        }}).success(function(data){
            $scope.maquinas = data;
        });
    };
    
    $scope.loadCentros = function(){
        return $http.get('/fimex/angular/centros-trabajo',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.centros = data;
        });
    };
    
    $scope.loadTurnos = function(){
        return $http.get('/fimex/angular/turnos',{}).success(function(data) {
            $scope.turnos = data;
        });
    };
    
    $scope.loadAleaciones = function(){
        return $http.get('aleaciones',{params:$scope.produccion}).success(function(data) {
            $scope.aleaciones = data;
        });
    };
    
    $scope.selectMaquina = function(index){
        $scope.maquinas.forEach(function(value, key) {
            if(value.IdMaquina === $scope.produccion.IdMaquina){
                return $scope.indexMaquina = key;
            }
        });
    };

    $scope.selectTurnos = function(){
        $scope.turnos.forEach(function(value, key) {
            if(value.IdTurno === $scope.produccion.IdTurno){
                return $scope.indexTurno = key;
            }
        });
    };
    
    /********************************************************************
     *                        MATTO HORNOS
     *******************************************************************/
    
    $scope.getData = function() {
        $http.get('mant-hornos').success(function(data){
            $scope.datos = [];
            $scope.datos = data;
        });
   };
    
    $scope.addMtto = function(mtto){
        console.log(mtto);

        
        $http.get('save-hornos',{params:mtto}).success(function(data){
            $scope.getData();
            $scope.mtto = [];
        });
    };
    
    /********************************************************************
     *                        ENCABEZADO DE PRODUCCION
     *******************************************************************/

    $scope.loadProduccion = function(){
        return $http.post('/fimex/angular/produccion',{IdProduccion:$scope.producciones[$scope.index].IdProduccion}).success(function(data){
            $scope.mostrar = true;
            $scope.produccion = data;
            $scope.control = true
            $scope.loadData();
        }).error(function(){$scope.control = true});
    };

    $scope.deleteProducciones = function(){
        return $http.get('delete-producciones',{params:{
            IdProduccion:$scope.produccion.IdProduccion
        }}).success(function(data){
            $scope.producciones.splice($scope.index,1);
            $scope.Prev();
        });
    };
    
    $scope.findProduccion = function(data){
        var guardar = true;
        $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        return $http.get('/fimex/angular/find-produccion',{params:{
            Fecha: $scope.Fecha,
            IdArea:$scope.IdArea,
            IdMaquina:$scope.IdMaquina,
            IdCentroTrabajo:$scope.IdCentroTrabajo,
            IdEmpleado:$scope.IdEmpleado,
            IdTurno:$scope.IdTurno,
            IdSubProceso:$scope.IdSubProceso
        }}).success(function(data){
            if(data !== 'null' && $scope.IdSubProceso !== 10){
                for(x = 0;x < $scope.producciones.length;x++){
                    if(data.IdProduccion === $scope.producciones[x].IdProduccion){
                        console.log('entro');
                        $scope.index = x;
                        $scope.loadProduccion();
                        $scope.loadProgramacion();
                        guardar = false;
                    }
                }
            }
            if(guardar === true) $scope.saveProduccion();
        });
    };
    
    $scope.addProduccion = function(){
        $scope.detalles = [];
        $scope.rechazos = [];
        $scope.almasRechazos = [];
        $scope.consumos = [];
        $scope.TiemposMuertos = [];
        $scope.temperaturas = [];
        $scope.inserted = {
            IdProduccion:null,
            Fecha: $scope.produccion.Fecha,
            IdArea: $scope.IdArea,
            IdCentroTrabajo:null,
            IdEmpleado:null,
            IdMaquina:null,
            IdTurno:$scope.IdTurno,
            IdProduccionEstatus:1,
            IdSubProceso:$scope.IdSubProceso,
            lances:{IdAleacion:$scope.IdAleacion}
        };
        $scope.produccion = $scope.inserted;
        console.log($scope.produccion);
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
            IdAleacion:$scope.IdAleacion
        }}).success(function(data) {
            $scope.produccion = data;
            $scope.index = undefined;
            $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        }).error(function(){
            $scope.addAlert('Error al intentar guardar la produccion','danger');
        });
    };
    
    $scope.updateProduccion = function (){
        return $http.get('save-produccion',{params:$scope.produccion}).success(function(data){
            $scope.produccion = data;
            $scope.countProducciones($scope.IdSubProceso,$scope.IdArea);
        });
    };
    
    /********************************************************************
     *                        DETALLE DE PRODUCCION
     *******************************************************************/
    
    $scope.loadDetalle = function(){
        return $http.get('detalle',{params:{
                IdProduccion: $scope.produccion.IdProduccion
            }}).success(function(data){
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };
    
    /*$scope.Eficiencia = function(index){
        if($scope.detalles[index].IdProduccion == $scope.produccion.IdProduccion){
            var fechaIni = new Date($scope.produccion.Fecha+" "+$scope.detalles[index].Inicio);
            minutos = parseInt(($scope.detalles[index].Programadas / $scope.detalles[index].CiclosMolde)/60);
            FechaEstimada = new Date(fechaIni.getFullYear(),fechaIni.getMonth(),fechaIni.getDate(),fechaIni.getHours(),fechaIni.getMinutes()+minutos,fechaIni.getSeconds());
            $scope.detalles[index].TiempoEstimado = FechaEstimada;
            console.log(FechaEstimada);
            
            $scope.detalles[index].CalculoEficiencia = 0;
            console.log($scope.detalles[index]);
            $timeout(function() {$scope.Eficiencia(index);}, 10000);
        }
    };*/
    
    $scope.addDetalle = function(){
        if($scope.produccion.IdProduccion !== null){
            if($scope.produccion.IdTurno === $scope.programaciones[$scope.indexProgramacion].IdTurno){
                $scope.inserted = {
                    Fecha: $scope.produccion.Fecha,
                    IdProduccionDetalle: null,
                    IdProduccion:$scope.produccion.IdProduccion,
                    IdProgramacion:$scope.programaciones[$scope.indexProgramacion].IdProgramacion,
                    IdProductos:$scope.programaciones[$scope.indexProgramacion].IdProductoCasting,
                    Inicio:null,
                    Fin:null,
                    CiclosMolde: $scope.programaciones[$scope.indexProgramacion].CiclosMolde,
                    PiezasMolde: $scope.programaciones[$scope.indexProgramacion].PiezasMolde,
                    Programadas: $scope.programaciones[$scope.indexProgramacion].Programadas,
                    FechaMoldeo: $scope.programaciones[$scope.indexProgramacion].FechaMoldeo || '',
                    Hechas: 0,
                    Rechazadas: 0,
                    Eficiencia: $scope.produccion.IdMaquina.Eficiencia,
                    idProductos: {Identificacion:$scope.programaciones[$scope.indexProgramacion].ProductoCasting}
                };
                $scope.detalles.push($scope.inserted);
                $scope.saveDetalle($scope.detalles.length - 1);
            }else{
                return $scope.addAlert('Solo puede agregar produccion del mismo Turno','warning');
            }
        }
    };
    
    $scope.saveDetalle = function(index){
        if($scope.controlClick('detalles',index)){
            $scope.detalles[index].Fecha = $scope.produccion.Fecha;
            return $http.get('save-detalle',{params:$scope.detalles[index]}).success(function(data) {
                $scope.detalles[index] = data;
                $scope.loadProgramacion();
            }).error(function(){$scope.detalles[index]['active'] = undefined});
        }
    };
    
    $scope.deleteDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.detalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-detalle',{params:dat}).success(function(data) {
                //$scope.loadDetalle();
                $scope.detalles.splice(index,1);
            }).error(function(){
            return $scope.addAlert('Error al intentar guardar la captura de producto','danger');
        });
        }
    };
    
    $scope.selectDetalle = function(index){
        if($scope.indexDetalle !== null){
            $scope.detalles[$scope.indexDetalle].Class = "";
            $scope.indexDetalle = null;
        }
        $scope.indexDetalle = index;
        $scope.detalles[$scope.indexDetalle].Class = "info";
        $scope.loadRechazos();
        $scope.loadAlmasRechazos();
    };

    /********************************************************************
     *                        PROGRAMACION
     *******************************************************************/
    $scope.loadProgramacion = function(timeout){
        if($scope.control === false){
            return $timeout(function() {$scope.loadProgramacion(true);}, 3000);
        }
        
        var IdTurno = $scope.IdSubProceso === 10 ? null : $scope.produccion.IdTurno;
        return $http.get('programacion',{params:{
            Dia: $scope.produccion.Fecha || $scope.Fecha,
            IdArea: $scope.IdArea,
            IdSubProceso: $scope.IdSubProceso,
            IdTurno: IdTurno,
            IdCentroTrabajo: $scope.produccion.IdCentroTrabajo
        }}).success(function(data) {
            $scope.programaciones = [];
            $scope.programaciones = data;
            console.log(data);
            if(timeout === true){
                $timeout(function() {$scope.loadProgramacion(true);}, 50000);
            }
        });
    };
    
    $scope.loadProgramacionEmpaque = function(){
        return $http.get('programacion - empaque',{params:{
                IdArea: $scope.IdArea,
                IdSubProceso: $scope.produccion.IdSubProceso,
                //IdMaquina: $scope.produccion.IdMaquina,
            }}).success(function(data) {
            $scope.programacionEmpaque = [];
            $scope.programacionEmpaque = data;
            $timeout(function() {$scope.loadProgramacionEmpaque();}, 50000);
			});
    };
    
    $scope.actualizarProgramacion = function(){
        return $http.get('save-programacion',{
            params:$scope.programaciones[$scope.indexProgramacion]
        }).success(function(data) {
        });
    };
    
    $scope.selectProgramacion = function(index){
        if($scope.indexProgramacion != null){
            $scope.indexProgramacion = null;
        }
        $scope.indexProgramacion = index;
    };
    
    /********************************************************************
     *                        CONTROL DE RECHAZO
     *******************************************************************/
    
    $scope.loadDefectos = function(){
        return $http.get('/fimex/angular/defectos',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea,
            }}).success(function(data){
            $scope.defectos = [];
            $scope.defectos = data;
        });
    };
    
    $scope.loadRechazos = function(){
        return $http.get('rechazos',{params:{
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle,
            }}).success(function(data) {
            $scope.rechazos = [];
            $scope.rechazos = data;
        });
    };
    
    $scope.addRechazo = function(){
        if($scope.indexDetalle != null){
            $scope.inserted = {
                IdProduccionDefecto: null,
                IdProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdProduccionDetalle,
                IdDefectoTipo:null,
                Rechazadas:0
            };
            $scope.rechazos.push($scope.inserted);
        }else{
            $scope.addAlert('Primero debe guardar la produccion para poder generar rechazos','warning');
        }
    };
    
    $scope.delRechazo = function(index){
        return $http.get('del-rechazo',{params:{IdProduccionDefecto:$scope.rechazos[index].IdProduccionDefecto}}).success(function(data) {
            $scope.rechazos.splice(index,1);
        });
    };
    
    $scope.saveRechazo = function(index){
        if($scope.controlClick('rechazos',index)){
            return $http.get('save-rechazo',{params:$scope.rechazos[index]}).success(function(data) {
                $scope.rechazos[index] = data;
                $scope.loadDetalle();
            }).error(function(){$scope.rechazos[index]['active'] = undefined});
        }
    };
    /********************************************************************
     *                        CONTROL DE FALLAS
     *******************************************************************/
    
    $scope.loadFallas = function(){
        return $http.get('fallas',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea
            }}).success(function(data) {
            $scope.fallas = [];
            $scope.fallas = data;
        });
    };
    
    $scope.loadTiempos = function(){
        return $http.get('tiempos',{params:{
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: $scope.produccion.Fecha,
                IdEmpleado: $scope.produccion.IdEmpleado,
                IdTurno: $scope.produccion.IdTurno,
            }}).success(function(data) {
            $scope.TiemposMuertos = [];
            $scope.TiemposMuertos = data;
        });
    };
    
    $scope.deleteTiempo = function(index){
        if($scope.confirm()){
            var dat = $scope.TiemposMuertos[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-tiempo',{params:dat}).success(function(data) {
                $scope.TiemposMuertos.splice(index,1);
            });
        }
    };
    
    $scope.addTiempo = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdTiempoMuerto: null,
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: $scope.produccion.Fecha,
                IdCausa: null,
                Inicio:'00:00',
                Fin:'00:00',
                Descripcion:'',
                IdTurno: $scope.produccion.IdTurno,
                IdEmpleado: $scope.produccion.IdEmpleado
            };
            $scope.TiemposMuertos.push($scope.inserted);
            //$scope.TiemposMuertos($scope.TiemposMuertos.length - 1);
        }
    };
    
    $scope.saveTiempo = function(index){
        if($scope.controlClick('TiemposMuertos',index)){
            if(($scope.TiemposMuertos[index].Incio !== '00:00' && $scope.TiemposMuertos[index].Fin !== '00:00') || $scope.TiemposMuertos[index].IdCausa !== null){
                return $http.get('save-tiempo',{params:$scope.TiemposMuertos[index]}).success(function(data) {
                    $scope.TiemposMuertos[index] = data;
                }).error(function(){$scope.TiemposMuertos[index]['active'] = undefined});
            }
        }
    };
    
    /********************************************************************
     *                        CONTROL DE CONSUMOS
     *******************************************************************/
    
    $scope.loadMaterial = function(){
        return $http.get('material',{params:{
                IdSubProceso: $scope.IdSubProceso,
                IdArea: $scope.IdArea,
            }}).success(function(data) {
            $scope.materiales = [];
            $scope.materiales = data;
        });
    };
    
    $scope.loadConsumo = function(){
        return $http.get('consumo',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.consumos = [];
            $scope.consumos = data;
        });
    };
    
    $scope.deleteConsumo = function(index){
        if($scope.confirm()){
            var dat = $scope.consumos[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-consumo',{params:dat}).success(function(data) {
                $scope.consumos.splice(index,1);
            });
        }
    };
    
    $scope.addConsumo = function(consumo) {
        console.log(consumo);
        if(consumo == undefined){
            consumo = {
                IdMaterial: null,
                Cantidad: 0
            };
        }
        
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdMaterialVaciado: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdMaterial: consumo.IdMaterial,
                Cantidad: consumo.Cantidad
            };
            $scope.consumos.push($scope.inserted);
        }
    };
    
    $scope.saveConsumo = function(index){
        console.log(index);
        if($scope.controlClick('consumos',index)){
        //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('save-consumo',{params:$scope.consumos[index]}).success(function(data) {
                $scope.consumos[index] = data;
            }).error(function(){$scope.consumos[index]['active'] = undefined});
        }
    };
    
    $scope.saveDetalleConsumo = function(IdProduccionDetalle,IdMaterialVaciado,index){
        return $http.get('save-consumo-detalle',{params:{
                IdProduccionDetalle:IdProduccionDetalle,
                IdMaterialVaciado:IdMaterialVaciado
            }}).success(function(data) {
            $scope.detalles[index] = data;
        }).error(function(){});
    };
    
    
    
    /********************************************************************
     *                        CONTROL DE TEMPERATURAS
     *******************************************************************/
    
    $scope.loadTemperaturas = function(){
        return $http.get('temperaturas',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.temperaturas = [];
            $scope.temperaturas = data;
        });
    };
    
    $scope.deleteTemperatura = function(index){
        if($scope.confirm()){
            var dat = $scope.temperaturas[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-temperatura',{params:dat}).success(function(data) {
                $scope.temperaturas.splice(index,1);
            });
        }
    };
    
    $scope.addTemperatura = function() {
        if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                IdTemperatura: null,
                IdProduccion: $scope.produccion.IdProduccion,
                IdMaquina: $scope.produccion.IdMaquina,
                Fecha: null,
                Fecha2: $scope.produccion.Fecha,
                Temperatura: 0,
                Temperatura2: 0,
                IdEmpleado: $scope.produccion.IdEmpleado,
                Moldes: 0,
            };
            $scope.temperaturas.push($scope.inserted);
        }
    };
    
    $scope.saveTemperatura = function(index){
        if($scope.controlClick('temperaturas',index)){
            return $http.get('save-temperatura',{params:$scope.temperaturas[index]}).success(function(data) {
                if(data != false){
                    $scope.temperaturas[index] = data;
                }
            }).error(function(){$scope.temperaturas[index]['active'] = undefined});
        }   
    };
    
    /********************************************************************
     *                        DETALLE DE PRODUCCION ALMAS
    *******************************************************************/
    
    $scope.loadAlmasDetalle = function(){
        return $http.get('almas-detalle',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.detalles = [];
            $scope.detalles = data;
        });
    };

    $scope.loadProgramacionesAlmas = function(Fecha){
        console.log("soraya2 "+$scope.produccion.Fecha);
        return $http.get('programaciones-almas',{params:{
            Semana: Fecha,
        }}).success(function(data) {
            $scope.programacionalmas = [];
            $scope.programacionalmas = data;
        });
    };
    
    $scope.addAlmasDetalle2 = function() {
        //if($scope.programaciones[$scope.indexProgramacion] != undefined){
            //console.log("fff "+$scope.programaciones.IdProducto);
            if($scope.produccion.IdProduccion != null){
                $scope.inserted = {
                    Fecha: $scope.produccion.Fecha,
                    IdAlmaProduccionDetalle: null,
                    IdProduccion: $scope.produccion.IdProduccion,
                    //IdProgramacionAlma: $scope.datoslmas[$scope.indexProgramacion].IdProgramacionAlma,
                    Inicio:'',
                    Fin:'',
                    //Programadas: $scope.programaciones[$scope.indexProgramacion].Programadas,
                    Hechas: 0,
                    Rechazadas: 0,
                    /*IdAlmaTipo: $scope.programaciones[$scope.indexProgramacion].IdAlmaTipo,
                    IdProducto: $scope.programaciones[$scope.indexProgramacion].IdProducto,
                    PiezasCaja: $scope.programaciones[$scope.indexProgramacion].PiezasCaja,
                    PiezasMolde: $scope.programaciones[$scope.indexProgramacion].PiezasMolde,
                    PiezasHora: $scope.programaciones[$scope.indexProgramacion].PiezasHora,
                    idAlmaTipo: {Descripcion:$scope.programaciones[$scope.indexProgramacion].Alma},
                    idProducto: {Identificacion:$scope.programaciones[$scope.indexProgramacion].Producto},*/
                };
                $scope.detalles.push($scope.inserted);
                //$scope.saveAlmasDetalle($scope.detalles.length - 1);
            }
        /* }else{
            $scope.addAlert('Favor de seleccionar programacion');
        }*/
    };

     $scope.addAlmasDetalle = function() {
        if($scope.programaciones[$scope.indexProgramacion] != undefined){
            if($scope.produccion.IdProduccion != null){
                $scope.inserted = {
                    Fecha: $scope.produccion.Fecha,
                    IdAlmaProduccionDetalle: null,
                    IdProduccion:$scope.produccion.IdProduccion,
                    IdProgramacionAlma:$scope.programaciones[$scope.indexProgramacion].IdProgramacionAlma,
                    Inicio:'',
                    Fin:'',
                    Programadas: $scope.programaciones[$scope.indexProgramacion].Programadas,
                    Hechas: 0,
                    Rechazadas: 0,
                    IdAlmaTipo:$scope.programaciones[$scope.indexProgramacion].IdAlmaTipo,
                    IdProducto:$scope.programaciones[$scope.indexProgramacion].IdProducto,
                    PiezasCaja: $scope.programaciones[$scope.indexProgramacion].PiezasCaja,
                    PiezasMolde: $scope.programaciones[$scope.indexProgramacion].PiezasMolde,
                    PiezasHora: $scope.programaciones[$scope.indexProgramacion].PiezasHora,
                    idAlmaTipo: {Descripcion:$scope.programaciones[$scope.indexProgramacion].Alma},
                    idProducto: {Identificacion:$scope.programaciones[$scope.indexProgramacion].Producto},
                };
                $scope.detalles.push($scope.inserted);
                //$scope.saveAlmasDetalle($scope.detalles.length - 1);
            }
        }else{
            $scope.addAlert('Favor de seleccionar programacion');
        }
    };



    $scope.datosAlmas =  function(IdProducto){
        console.log("pro "+IdProducto);
        //console.log("soraya2 "+$scope.produccion.Fecha);
        return $http.get('datos-almas',{params:{
            Semana: $scope.produccion.Fecha,
            IdProducto: IdProducto,
        }}).success(function(data) {
            $scope.datoslmas = [];
            $scope.datoslmas = data;
            
            //console.log($scope.datoslmas);
        });

        /*IdProgramacionAlma: $scope.programaciones[$scope.indexProgramacion].IdProgramacionAlma,
        Inicio:'',
        Fin:'',
        Programadas: $scope.programaciones[$scope.indexProgramacion].Programadas,
        Hechas: 0,
        Rechazadas: 0,
        IdAlmaTipo: $scope.programaciones[$scope.indexProgramacion].IdAlmaTipo,
        IdProducto: $scope.programaciones[$scope.indexProgramacion].IdProducto,
        PiezasCaja: $scope.programaciones[$scope.indexProgramacion].PiezasCaja,
        PiezasMolde: $scope.programaciones[$scope.indexProgramacion].PiezasMolde,
        PiezasHora: $scope.programaciones[$scope.indexProgramacion].PiezasHora,
        idAlmaTipo: {Descripcion:$scope.programaciones[$scope.indexProgramacion].Alma},
        idProducto: {Identificacion:$scope.programaciones[$scope.indexProgramacion].Producto},*/
    };

    $scope.saveAlmasDetalle = function(index){
        if($scope.controlClick('detalles',index)){
            //console.log($scope.detalles[index]);
            $scope.detalles[index].Fecha = $scope.produccion.Fecha;
            return $http.get('save-almas-detalle',{
                params:$scope.detalles[index]
            })
            .success(function(data) {
                // if(data == false){
                //     alert('Error en el sistema: favor de notificar al area de sistemas Ext. 225')
                // }else{
                //     $scope.detalles[index] = data;
                // }
                 $scope.loadProgramacion();
                 $scope.loadAlmasDetalle();
                //console.log($scope.detalles[index]);
            }).error(function(){$scope.detalles[index]['active'] = undefined});
        }
    };
    
    $scope.saveAlmasDetalle2 = function(index){
        console.log($scope.datoslmas[0].IdProgramacionAlma);
        if($scope.controlClick('detalles',index)){
            //console.log($scope.detalles[index]);
            $scope.detalles[index].Fecha = $scope.produccion.Fecha;

            $scope.detalles[index].IdProgramacionAlma = $scope.datoslmas[0].IdProgramacionAlma;
            $scope.detalles[index].Programadas = $scope.datoslmas[0].Programadas;
            $scope.detalles[index].IdAlmaTipo = $scope.datoslmas[0].IdAlmaTipo;
            $scope.detalles[index].IdProducto = $scope.datoslmas[0].IdProducto;
            $scope.detalles[index].PiezasCaja = $scope.datoslmas[0].PiezasCaja;
            $scope.detalles[index].PiezasMolde = $scope.datoslmas[0].PiezasMolde;
            $scope.detalles[index].PiezasHora = $scope.datoslmas[0].PiezasHora;
            $scope.detalles[index].idAlmaTipo = $scope.datoslmas[0].IdAlmaTipo;
            $scope.detalles[index].idProducto = $scope.datoslmas[0].IdProducto;

            return $http.get('save-almas-detalle',{
                params:$scope.detalles[index]
            })
            .success(function(data) {
                if(data == false){
                    alert('Error en el sistema: favor de notificar al area de sistemas Ext. 225')
                }else{
                    $scope.detalles[index] = data;
                }
                $scope.loadProgramacion();
                $scope.loadAlmasDetalle();
                //console.log($scope.detalles[index]);
            }).error(function(){$scope.detalles[index]['active'] = undefined});
        }
    };
    
    $scope.deleteAlmasDetalle = function(index){
        if($scope.confirm()){
            var dat = $scope.detalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-almas-detalle',{params:dat}).success(function(data) {
                $scope.detalles.splice(index,1);
            });
        }
    };
    
    $scope.selectAlmasDetalle = function(index){
        console.log(index);
        console.log($scope.indexDetalle);
        if($scope.indexAlmaDetalle != null){
            $scope.detalles[$scope.indexDetalle].Class = "";
            $scope.indexDetalle = null;
        }
        $scope.indexDetalle = index;
        $scope.detalles[$scope.indexDetalle].Class = "info";
        $scope.loadRechazos();
    }

    /******************************************************************
    *        DETALLE DE PRODUCCION ALMA Keel Block  y probeta
    *******************************************************************/
    
    $scope.loadAlmasDetalleKP = function(){
        return $http.get('almas-detallekp',{params:{
                IdProduccion: $scope.produccion.IdProduccion,
            }}).success(function(data) {
            $scope.detallesKP = [];
            $scope.detallesKP = data;
        });
    };
    
    $scope.addAlmasDetalleKP = function() {
        if($scope.programaciones[$scope.indexProgramacion] != undefined){
            if($scope.produccion.IdProduccion != null){
                $scope.inserted = {
                    Fecha: $scope.produccion.Fecha,
                    IdAlmaProduccionDetalle: null,
                    IdProduccion:$scope.produccion.IdProduccion,
                   
                    Inicio:'',
                    Fin:'',
                    
                    Hechas: 0,
                   
                   
                    
                };
                $scope.detalles.push($scope.inserted);
                //$scope.saveAlmasDetalle($scope.detalles.length - 1);
            }
        }else{
            $scope.addAlert('Favor de seleccionar programacion');
        }
    };
    
    $scope.saveAlmasDetalleKP = function(index){
        if($scope.controlClick('detalles',index)){
            //console.log($scope.detalles[index]);
            $scope.detalles[index].Fecha = $scope.produccion.Fecha;
            return $http.get('save-almas-detallekp',{
                params:$scope.detalles[index]
            })
            .success(function(data) {
                if(data == false){
                    alert('Error en el sistema: favor de notificar al area de sistemas Ext. 225')
                }else{
                    $scope.detalles[index] = data;
                }
                
                //console.log($scope.detalles[index]);
            }).error(function(){$scope.detalles[index]['active'] = undefined});
        }
    };
    
    $scope.deleteAlmasDetalleKP = function(index){
        if($scope.confirm()){
            var dat = $scope.detalles[index];
            //$scope.detalles[index].IdProduccionDetalle = parseInt($scope.detalles[index].IdProduccionDetalle);
            return $http.get('delete-almas-detallekp',{params:dat}).success(function(data) {
                $scope.detalles.splice(index,1);
            });
        }
    };
    
    $scope.selectAlmasDetalleKP = function(index){
        if($scope.indexAlmaDetalle != null){
            $scope.detalles[$scope.indexDetalle].Class = "";
            $scope.indexDetalle = null;
        }
        $scope.indexDetalle = index;
        $scope.detalles[$scope.indexDetalle].Class = "info";
        $scope.loadRechazos();
    };
    
    /********************************************************************
     *                        CONTROL DE RECHAZO ALMAS
     *******************************************************************/
    
    $scope.loadAlmasDefectos = function(){
        return $http.get('defectos',{params:{
                IdSubProceso: 2,
            }}).success(function(data) {
            $scope.defectosAlmas = [];
            $scope.defectosAlmas = data;
        });
    };
    
    $scope.loadAlmasRechazos = function(){
        return $http.get('rechazos',{params:{
                IdAlmaProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdAlmaProduccionDetalle,
            }}).success(function(data) {
            $scope.almasRechazos = [];
            $scope.almasRechazos = data;
        });
    };
    
    $scope.addAlmasRechazo = function(){
        if($scope.indexDetalle != null){
            $scope.inserted = {
                IdAlmaProduccionDefecto: null,
                IdAlmaProduccionDetalle: $scope.detalles[$scope.indexDetalle].IdAlmaProduccionDetalle,
                IdDefectoTipo:null,
                Rechazadas:null
            };
            $scope.almasRechazos.push($scope.inserted);
        }else{
            $scope.addAlert('Primero debe guardar la produccion para poder generar rechazos','warning');
        }
    };
    
    $scope.delAlmaRechazo = function(index){
        return $http.get('delete-alma-rechazo',{params:{IdAlmaProduccionDefecto:$scope.almasRechazos[index].IdAlmaProduccionDefecto}}).success(function(data) {
            if(data){
                IdAlmaProduccionDetalle = $scope.almasRechazos[index].IdAlmaProduccionDetalle;
                $scope.almasRechazos.splice(index,1);
                $http.get('total-rechazo',{params:{IdAlmaProduccionDetalle:IdAlmaProduccionDetalle}}).success(function(data){$scope.detalles[$scope.indexDetalle].Rechazadas = data;});
            }
        });
    };
    
    $scope.saveAlmaRechazo = function(index){
        if($scope.controlClick('almasRechazos',index)){
            return $http.get('save-almas-rechazo',{params:$scope.almasRechazos[index]}).success(function(data) {
                IdAlmaProduccionDetalle = $scope.almasRechazos[index].IdAlmaProduccionDetalle;
                $scope.almasRechazos[index] = data;
                $http.get('total-rechazo',{params:{IdAlmaProduccionDetalle:IdAlmaProduccionDetalle}}).success(function(data){$scope.detalles[$scope.indexDetalle].Rechazadas = data;});
            }).error(function(){$scope.almasRechazos[index]['active'] = undefined});
        }
    };
    
    
    $scope.orden = function (dato,accion){
        if(typeof dato !== 'object'){
            var palabra = "+"+dato;
            var palabra2 = "-"+dato;

            switch(accion){
                case 1:
                    palabra = "+"+dato;
                    palabra2 = "-"+dato;
                break;
                case 2:
                    palabra = "-"+dato;
                    palabra2 = "+"+dato;
                break;
            }

           for (x = 0; x <= $scope.arr.length; x++) {

                if (accion == 3 && ($scope.arr[x] == palabra || $scope.arr[x] == palabra2)) {
                    $scope.arr.splice(x,1);
                    return;
                };

                if ($scope.arr[x] == palabra2) {
                    $scope.arr[x] = palabra;
                    return;
                }else if($scope.arr[x] == palabra){return;};

            }
            $scope.arr.push(palabra);
        }
    };
    
    $scope.mostrarBoton = function(dato,accion) {
        var palabra = "+"+dato;
        var palabra2 = "-"+dato;
        var mostrar = false;
        
        switch(accion){
            case 1:
                palabra = "+"+dato;
                palabra2 = "-"+dato;
                mostrar = true;
            break;
            case 2:
                palabra = "-"+dato;
                palabra2 = "+"+dato;
                mostrar = true;
            break;
        }
        
        for (x = 0; x <= $scope.arr.length; x++) {
            if (accion == 3 && ($scope.arr[x] == palabra || $scope.arr[x] == palabra2)) {
                mostrar = true;
                return mostrar;
            };
            if ($scope.arr[x] == palabra2) {
                return mostrar;
            }else if($scope.arr[x] == palabra){
                mostrar = false;
                return mostrar;
            };
        }
        return mostrar;
    };
    
    $scope.controlClick = function(arr,index){
        $scope[arr][index]['active'] = $scope[arr][index]['active'] == undefined ? true : $scope[arr][index]['active'];

        if($scope[arr][index]['active'] == false){
            console.log('entro y no hizo nada');
            return false;
        }
        
        $scope[arr][index]['active'] = false;
        return true;
    };
    //////////////////////////////////////////////
    ////Espacio para la funcion de INVENTARIOS////
    //////////////////////////////////////////////
    $scope.loadProductos = function(){
        return $http.get('productos')
        .success(function(data){
            $scope.productos = data['allModels'];
        });
    };
    
    $scope.loadCentro = function(){
        return $http.get('/fimex/angular/centro-trabajo',{params:{
            IdSubProceso:$scope.IdSubProceso
        }}).success(function(data){
            $scope.centros = data;
        });
    };
    
    $scope.activa = function(){
        $scope.productoInventarios = [];
    };
    
    $scope.addInventario = function(){
        $scope.inserted = {
            productos: '',
            aSalida: '',
            aEntrada:'',
            cantidad:'',
            fechaMoldeo:'',
            fechasMoldeo:'',
            porHacer:'',
            hechas:''
        };
        $scope.productoInventarios.push($scope.inserted); 
    };
    
    $scope.revisaExistencia = function(index){
        $scope.index = index;
        return $http.get('revisa-existencia',{params:{
            IdProducto:  $scope.productoInventarios[$scope.index].prods,
            fechaMoldeo: $scope.productoInventarios[$scope.index].fechaMoldeo,
            IdCentroTrabajo: $scope.IdCentroTrabajo
        }}).success(function(data){
            
            if(data.length == 0){
                $scope.productoInventarios[$scope.index].fechaMoldeo = 'No hay prouductos Disponibles';  
                porHacer = hechas = '--';
                fmoldeo = false
                
            }
            if(data.length == 1){
                $scope.productoInventarios[$scope.index].fechaMoldeo = data[0]['FechaMoldeo'];
                porHacer = data[0]['Existencia'];
                hechas = data[0]['Hecho'];
                fmoldeo = false
            }
            if(data.length > 1){
                fechaM = [];
                for(x=0;x<data.length;x++){
                    fechaM[x] = data[x];
                }
                porHacer = hechas = '--';
                fmoldeo = true
                $scope.productoInventarios[$scope.index].fechasMoldeo = fechaM;
                console.log(fechaM);
            }
            $scope.productoInventarios[$scope.index].porHacer = porHacer;
            $scope.productoInventarios[$scope.index].hechas = hechas;
            $scope.productoInventarios[$scope.index].fmoldeo = fmoldeo;
        });
    };
    
    $scope.addInventario2 = function(){
        console.log($scope.IdSubProceso);
        $http.get('/fimex/inventario/save-inventario',{params:{
            Fecha:$scope.Fecha,
            IdEmpleado:$scope.IdEmpleado,
            IdSubProceso:$scope.IdSubProceso,
            IdEstatusInventario:1
        }}).success(function(){
            
        });
    };
    
    $scope.saveInventario = function(index){
        $scope.index = index;
        msg = '';
        error = true;
        type='warning';
        if($scope.productoInventarios[$scope.index].aSalida == '')
            msg = 'No se ha seleccionado el almacen de salida';
        else{
            if($scope.productoInventarios[$scope.index].aEntrada == '')
                msg = 'No se ha seleccionado el almacen de entrada';
            else{
                if($scope.productoInventarios[$scope.index].cantidad == '')
                    msg = 'No se ha seleccionado cantidad';
                else{
                    if($scope.productoInventarios[$scope.index].cantidad > porHacer)
                        msg = 'No se puede pasar mas de las piezas en Existencia';
                    else{
                        if($scope.productoInventarios[$scope.index].cantidad > hechas){
                            if(confirm("Estas seguro que quieres sacar mas piezas de las que tienes hechas?")){                        
                                error = false;
                            }
                        }
                        else{
                            error = false
                        }
                    }
                }
            }
        }
        
        if(error){
            $scope.alerts.push({
                msg: msg,
                type: type
            });
            $timeout(function() {
                $scope.alerts.splice($scope.alerts.length-1, 1);
            }, 5000);
        }       
    };
    
    $scope.loadDivFlotante = function(){
        if($scope.IdEmpleado == "" || $scope.IdEmpleado == undefined)
            document.getElementById("msgError").innerHTML = "Es necesario selecionar un Empleado";
        else{
            if($scope.IdSubProceso == "" || $scope.IdSubProceso == undefined)
                document.getElementById("msgError").innerHTML = "Es necesario selecionar un Subproceso";
            else
                document.getElementById("completo").style.marginTop = "-100%";
        }
    };
    //////////////////////////////////////////////
    ////Espacio para la funcion de INVENTARIOS////
    //////////////////////////////////////////////


    /////////////////////////////////////
    ////Espacio para los certificados////
    /////////////////////////////////////
});