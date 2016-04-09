/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

app.controller('Inventarios', function($scope, $filter, ngTableParams, $http, $timeout, worker){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    
    $scope.index = undefined;
    $scope.indexInventario;
    $scope.IdSerie;
    $scope.alerts = [];
    
    $scope.loadExistencias = function(){
        return $http.get('inventario',{params:{
            IdCentroTrabajo: $scope.inventario.IdCentroTrabajo || 1
        }}).success(function(data){
            if(data.length > 0){
                /*$http.get('get-producto',{params:{
                    IdProducto:IdProducto
                }}).success(function(data){
                    $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada.idProducto = data;
                }).error(function(){
                    
                });*/
                $scope.Existencias = data;
            }else{
                $scope.Existencias = [];
                $scope.addAlert('No hay productos para transferencias','warning');
            }
        }).error(function(){
            
        });
    };
    
    $scope.CountRegistros = function(transacciones){
        /*return worker.callWebWorker('/fimex/moldeo-acero/count-inventario',{transaccion:transacciones},10000).then(function(data){
            $scope.TotalRegistros = parseInt(data);
            if($scope.index == undefined){
                $scope.index = $scope.TotalRegistros - 1;
                $scope.loadInventario();
            }
        }).catch(function(){
            
        });*/
        return $http.get('count-inventario',{params:{transaccion:transacciones}})
        .success(function(data){
            $scope.TotalRegistros = parseInt(data);
            if($scope.index == undefined){
                $scope.index = $scope.TotalRegistros - 1;
                $scope.loadInventario();
            }
            $timeout(function() {$scope.CountRegistros(transacciones);}, 10000);
        });
    };
    
    $scope.loadInventario = function(){
        where = 'Transaccion = ' + $scope.transaccion;
        
        return $http.get('get-inventarios',{params:{
            limit:1,offset:$scope.index,where:where}})
        .success(function(data){
            $scope.inventario = data[0];
            $scope.loadExistencias();
        });
    };
    
    $scope.getSeries = function(index){
        $scope.indexInventario = index;
        if($scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida != undefined){
            return $http.get('get-series',{params:{
                IdSubProceso: $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.IdSubProceso,
                IdProducto: $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.IdProducto,
                IdCentroTrabajo: $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.IdCentroTrabajo
            }}).success(function(data){
                $scope.series = data;
            }).error(function(){

            });
        }
    };
    
    $scope.existeSerie = function(index){
        var val = true
        $scope.inventario.inventarioTransferencias.forEach(function(transferencias,key){
            if(transferencias.idInventarioMovimientoEntrada.serieMovimientos != undefined){
                transferencias.idInventarioMovimientoEntrada.serieMovimientos.forEach(function(value,key){
                    if($scope.series[index].IdSerie === value.idSerie.IdSerie){
                        val = false;
                    }
                });
            }
        });
        
        return val;
    };
    
    $scope.addSerie = function(IdSerie){
        $http.get('save-serie-movimiento',{params:{
            IdSerie:IdSerie,
            IdInventarioMovimiento:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada.IdInventarioMovimiento
        }}).success(function(data){
            $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada = data;
        }).error(function(){
            
        });
        
        $http.get('save-serie-movimiento',{params:{
            IdSerie:IdSerie,
            IdInventarioMovimiento:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.IdInventarioMovimiento
        }}).success(function(data){
            $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida = data;
        }).error(function(){
            
        });
    };
    
    $scope.deleteSerie = function(IdSerie){
        $http.get('delete-serie-movimiento',{params:{
            IdSerie:IdSerie,
            IdInventarioMovimiento:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada.IdInventarioMovimiento,
            Tipo:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada.Tipo
        }}).success(function(data){
            $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoEntrada = data;
        }).error(function(){
            
        });
        
        $http.get('delete-serie-movimiento',{params:{
            IdSerie:IdSerie,
            IdInventarioMovimiento:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.IdInventarioMovimiento,
            Tipo:$scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida.Tipo
        }}).success(function(data){
            $scope.inventario.inventarioTransferencias[$scope.indexInventario].idInventarioMovimientoSalida = data;
        }).error(function(){
            
        });
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
        $scope.loadInventario();
    };
    
    $scope.loadProductos = function(){
        return $http.get('productos',{params:{
            IdPresentacion:$scope.IdArea
        }})
        .success(function(data){
            $scope.productos = data;
        });
    };
    
    $scope.saveRuta = function(index){
        var rutas = $filter('filter')($scope.centrosDestino, $scope.filtro);
        
        return $http.get('save-ruta',{params:{
            data: rutas[index]
        }}).success(function(data){
            $scope.loadCentro();
        });
    };
    
    $scope.loadCentro = function(){
        return $http.get('centro-trabajo-rutas',{params:{
            IdArea:$scope.IdArea
        }}).success(function(data){
            var IdCentroTrabajoOrigen = '';
            var IdSubProceso = '';
            
            $scope.centrosDestino = data;
            
            $scope.centrosOrigen = [];
            $scope.centrosSubProcesos = [];
            
            Origen = $filter('orderBy')($scope.centrosDestino,'IdCentroTrabajoOrigen');
            Origen.forEach(function(value,key){
                if(value.IdCentroTrabajoOrigen !== IdCentroTrabajoOrigen){
                    IdCentroTrabajoOrigen = value.IdCentroTrabajoOrigen;
                    $scope.centrosOrigen.push(value);
                }
            });
            
            subProcesos = $filter('orderBy')($scope.centrosDestino,'IdSubProceso');
            subProcesos.forEach(function(value,key){
                if(value.IdSubProceso !== IdSubProceso){
                    IdSubProceso = value.IdSubProceso;
                    $scope.centrosSubProcesos.push(value);
                }
            });

        });
    };
    
    $scope.loadAleacionTipo = function(){
        return $http.get('aleacion-tipo').success(function(data){
            $scope.AleacionesTipo = data;
        });
    };
    
    $scope.loadCentrosTrabajo = function(){
        return $http.get('centros-trabajo',{params:{
            IdArea:$scope.IdArea
        }}).success(function(data){
            $scope.centros = data;
        });
    };
    
    $scope.loadSubProcesos = function(){
        return $http.get('sub-procesos').success(function(data){
            $scope.SubProcesos = data;
        });
    };
    
    $scope.addMovimiento = function(transferencia,data){
        if(transferencia == true){
            $scope.inserted = {
                IdInventario: $scope.inventario.IdInventario,
                IdInventarioMovimientoEntrada: null,
                IdInventarioMovimientoSalida: null,
                IdInventarioTransferencia: null,
                idInventarioMovimientoSalida: {
                    FechaMoldeo: data.FechaMoldeo,
                    IdCentroTrabajo: data.IdCentroTrabajo,
                    IdInventario: $scope.inventario.IdInventario,
                    IdProducto: data.IdProducto,
                    IdSubProceso: data.IdSubProceso,
                    Observaciones: null,
                    Tipo: "S",
                    idCentroTrabajo: {
                        Descripcion: data.Descripcion
                    },
                    idProducto: {
                        Identificacion: data.Identificacion,
                        LlevaSerie: data.LlevaSerie,
                        idAleacion: {
                            IdAleacionTipo:data.IdAleacionTipo
                        }
                    },
                    idSubProceso: {
                        Descripcion: data.SubProceso
                    }
                },
                idInventarioMovimientoEntrada: {
                    FechaMoldeo: data.FechaMoldeo,
                    IdCentroTrabajo: data.IdCentroTrabajo,
                    IdInventario: $scope.inventario.IdInventario,
                    IdProducto: data.IdProducto,
                    IdSubProceso: data.IdSubProceso,
                    Observaciones: null,
                    Tipo: "E",
                    idProducto: {
                        Identificacion: data.Identificacion,
                        LlevaSerie: data.LlevaSerie
                    }
                }
            };
            $scope.inventario.inventarioTransferencias.push($scope.inserted);
            $scope.saveMovimiento($scope.inventario.inventarioTransferencias.length - 1);
        }else{
            $scope.inserted = {
                Cantidad: null,
                Existencia: null,
                FechaMoldeo: null,
                IdCentroTrabajo: null,
                IdInventario: null,
                IdInventarioMovimiento: null,
                IdProducto: null,
                IdSubProceso: null,
                Observaciones: null,
                Tipo: null
            };
            $scope.inventario.inventarioMovimientos.push($scope.inserted);
        }
    };
    
    $scope.buscarSubproceso = function(data,campo,campos2,IdCentroTrabajo){
        var val;
        data.forEach(function(value, key){
            if(value[campo] == IdCentroTrabajo){
                val = value[campo2];
            }
        });
        return val;
    };
    
    $scope.addInventario = function(){
        $scope.inventario.Transaccion = $scope.transaccion;
        $http.get('save-inventario',{params:$scope.inventario}).success(function(data){
            $scope.index = undefined;
            $scope.CountRegistros($scope.transaccion);
        });
    };
    
    $scope.updateInventario = function(){
        $http.get('save-inventario',{params:{
            Fecha: $scope.inventario.Fecha,
            IdCentroTrabajo: $scope.inventario.IdCentroTrabajo,
            IdEmpleado: $scope.inventario.IdEmpleado,
            IdEstatusInventario: $scope.inventario.IdEstatusInventario,
            IdInventario: $scope.inventario.IdInventario,
            IdSubProceso: $scope.inventario.IdSubProceso,
            Transaccion: $scope.inventario.Transaccion
        }}).success(function(data){
        });
    };
    
    $scope.addAlert = function(msg,type) {
        $scope.alerts.push({
            msg: msg,
            type: type
        });
        $timeout(function() {$scope.alerts.splice($scope.alerts.length-1, 1);}, 5000);
    };
    
    $scope.saveMovimiento = function(index){
        type='warning';
        
        if($scope.transaccion == 1){
            data = $scope.inventario.inventarioMovimientos[index];
            if(data.IdSubProceso == ''){
                $scope.addAlert('No se ha seleccionado el Subproceso',type);
                return;
            }
            if(data.IdCentroTrabajo == ''){
                $scope.addAlert('No se ha seleccionado el almacen de entrada',type);
                return;
            }
            if(data.cantidad == ''){
                $scope.addAlert('No se ha seleccionado cantidad',type);
                return;
            }
        
            return $http.get('save-movimiento',{params:data}).success(function(data){
                console.log(data);
                if(data.error){
                    $scope.addAlert(data.error,type);
                }else{
                    $scope.inventario.inventarioMovimientos[index] = data;
                }
            }).error(function(){
                $scope.addAlert('Se genero un error al momento  de guardar ',type);
            });
        }else{
            data = $scope.inventario.inventarioTransferencias[index];
            
            if(data.IdSubProceso == ''){
                $scope.addAlert('No se ha seleccionado el Subproceso',type);
                return;
            }
            
            data.idInventarioMovimientoSalida.Cantidad = data.idInventarioMovimientoEntrada.Cantidad * (-1);
            
            return $http.get('save-transferencia',{params:data}).success(function(data){
                if(data.error){
                    $scope.addAlert(data.error,type);
                }else{
                    $scope.inventario.inventarioTransferencias[index] = data;
                }
            }).error(function(){
                $scope.addAlert('Se genero un error al momento de guardar',type);
            });
        }
    };
    
    $scope.deleteMovimiento = function(index){
        if($scope.transaccion == 1){
            return $http.get('delete-movimiento',{params:{
                IdInventarioMovimiento: $scope.inventario.inventarioMovimientos[index].IdInventarioMovimiento
            }}).success(function(data){
                if(data.error){
                    $scope.addAlert(data.error,'warning');
                }else{
                    $scope.inventario.inventarioMovimientos.splice(index,1);
                }
            }).error(function(){
                $scope.addAlert('Se genero un error al momento  de guardar ',type);
            });
        }else{
            return $http.get('delete-transferencia',{params:{
                IdInventarioTransferencia: $scope.inventario.inventarioTransferencias[index].IdInventarioTransferencia
            }}).success(function(data){
                if(data.error){
                    $scope.addAlert(data.error,'warning');
                }else{
                    $scope.inventario.inventarioTransferencias.splice(index,1);
                }
            }).error(function(){
                $scope.addAlert('Se genero un error al momento de eliminar el registro','danger');
            });
        }
    };
    
    $scope.loadEmpleados = function(depto){
        return $http.get('empleados',{params:{depto:depto}}).success(function(data){
            $scope.empleados = data;
        });
    };
    
    $scope.afectar = function(IdInventario){
        $http.get('afectar',{params:{IdInventario:IdInventario}})
        .success(function(data){
            if(data.error){
                $scope.addAlert(data.error,'warning');
            }else{
                $scope.inventario = data[0];
                $scope.loadExistencias();
            }
        })
        .error(function(){
            
        });
    };
    
    $scope.desafectar = function(IdInventario){
        url = $scope.transaccion == 0 ? 'desafectar-transferencia' : 'desafectar';
        $http.get(url,{params:{IdInventario:IdInventario}})
        .success(function(data){
            if(data.error){
                $scope.addAlert(data.error,'warning');
            }else{
                $scope.inventario = data[0];
                $scope.loadExistencias();
            }
        })
        .error(function(){
            
        });
    };
});