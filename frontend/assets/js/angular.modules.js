var unique = function(data, key) {
    var result = [];
    for(var i=0;i<data.length;i++) {
        var value = data[i][key];
        if (result.indexOf(value) == -1) {
            result.push(value);
        }
    }
    return result;
};

var app = angular.module("programa", ['ngTable','ui.bootstrap','ngDraggable','angularFileUpload','infinite-scroll'],function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
 
  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
      
    for(name in obj) {
      value = obj[name];
        
      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }
      
    return query.length ? query.substr(0, query.length - 1) : query;
  };
 
  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
})
    .directive('fixedTableHeaders', ['$timeout', function($timeout) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                $timeout(function () {
                    container = element.parentsUntil(attrs.fixedTableHeaders);
                        element.stickyTableHeaders({ scrollableArea: container, "fixedOffset": 2 });
                }, 0);
            }
        };
    }])
    .directive('fixedHeadersFoot', ['$timeout', function($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            $timeout(function () {
                container = element.parentsUntil(attrs.fixedHeadersFoot);
                    element.fixedHeaderTable({ footer: true});
            }, 0);
        }
    };
}]).factory('method', function($http) {
    return {
        save: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        },
        del: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        },
        get: function(url,param) {
            $http.get(url,{param:param}).success(
                
            ).error(
                
            );
        }
    };
}).directive("formatDate", function(){
    return {
        require: 'ngModel',
        link: function(scope, elem, attr, modelCtrl) {
            modelCtrl.$formatters.push(function(modelValue){
                if(modelValue instanceof Date && !isNaN(modelValue.valueOf())){
                    var fecha = new Date(modelValue.getFullYear() + "-" + (modelValue.getMonth() +1) + "-" + modelValue.getDate());
                }else{
                    var fecha = new Date(modelValue);
                    var zn = fecha.getTimezoneOffset() * 1000 * 60;
                    fecha.setTime(fecha.getTime()+zn);
                }
                
                return fecha;
            });
        }
    };
}).directive("formatTime", function(){
    return {
        require: 'ngModel',
        link: function(scope, elem, attr, modelCtrl) {
            modelCtrl.$formatters.push(function(modelValue){
                if(modelValue instanceof Date && !isNaN(modelValue.valueOf())){
                    var fecha = new Date(modelValue.getFullYear() + "-" + (modelValue.getMonth() +1) + "-" + modelValue.getDate());
                }else{
                    var fecha = new Date(modelValue);
                    var zn = fecha.getTimezoneOffset() * 1000 * 60;
                    fecha.setTime(fecha.getTime()+zn);
                }
                
                return fecha;
            });
        }
    };
}).directive('modal', function () {
    return {
        template: '<div class="modal fade">' + 
              '<div class="modal-dialog modal-{{ size }}" style="{{ width }}">' + 
                '<div class="modal-content">' + 
                  '<div class="modal-header">' + 
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                    '<h4 class="modal-title">{{ title }}</h4>' + 
                  '</div>' + 
                  '<div class="modal-body" ng-transclude></div>' + 
                '</div>' + 
              '</div>' + 
            '</div>',
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:true,
        link: function postLink(scope, element, attrs) {
            scope.title = attrs.title;
            scope.width = attrs.width !== undefined ? 'width:' + attrs.width + ';' : '';
            scope.size = attrs.size !== undefined ? attrs.size : 'lg';

            scope.$watch(attrs.visible, function(value){
              if(value == true)
                $(element).modal('show');
              else
                $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function(){
              scope.$apply(function(){
                scope.$parent[attrs.visible] = true;
              });
            });

            $(element).on('hidden.bs.modal', function(){
              scope.$apply(function(){
                scope.$parent[attrs.visible] = false;
              });
            });
        }
    };
}).directive('ordenamiento', function () {
    return {
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:{
            title: '@',
            element:'@',
            arreglo:'='
        },
        controller: function($scope,$element){
            $scope.orden = function (accion){
                if(typeof dato !== 'object'){
                    var palabra = "+"+$scope.element;
                    var palabra2 = "-"+$scope.element;

                    switch(accion){
                        case 1:
                            palabra = "+"+$scope.element;
                            palabra2 = "-"+$scope.element;
                        break;
                        case 2:
                            palabra = "-"+$scope.element;
                            palabra2 = "+"+$scope.element;
                        break;
                    }

                   for (x = 0; x <= $scope.arreglo.length; x++) {

                        if (accion === 3 && ($scope.arreglo[x] === palabra || $scope.arreglo[x] === palabra2)) {
                            $scope.arreglo.splice(x,1);
                            return;
                        };

                        if ($scope.arreglo[x] === palabra2) {
                            $scope.arreglo[x] = palabra;
                            return;
                        }else if($scope.arreglo[x] === palabra){return;};

                    }
                    $scope.arreglo.push(palabra);
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

                for (x = 0; x <= $scope.arreglo.length; x++) {
                    if (accion === 3 && ($scope.arreglo[x] === palabra || $scope.arreglo[x] === palabra2)) {
                        mostrar = true;
                        return mostrar;
                    };
                    if ($scope.arreglo[x] === palabra2) {
                        return mostrar;
                    }else if($scope.arreglo[x] === palabra){
                        mostrar = false;
                        return mostrar;
                    };
                }
                return mostrar;
            };
        },
        template: '<span>{{title}}<br />'+
            '<span ng-click="orden(1)" class="seleccion glyphicon glyphicon-triangle-bottom" aria-hidden="true"ng-show="mostrarBoton(\'{{element}}\',1);"></span>'+
            '<span ng-click="orden(2)" class="seleccion glyphicon glyphicon-triangle-top" aria-hidden="true" ng-show="mostrarBoton(\'{{element}}\',2);"></span>'+
            '<span ng-click="orden(3)" class="seleccion glyphicon glyphicon-remove" aria-hidden="true" ng-show="mostrarBoton(\'{{element}}\',3);"></span></span>'
        
    };
}).directive('btnPlus', function () {
    return {
        restrict: 'E',
        transclude: true,
        replace:true,
        template: '<button type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>'
        
    };
}).directive('btnSave', function () {
    return {
        restrict: 'E',
        transclude: true,
        replace:true,
        template: '<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>'
    };
}).directive('btnDelete', function () {
    return {
        restrict: 'E',
        transclude: false,
        replace:true,
        scope:true,
        scope:true,
        template: '<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
        
    };
}).directive('btnMinus', function () {
    return {
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:true,
        template: '<button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>'
        
    };
});
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
    $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
    $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
}]);
app.directive('scrolly', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var raw = element[0];
            element.bind('scroll', function () {
                console.log(raw.scrollTop + raw.offsetHeight, raw.scrollHeight);
                if ((raw.scrollTop + raw.offsetHeight)+10 > raw.scrollHeight) {
                    scope.$apply(attrs.scrolly);
                }
            });
        }
    };
});
app.service('dataService',function($q,$http){
    this.get = function(url,params){
        var defered = $q.defer();
        var promise = defered.promise;
        
        $http.get(url,{params:params})
        .success(function(data) {
            defered.resolve(data);
        })
        .error(function(err) {
            defered.reject(err);
        });
        
        return promise;
    };
    
    this.post = function(url,params){
        var defered = $q.defer();
        var promise = defered.promise;
        
        $http.post(url,params)
        .success(function(data) {
            defered.resolve(data);
        })
        .error(function(err) {
            defered.reject(err);
        });
        
        return promise;
    };
    
    this.urlConnect = function(url) {
        var worker = new Worker('js/worker.js');
        var defer = $q.defer();
        worker.onmessage = function(e) {           
            defer.resolve(e.data);
            //worker.terminate();
        };
        
        worker.onerror = function (e) {
            alert(e.data);
        };

        worker.postMessage(url);
        return defer.promise;
    };
});

app.service('worker',function($q){
    
    this.workers = [];
    this.callWebWorker = function (url,params,time) {
        this.workers.push(new Worker('http://localhost/fimex/frontend/assets/js/worker.js'));
        index = this.workers.length - 1;
        var defer = $q.defer();
        this.workers[index].onmessage = function(e) {           
            defer.resolve(e.data);
            //worker.terminate();
        };

        this.workers[index].postMessage({
            url:url,
            params:params,
            time:time
        });
        return defer.promise;
    };
});

app.service('prod',function(dataService){
    
    this.CountRegistros = function(params){
        return dataService.get('count-produccion',params);
    };
    
    this.loadProduccion = function(){
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
    
    this.findProduccion = function(data){
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
    
    this.saveProduccion = function (){
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
});

app.filter('precision',function(){
    return function(val) {
        return isNaN(Math.ceil(val)) ? '' : Math.ceil(val);
    };
});