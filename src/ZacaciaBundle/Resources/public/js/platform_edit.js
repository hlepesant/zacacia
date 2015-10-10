/**
 * Created by hugues on 02/10/15.
 */

var app = angular.module('zacaciaApp', ['ngRoute']);

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/', {
                template: "het hop"
            })
            .when('/platform/:cn', {
                template: "het hop HIP",
                controller: 'PlatformController'
            })
            .otherwise({
                redirectTo: '/'
            });
}]);

/*
zacacia.controller('PlatformController', ['$scope', '$http',
    function($scope, $route, $routeParams, $http) {

        $http.get('/api/platform/'+$routeParams.cn).success(function(data) {
            $scope.cn = data.cn;
            $scope.zacaciaStatus = $data.zacaciaStatus;
        });
    }

]);
*/

app.controller('PlatformController', [
    '$scope', '$routeParams',
    function($scope, $routeParams) {
        
        $scope.cn = $routeParams.cn;
    
    /*
        $http.get('/api/platform/'+$routeParams.cn).success(function(data) {
            $scope.cn = $data.cn;
            $scope.zacaciaStatus = $data.zacaciaStatus;
        });
    */
    }]);


