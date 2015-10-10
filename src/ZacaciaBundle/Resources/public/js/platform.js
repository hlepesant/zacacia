/**
 * Created by hugues on 02/10/15.
 */

var zacacia = angular.module('zacaciaApp', []);

/*
zacacia.controller('PlatformController', ['$scope', '$http',
    function($scope, $http) {

        var platforms = $scope.platforms = [];

        $http.get('/api/platform').success(function(data) {
            $scope.platforms = data;
        });
    });
]);
*/

zacacia.controller('PlatformController',
    function($scope, $http) {
        var platforms = $scope.platforms = [];
        $http.get('/api/platform').success(function(data) {
            $scope.platforms = data;
        });
    });
