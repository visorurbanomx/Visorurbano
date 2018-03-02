var servicios;
var detalle;
angular.module('MyApp',[])
        .controller("AppCtrl", function ($scope, $http) {


            var req = {
                    method: 'GET',
                    url: 'coordinaciones.php'
                };
                $http(req)
                        .success(function (data) {
                            if (data.status)
                            {
                                $scope.datos = data.data;                
                            }
                            else {
                                sweetAlert("Oops...", "No hay datos que mostrar", "warning");
                            }
                        })
                        .error(function (error) {
                           alert('Error. Intente de nuevo mas tarde');
                        });


            $scope.redirect = function (url) {
                window.open(url);
            };
            
            
        });
        