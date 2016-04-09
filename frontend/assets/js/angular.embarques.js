app.controller('Embarques', function($scope, $filter, $http){
    $scope.arr = [];
    
    $scope.loadEmbarques = function(){
        $http.get('get-embarques',{params:{
            Fecha:$scope.Fecha,
            FechaFin:$scope.FechaFin,
            IdArea:$scope.IdArea
        }})
        .success(function(data){
            $scope.embarques = data;
            $scope.Fechas = unique($scope.embarques, 'Fecha');
            $scope.Clientes = unique($scope.embarques, 'Cliente');
            console.log($scope.Clientes);
        }).error(function(){
            
        });
    };
    
    $scope.loadClientes = function(){
        $http.get('get-clientes',{params:{IdArea:$scope.IdArea}})
        .success(function(data){
            $scope.clientes = data;
        }).error(function(){
            
        });
    };
    
    $scope.loadPedidos = function(){
        $http.get('get-pedidos',{params:{IdArea:$scope.IdArea}}).success(function(data){
            $scope.pedidos = data;
            console.log($scope.pedidos);
        }).error(function(){
            
        });
    };
    
    $scope.saveEmbarque = function(embarque,nuevo){
        duplicado = false;
        if(nuevo){
            embarque.Fecha = $scope.Fecha;
        }
        console.log(embarque);
        $scope.embarques.forEach(function(value, key){
            if(value.IdPedido == embarque.IdPedido && nuevo == true){
                duplicado = true;
            }
        });
        
        if(duplicado == true){
            alert("No se puede programar el mismo pedido en el mismo dia");
            return false;
        }
        
        $http.get('save-embarque',{params:embarque}).success(function(data){
            $scope.loadEmbarques();
        }).error(function(data){
            alert("Error al momento de guardar");
        });
    };
    
    $scope.deleteEmbarque = function(index){
        $http.get('delete-embarque',{params:{IdEmbarque:$scope.embarques[index].IdEmbarque}}).success(function(data){
            $scope.loadEmbarques();
        }).error(function(){
        });
    };
});