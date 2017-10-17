var rh = angular.module('rh', []);



rh.config(function($routeProvider) {
  $routeProvider
          .when('/', 
                    {
                      templateUrl: 'views/home.html'
                      ,controller: 'home'                      
                    }
              )

          .when('/clientes/:area', 
                    {
                      templateUrl: 'views/clientes.html'
                      ,controller: 'clientes'                      
                    }
              )

          .when('/find', 
                    {
                      templateUrl: 'views/find.html'
                      ,controller: 'find'                      
                    }
              )

          .when('/horarios/:area/:cli/:cel/:turno', 
                    {
                      templateUrl: 'views/horarios.html'
                      ,controller: 'horarios'                      
                    }
              )

          .when('/turnos/:area/:cli/:cel', 
                    {
                      templateUrl: 'views/turnos.html'
                      ,controller: 'turnos'                      
                    }
              )

          .when('/detalleCli/:area/:id', 
                    {
                      templateUrl: 'views/detalleCli.html'
                      ,controller: 'detalleCli'                      
                    }
              )

          .when('/addEmpleado/:area/:cli/:cel/:turno/:horario', 
                    {
                      templateUrl: 'views/addEmpleado.html'
                      ,controller: 'addEmpleado'                      
                    }
              )

          .when('/ensamble', 
                    {
                      templateUrl: 'views/ensamble.html'
                      //,controller: 'home'                      
                    }
              )


          .when('/vulca', 
                    {
                      templateUrl: 'views/vulca.html'
                      //,controller: 'home'                      
                    }
              )

          .when('/proto', 
                    {
                      templateUrl: 'views/proto.html'
                      //,controller: 'home'                      
                    }
              )

          .when('/extru', 
                    {
                      templateUrl: 'views/extru.html'
                      //,controller: 'home'                      
                    }
              )
          
          .when('/detail/:id', 
                    {
                      templateUrl: 'views/detail.html'
                      //,controller: 'detail'
                    })
                   
          .when('/cart', 
                    {
                      templateUrl: 'views/cart.html'
                      //,controller:  'cart'                      
                    })

          
          
          .otherwise({ redirectTo: '/' });
});




rh.factory('rhData', function($rootScope, $http) {

    var obj = {};

   

  obj.broadcastItem = function(event) {
    
    $rootScope.$broadcast(event);
  };


  obj.getPedido = function(idUsu) {
      
      $http.get("/pedidos?id=" + idUsu)
           .success(         		  
              function(data)
        		  {    
                                  obj.car = data.entradas;
                                  
                                  obj.car.iPedido = data.id;
                                  
                                  obj.total = data.total;
                                  
                                  obj.broadcastItem('newTotal');
                                  obj.broadcastItem('car');
        		  }
              
        	  );
      
  };
  
  

    return obj;
});


rh.controller('index', function($scope, rhData) {
  /*
  $scope.$on('car', function() {
        $scope.car = rhData.getCar();
  });
  */




});

//filter Multiple...
rh.filter('filterMultiple',['$filter',function ($filter) {
  return function (items, keyObj) {
    var filterObj = {
              data:items,
              filteredData:[],
              applyFilter : function(obj,key){
                var fData = [];
                if(this.filteredData.length == 0)
                  this.filteredData = this.data;
                if(obj){
                  var fObj = {};
                  if(angular.isString(obj)){
                    fObj[key] = obj;
                    fData = fData.concat($filter('filter')(this.filteredData,fObj));
                  }else if(angular.isArray(obj)){
                    if(obj.length > 0){ 
                      for(var i=0;i<obj.length;i++){
                        if(angular.isString(obj[i])){
                          fObj[key] = obj[i];
                          fData = fData.concat($filter('filter')(this.filteredData,fObj));  
                        }
                      }
                      
                    }                   
                  }                 
                  if(fData.length > 0){
                    this.filteredData = fData;
                  }
                }
              }
        };

    if(keyObj){
      angular.forEach(keyObj,function(obj,key){
        filterObj.applyFilter(obj,key);
      });     
    }
    
    return filterObj.filteredData;
  }
}]);

rh.filter('unique', function() {
    return function(input, key) {
        var unique = {};
        var uniqueList = [];
        for(var i = 0; i < input.length; i++){
            if(typeof unique[input[i][key]] == "undefined"){
                unique[input[i][key]] = "";
                uniqueList.push(input[i]);
            }
        }
        return uniqueList;
    };
});

rh.controller('find', function($scope, rhData, $http) {
  console.log("find!!");

  $scope.q = {};
  $scope.q.area = "Areas";
  
  $scope.q.cli = "Clientes";
  $scope.clientes = ["Clientes"];

  $scope.q.cel = "Celulas";
  $scope.celulas = ["Celulas"];

  $scope.q.turnos = "Turnos";
  $scope.q.horarios = "Horarios";

  $scope.loadQ = function(){

    console.log("loadQ");

    $http.get("rest/ver/" + $scope.area + "/" + $scope.id).success(
      function (data) {
        //$scope.entradas = data;
        console.log(data);
      }
    );

    $scope.clientes = ["Clientes"];
    for (var i = 0; i < $scope.entradas.length; i++) {
      
      if( $scope.clientes.indexOf($scope.entradas[i].cliente) == -1 )
        $scope.clientes.push($scope.entradas[i].cliente);
      
    }

    $scope.celulas = ["Celulas"];
    for (var i = 0; i < $scope.entradas.length; i++) {
      
      if( $scope.celulas.indexOf($scope.entradas[i].celula) == -1 )
        $scope.celulas.push($scope.entradas[i].celula);
      
    }



  }



  $scope.entradas = [
    {
      "emp": {
        id_empresa: "152755",
        lname: "NAVARRO GRADO",
        fname: "EDGAR ARMANDO ",
        job: "OPERADOR B",
        category: "DIRECTOS"
      },
      "area":"VULCANIZADO", 
      "cliente":"POT 1", 
      "celula":"Operadores Cargadores", 
      "turno":"TURNO 1", 
      "horario":"A"
    },
    {
      "emp": {
        id_empresa: "155002",
        lname: "HERNANDEZ MENCHACA",
        fname: "LAURA GRISELDA ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"EXTRUSION", 
      "cliente":"Linea 1", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"A"
    },
    {
      "emp": {
        id_empresa: "154838",
        lname: "MENDOZA GARCIA",
        fname: "CHRISTIAN OMAR ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"PROTOTIPOS", 
      "cliente":"Cliente Pro", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"B"
    },
    {
      "emp": {
        id_empresa: "154831",
        lname: "HERNANDEZ ROMERO",
        fname: "CARINA IBET ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"PROTOTIPOS", 
      "cliente":"BMW", 
      "celula":"Celula 4", 
      "turno":"TURNO 1", 
      "horario":"C"
    },
    {
      "emp": {
        id_empresa: "154766",
        lname: "TORRES CASTA?ON",
        fname: "MYRNA AIDEE ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"ENSAMBLE", 
      "cliente":"BMW", 
      "celula":"Celula 1", 
      "turno":"TURNO 3", 
      "horario":"B"
    },
    {
      "emp": {
        id_empresa: "154684",
        lname: "GUTIERREZ OCHOA",
        fname: "ALFONSO ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"ENSAMBLE", 
      "cliente":"VW", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"B"
    },
    {
      "emp": {
        id_empresa: "154684",
        lname: "GUTIERREZ OCHOA",
        fname: "ALFONSO ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"ENSAMBLE", 
      "cliente":"POT 2", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"B"
    },
    {
      "emp": {
        id_empresa: "154684",
        lname: "GUTIERREZ OCHOA",
        fname: "ALFONSO ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"ENSAMBLE", 
      "cliente":"Linea 2", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"B"
    },
    {
      "emp": {
        id_empresa: "154684",
        lname: "GUTIERREZ OCHOA",
        fname: "ALFONSO ",
        job: "OPERADOR A",
        category: "DIRECTOS"
      },
      "area":"ENSAMBLE", 
      "cliente":"Linea 2", 
      "celula":"Celula 4", 
      "turno":"TURNO 2", 
      "horario":"B"
    }
  ];


});

rh.controller('home', function($scope, rhData, $http) {

  /*
  $scope.clientes = [
    {"nombre":"BMW"},
    {"nombre":"VW"},
    {"nombre":"BSUV"},
    {"nombre":"FCA"},
    {"nombre":"FORD"},
    {"nombre":"K2 XX"},
    {"nombre":"DU2"},
    {"nombre":"C1YX"}
  ];
  
  


  $http.get("rest/ver/1").success(
    function (data) {
      $scope.clientes = data;
      console.log(data);
    }
  );

  */

  

});


rh.controller('clientes', function($scope, rhData, $routeParams, $http) {

  $scope.area = $routeParams.area;

  
  $scope.ClientName = function (id) {
    
    if(id == 1) return "ENSAMBLE";
    if(id == 2) return "VULCANIZADO";
    if(id == 3) return "EXTRUSION";
    if(id == 4) return "PROTOTIPOS";
  }
  

  $http.get("rest/ver/" + $scope.area).success(
    function (data) {
      $scope.clientes = data;
      console.log(data);
    }
  );


});


rh.controller('detalleCli', function($scope, rhData, $routeParams, $http) {

  $scope.area = $routeParams.area;
  $scope.id = $routeParams.id;

  console.log("rest/ver/" + $scope.area + "/" + $scope.id);
  
  $http.get("rest/ver/" + $scope.area + "/" + $scope.id).success(
    function (data) {
      $scope.celulas = data;
      console.log(data);
    }
  );

});


rh.controller('turnos', function($scope, rhData, $routeParams, $http) {

  $scope.area = $routeParams.area;
  $scope.cli = $routeParams.cli;
  $scope.cel = $routeParams.cel;
  $scope.turno = 1;

});

rh.controller('horarios', function($scope, rhData, $routeParams, $http) {

  $scope.area =  $routeParams.area;
  $scope.cli =   $routeParams.cli;
  $scope.cel =   $routeParams.cel;
  $scope.turno = $routeParams.turno;

  $scope.horario = 1;

});


rh.controller('addEmpleado', function($scope, rhData, $routeParams, $http) {

  $scope.area = $routeParams.area;
  $scope.cli = $routeParams.cli;
  $scope.cel = $routeParams.cel;

  $scope.turno = $routeParams.turno;
  $scope.horario = $routeParams.horario;
  
  $scope.keypress = function($event) {
    console.log("keypress");
    if ($event.which === 13) //rh/app/rest/employee/28
      $http.get("rest/employee/" + $scope.empTmp ).success(
        function (data) {
      
          console.log(data);
          $scope.emp = data[0];
          $scope.empTmp = "";
      }
  );


}
  

});






