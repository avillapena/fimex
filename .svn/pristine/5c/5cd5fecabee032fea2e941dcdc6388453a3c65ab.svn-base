app.controller('Certificados', function ($scope, $filter, $modal, $http, $log, $timeout){

    /*$scope.certificados = [{
        Fecha: new Date(),
        IdCertificado:null,
        IdTipoCertificado:null,
        OrdenCompra:null,
        Observaciones:null,
        IdProduccionEstatus:null,
    }];*/

    $scope.certificados = [];
    $scope.DatosSeries = '';
    $scope.DatosFechaMoldeo = '';
    $scope.DatosFechas = '';
    $scope.Aleacion = '';
    $scope.AnioAnalisis = '';
    $scope.arraySeries = [];
    $scope.arrayIdSeries = [];
    $scope.mostrar = true;
    $scope.detalles = [];

    $scope.CountRegistros = function(){
        return $http.get('count-certificados',{params:{
        }}).success(function(data){
            $scope.TotalRegistros = parseInt(data);
            if($scope.index == undefined){
                $scope.index = $scope.TotalRegistros - 1;
                $scope.loadCertificados();
            }
            $timeout(function() {$scope.CountRegistros();}, 10000);
        });
    };

    $scope.CountCertificados = function(){
        return $http.get('count-certificados',{params:{IdTipoCertificado:10}}).success(function(data){
            $scope.countcerty = [];
            $scope.countcerty = data;
            console.log($scope.countcerty);
            if ($scope.countcerty == '') {
                $scope.countcerty.IdCertificado = '';
            };
           
            if($scope.index == undefined){
                $scope.index = $scope.countcerty.length - 1;
                $scope.loadCertificados();
            }
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
        $scope.loadCertificados();
    };

    $scope.loadCertificados = function(){
        return $http.get('certificados',{params:{
            limit:1,
            offset:$scope.index
        }}).success(function(data){  
            $scope.certificados = data[0];
        });
    };

    $scope.addCertificado = function(){
       // certificados = null;
       var defaultForm = {
            //Fecha:$scope.certificados.Fecha,
            IdCertificado:null,
            IdTipoCertificado:null,
            //OrdenCompra:null,
            //Observaciones:null,
            //IdProduccionEstatus:null,
        };
       // $scope.editableForm.$setPristine();
        $scope.certificados = defaultForm;
        /*$scope.inserted = {
            Fecha:$scope.certificados.Fecha,
            IdCertificado:null,
            IdTipoCertificado:null,
            OrdenCompra:null,
            Observaciones:null,
            IdProduccionEstatus:null,
        };
        $scope.certificados.push($scope.inserted);*/
    };

    $scope.saveCertificado = function(){ 
        return $http.get('save-certificados',{params:{
            DatosCertificado:{
                Fecha: $scope.Fecha,
                OrdenCompra: $scope.OrdenCompra,
                IdTipoCertificado: $scope.IdTipoCertificado,
                NoCerty: $scope.nocerty,
                IdNorma: $scope.Norma,
                Factura:$scope.Factura,
            },
        }}).success(function(data) {
            if(data == 'false'){
                alert("No se pudo generar el certificado");
            }else{
                $scope.certificados = data;
            }
            //$scope.CountCertificados();
        }); 
    };

    $scope.deleteCertificado = function(){
        return $http.get('delete-certificado',{params:{
            IdCertificado:$scope.certificados.IdCertificado
        }}).success(function(data){
            $scope.countcerty.splice($scope.index,1);
            $scope.Prev();
        });
    };

    $scope.loadPedidosCliente = function(){
        return $http.get('pedidos-cliente',{params:{
            OrdenCompra: $scope.OrdenCompra, //4500673438,
        }})
        .success(function(data){  
            $scope.pedidos = [];
            $scope.pedidos = data;
        });
    };

    $scope.loadDatosCertificado = function(){
        return $http.get('datos-certificado',{params:{
            OrdenCompra: $scope.OrdenCompra, //4500673438,
        }})
        .success(function(data){  
            $scope.certificados = [];
            $scope.certificados = data;
        });
    };

    /*$scope.TipoCerty = function(){
        console.log($scope.IdTipoCertificado);
        //$scope.IdCentroTrabajo = tipo;
        //console.log("f "+$scope.IdCentroTrabajo);
    };*/
    
    /*$scope.$watch(
        "IdTipoCertificado2",
        function TipoCerty(){
            alert(1);
            console.log(2);
        }
    );*/

    $scope.buscar = function(){
        $scope.showModal = !$scope.showModal;
    };

    $scope.TipoCerty = function(){
        console.log($scope.Tipo);
        return $http.get('coladas',{params:{
            //IdProductos: $scope.IdProducto, //4500673438,
        }})
        .success(function(data){  
            $scope.coladas = [];
            $scope.coladas = data;
        });
    };

    $scope.loadColadas = function(){
        return $http.get('coladas',{params:{
            IdProductos: $scope.IdProducto, //4500673438,
        }})
        .success(function(data){  
            $scope.coladas = [];
            $scope.coladas = data;
        });
    };

    $scope.loadSeries = function(){
        colada = $scope.Colada.split("-");
        return $http.get('series',{params:{
            Colada: colada[0], //4500673438,
            IdProducto: $scope.IdProducto,
        }})
        .success(function(data){  
            $scope.listadoseries = [];
            $scope.listadoseries = data;
            $scope.Aleacion = $scope.listadoseries[0].Aleacion;
            //$scope.IdAleacion = $scope.listadoseries[0].IdAleacion;
        });
    };

    $scope.loadTiposCerty = function(){
        return $http.post('tipos-certy',{
        }).success(function(data){
            $scope.tiposcerty = [];
            $scope.tiposcerty = data;
        });
    };

    //$scope.SaveCertificado = function(){
    $scope.SaveCertificadoExtras = function(){
    
        $scope.selectedSeries = [];
        count = 0;
        $('input[name="Series[]"]:checked').each(function() {
            $scope.selectedSeries.push($(this).val());
            //$scope.DatosSeries =  $scope.selectedSeries+",";
            count++;
        });

        $scope.arraySeries = [];
        $scope.arrayIdSeries = [];
        series = '';
        angular.forEach($scope.selectedSeries, function(value, key) {
            series = value.split("-");
            $scope.arrayIdSeries.push(series[0]);
            $scope.arraySeries.push(series[1]);
        });
        console.log($scope.arrayIdSeries);

        $scope.selectedFechas = [];
        $('input[name="Fechas[]"]:checked').each(function() {
            $scope.selectedFechas.push($(this).val());
            $scope.DatosFechas =  $scope.selectedFechas+",";
        });
      
        coladas = $scope.Colada.split("-");
        Colada = Rellenar(coladas[0], 4);

        return $http.get('save-certificados-extras',{params:{
            Series:JSON.stringify($scope.arrayIdSeries),
            DatosCertificado:{
                Fecha: $scope.Fecha,
                Colada: Colada,
                Aleacion: $scope.Aleacion,
                IdLance: coladas[1],
                OrdenCompra: $scope.OrdenCompra,
                IdTipoCertificado: $scope.IdTipoCertificado,
                AnioAnalisis: $scope.AnioAnalisis,
                IdProducto: $scope.IdProducto,
                Cantidad: count,
                Realizo: $scope.Realizo,
                Inspecciono: $scope.Inspecciono,
                Aprobo: $scope.Aprobo,
                NoCerty: $scope.nocerty,
                Procedimiento: $scope.Procedimiento,
                IdNorma: $scope.Norma,
                Factura:$scope.Factura,
            },
        }}).success(function(data) {
            $scope.certificados = data;
        });
    };

    $scope.loadEmpleados = function(){
        return $http.get('empleados',{params:{
            IdDepartamento: 32, 
        }})
        .success(function(data){  
            $scope.empleados = [];
            $scope.empleados = data;
        });
    };

    $scope.loadNormas = function(){
        return $http.post('normas',{
            }).success(function(data){
            $scope.normas = [];
            $scope.normas = data;
        });
    };

    $scope.loadNumCertificado = function(){
        return $http.post('num-certificado',{
            }).success(function(data){
            $scope.numcerty = [];
            $scope.nocerty = data;
            //console.log($scope.nocerty);
        });
    };

    $scope.loadNumCliente = function(){
        
        return $http.get('num-cliente',{params:{
            OrdenCompra: $scope.OrdenCompra, //4500673438,
        }})
        .success(function(data){  
            $scope.nocliente = data;
            console.log($scope.nocliente);
        });
    };

    $scope.loadUrl = function(tipo){     
        coladas = $scope.Colada.split("-");
        Colada = Rellenar(coladas[0], 4)
        
        $scope.selectedSeries = [];
        count = 0;
        $('input[name="Series[]"]:checked').each(function() {
            $scope.selectedSeries.push($(this).val());
            //$scope.DatosSeries =  $scope.selectedSeries+",";
            count++;
        });
        
        $scope.arraySeries = [];
        series = '';
        angular.forEach($scope.selectedSeries, function(value, key) {
            series = value.split("-");
            $scope.arraySeries.push(series[1]);
        });
        
        count = 0;
        $scope.selectedFechaMoldeo = [];
        $('input[name="Fechas[]"]:checked').each(function() {
            $scope.selectedFechaMoldeo.push($(this).val());
            $scope.DatosFechaMoldeo =  $scope.selectedFechaMoldeo+",";
            count++;
        });

        //var collectionDate = 'Wed Feb 10 2016 00:00:00 GMT-0600'; 
        $scope.newDate = new Date($scope.Fecha);

        if(tipo == 1){
            window.open('http://servidorcont:8181/birt/frameset?__report=Certy_Gral.rptdesign&__format=pdf&Fecha='+$scope.newDate+'&Colada='+Colada+'&IdProducto='+$scope.IdProducto+'&OrdenCompra='+$scope.OrdenCompra+'&Series='+$scope.DatosSeries+'&Aleacion='+$scope.Aleacion+'&Realizo='+$scope.Realizo+'&Aprobo='+$scope.Aprobo+'&AnioAnalisis='+$scope.AnioAnalisis+'&Norma='+$scope.Norma+'&TipoCerty=10','_blank');   
        }else{
            window.open('http://servidorcont:8181/birt/frameset?__report=Certificados.rptdesign&__format=pdf&Fecha='+$scope.newDate+'&Colada='+Colada+'&IdProducto='+$scope.IdProducto+'&OrdenCompra='+$scope.OrdenCompra+'&Series='+$scope.DatosSeries+'&Aleacion='+$scope.Aleacion+'&Realizo='+$scope.Realizo+'&Aprobo='+$scope.Aprobo+'&AnioAnalisis='+$scope.AnioAnalisis+'&Norma='+$scope.Norma+'&TipoCerty='+$scope.IdTipoCertificado,'_blank');   
        }
    };

});

function Rellenar(str, max) {
    str = str.toString();
    return str.length < max ? Rellenar("0" + str, max) : str;
}


/******************************************
*           Controlador de Tratamientos Termicos
*******************************************/
app.controller('Certificadostt', function ($scope, $filter, $modal, $http, $log, $timeout){
    
    $scope.detalles = [];
    $scope.indexDetalle = null;
    $scope.index = 0;
    $scope.indexcert = 0;
	$scope.IdArea = 2;
    $scope.Prev = function(){
        if($scope.index > 0 ){
            $scope.index -= 1;
        }
        $scope.show();
        console.log($scope.index);
    };

    $scope.loadcertificado = function(){

         return $http.post('certificaodos',{
               
            }).success(function(data){
            $scope.certificados = data;
        });

    }
    
    $scope.Next = function(){
        if($scope.index < $scope.certificados.length-1  ){
            $scope.index += 1;
        }
        $scope.show();
    };
    
    $scope.First = function(){
        $scope.index = 0;
        $scope.show();
    };
    
    $scope.Last = function(){
        console.log($scope.certificados);
        $scope.index = $scope.certificados.length - 1;
        $scope.show();
    };
    
    $scope.show = function(){
        $scope.coladas = [];
        $scope.loadCertificado();

        
        $scope.indexDetalle = null;
         
        //$scope.loadData();
    }

    $scope.init=function(cb){
        $scope.mostrar = true;
        $scope.loadOC();
        $scope.loadMaquinas();
        $scope.loadTurnos();
        $scope.loadenfriamientos();
        $scope.loadCentros();
        $scope.loadEmpleados('1-7');
        console.log("init");
        cb(  $scope.init2 );
    }
    $scope.init2=function(c){
        $scope.loadTratamientosTermicos();
        $scope.loadCertificadosInit();
        
       console.log("init2");
       

    }
   
    //abre lista de cerificados 
     $scope.loadCertificados = function(){

         return $http.post('certificadostt',{
               
            }).success(function(data){
            $scope.certificados = data;
        });

     }
     $scope.loadCertificadosInit = function(){

         return $http.post('certificadostt',{
               
            }).success(function(data){
            $scope.certificados = data;
            $scope.index = $scope.certificados.length-1;
            
            return $http.post('certificadottdata',{
               IdCertificadoTT: $scope.certificados[$scope.index].IdCertificadoTT
            }).success(function(data){
            $scope.ctt = data;
            $scope.loadTratamientoTermico($scope.ctt.IdTratamientoTermico);
             $scope.loaddetallecertificadott();
            });

        });

     }
      $scope.loadCertificado = function(){
        $scope.loadCertificados();
         return $http.post('certificadottdata',{
               IdCertificadoTT: $scope.certificados[$scope.index].IdCertificadoTT
            }).success(function(data){
            $scope.ctt = data;
            $scope.loadTratamientoTermico($scope.ctt.IdTratamientoTermico);
             $scope.loaddetallecertificadott();
        });

     }

      $scope.loadOC = function(){

         return $http.post('oc',{

     	 	IdArea  : $scope.IdArea,
               
            }).success(function(data){
            $scope.oc_s = data;
        });

     }


      $scope.loadProducto = function(){

         return $http.post('producto',{
         
               oc : $scope.detalles[$scope.indexcert].OrdenDeCompra,
               IdArea  : $scope.IdArea
               
            }).success(function(data){
            $scope.productos  = [];
            $scope.productos = data;
            
        	});

     }

     $scope.loaddetallecertificadott = function(){
        

         return $http.post('loaddetallecertificadott',{
               id :  $scope.ctt.IdCertificadoTT,
            }).success(function(data){
            $scope.detalles  = [];
            $scope.detalles = data;

            $scope.loadProducto();
            
            $scope.detalles[$scope.indexcert].descripcion =  $scope.detalles[$scope.indexcert].idProducto.Descripcion;
            $scope.detalles[$scope.indexcert].material = $scope.detalles[$scope.indexcert].idProducto.material;// no carga
            $scope.setAleacion();
                $scope.loadcolada();
                $scope.loadserie();
                 
            
            });

     }

     //abre lista de  tratamientos
     $scope.loadTratamientosTermicos= function(){

         return $http.post('tratamientostermicos',{
               
            }).success(function(data){
            $scope.tratamientos  = [];
            $scope.tratamientos = data;
            
            });

     }

     // abre  el tratamiento seleccionado del combo
    $scope.loadTratamientoTermico = function(tt){
            // alert("tratamientotermico "+tt);
        return $http.post('tratamientotermico',{
               IdtratamientoTermico : tt,
            }).success(function(data){
            $scope.produccion  = [];
            $scope.produccion = data;

            
            });
    }

      $scope.IdArea = 2;
      $scope.loadMaquinas = function(todos){
        IdSubProceso = todos !== undefined ? null : $scope.IdSubProceso;
        return $http.get('/fimex/angular/maquinas',{params:{
            IdSubProceso:$scope.IdSubProceso,
            IdArea:$scope.IdArea,
            IdAreaAct: $scope.IdAreaAct,
            IdCentroTrabajo:$scope.IdCentroTrabajo
        }}).success(function(data){
            $scope.maquinas = data;
        });
    };
    $scope.loadTurnos = function(){
        return $http.get('/fimex/produccion-acero/turnos',{}).success(function(data) {
            $scope.turnos = data;
        });
    };
    $scope.loadenfriamientos = function(){
        return $http.get('/fimex/produccion-acero/ttenfriamientos',{params:{
                
            }}).success(function(data) {
            $scope.enfriamientos = [];
            $scope.enfriamientos = data;
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
     $scope.loadEmpleados = function(depto){
        return $http.get('/fimex/angular/empleados',{params:{depto:depto}})
        .success(function(data){
            $scope.empleados = data;
        });
    };  
     
    $scope.setProducto = function(){
     		
     		return $http.post('productodesc',{
     	 
               producto : $scope.detalles[$scope.indexcert].idProducto.Identificacion,
               
            }).success(function(data){
            	
            	$scope.detalles[$scope.indexcert].descripcion = data[0].Descripcion;
            	$scope.detalles[$scope.indexcert].material = data[0].IdAleacion;
            	$scope.setAleacion();
                $scope.loadcolada();
            	
                
        	});

     }

      $scope.setAleacion= function(){
     		
     		return $http.post('productoaleacion',{
     	 
               material : $scope.detalles[$scope.indexcert].material,
               
            }).success(function(data){
            	
            	$scope.detalles[$scope.indexcert].material = data[0].Descripcion;
            	
        	});

     }

     $scope.loadcolada=function(){

     	return $http.post('colada',{
     	 
               producto : $scope.detalles[$scope.indexcert].idProducto.Identificacion,
               
               
            }).success(function(data){
            	
            $scope.coladas  = [];
            $scope.coladas = data;
            	$scope.loadserie();
        	});

     }

       $scope.loadserie=function(){

     	return $http.post('serie',{
     	 
               producto : $scope.detalles[$scope.indexcert].idProducto.Identificacion, 
               // colada : $scope.detalles[$scope.indexcert].Colada,
               colada : $scope.coladas
              
               
            }).success(function(data){
            	
            $scope.serie  = [];
            $scope.serie = data;
            	
        	});

     }
     
     $scope.selectColada=function(colada){
    	 	
     		 $scope.loadserie();
     		 
     }

     $scope.selectSerie=function(){
    	 	
     		 $scope.detalles[$scope.indexcert].cantidad   =  $scope.detalles[$scope.indexcert].serie.length;
     		 
     } 



      $scope.addDetalle = function(){
        if ($scope.detalles.length >= 1) { alert("solo se puede especificar un  #parte por certificado"); return;  };
        // if($scope.produccion.IdProduccion != null){
            $scope.inserted = {
                oc : null,
                cantidad : null,
                producto : null,
                descripcion : null,
                material : null,
                colada : null,
                serie : null,
                notas : null,
            };
            $scope.detalles.push($scope.inserted);
            //$scope.saveDetalle($scope.detalles.length - 1);
         }

        $scope.saveDetalle = function(index){

                
            $scope.select = [];
            $scope.DatosSeries = "";
             $('input[name="Series[]"]:checked').each(function() {
                    $scope.select.push($(this).val());
                    $scope.DatosSeries =  $scope.select+",";
              });
           
           
             $scope.DatosSeries =  $scope.DatosSeries.slice(0, $scope.DatosSeries.length-1) ;


            $scope.select = [];
            $('input[name="Colada[]"]:checked').each(function() {
                    $scope.select.push($(this).val());
                    $scope.DatosColada =  $scope.select+",";
              });
     
             $scope.DatosColada =  $scope.DatosColada.slice(0, $scope.DatosColada.length-1) ;

        	return $http.post('savecertificadottdetalle',{

                IdCertificadoTTDetalle: $scope.ctt.IdCertificadoTTDetalle,
                IdCertificadoTT : $scope.ctt.IdCertificadoTT,
     	 		Idtratamiento : $scope.ctt.Nott,
                OrdenDeCompra : $scope.detalles[index].OrdenDeCompra,
                Cantidad : $scope.detalles[index].Cantidad,
                producto : $scope.detalles[index].idProducto.Identificacion,
                descripcion : $scope.detalles[index].descripcion,
                material : $scope.detalles[index].material,
                // colada : $scope.detalles[index].colada,
                colada : $scope.DatosColada,
                // serie : $scope.detalles[index].serie,
                serie : $scope.DatosSeries,
                notas : $scope.detalles[index].notas,
              
               
            }).success(function(data){
            	
           		alert("salvado Detalle");
                $scope.loaddetallecertificadott();
            	
        	});

        
    	};

        $scope.deleteDetalle = function(index){

            return $http.post('deletecertificadottdetalle',{
                IdCertificadoTTDetalle: $scope.detalles[index].IdCertificadoTTDetalle ,
                
            }).success(function(data){

                alert("borrado detalle");
                $scope.loaddetallecertificadott();
                
            });
        }
        $scope.addCertTratamientos = function(){

            $scope.ctt = [];
            $scope.detalles = [];
            $scope.serie = [];


        }

        $scope.SaveCertTTratamientos = function(){

            return $http.post('savecertificadott',{
                NoCert: $scope.ctt.NoCert ,
                Cliente : $scope.ctt.Cliente ,
                Fecha : $scope.ctt.Fecha.getFullYear()+'-'+$scope.ctt.Fecha.getMonth()+'-'+$scope.ctt.Fecha.getDate(), 
                IdTratamientoTermico : $scope.ctt.NoTT,
            }).success(function(data){
                
                alert("salvado");
                
            });

        };

       

        $scope.estacolada = function(colada){

            coladas = $scope.detalles[$scope.indexcert].certTTColadas;
            if (coladas == null) return 0;
            for(x=0; x< coladas.length;x++){
  
                if ( coladas[x].Colada == colada){
                    return 1;
                }
  
            }
            return 0;
        }

        $scope.estaserie = function(serie){

             coladas = $scope.detalles[$scope.indexcert].certTTSeries;
             if (coladas == null) return 0;
            for(x=0; x< coladas.length;x++){
  
                if ( coladas[x].Serie == serie){
                    return 1;
                }
  
            }
            return 0;
        }

        $scope.buscarCerTT = function(){

        return $http.get('busquedacertt')
        .success(function(data){
            $scope.busquedas = data;
        });

        }

        $scope.loadPdf = function(){

             window.open('http://servidorcont:8080/birt/frameset?__report=tratamientos.rptdesign&__format=pdf&IdCertificadoTT='+$scope.certificados[$scope.index].IdCertificadoTT,'_blank');   
        }

});