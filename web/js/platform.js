/**
 * Created by hugues on 12/10/2015.
 */

var zacaciaAppControllers = angular.module('zacaciaAppControllers', []);

zacaciaAppControllers.controller('platformController', [
    '$scope',
    '$http',
    function ($scope, $http) {
        var platforms = $scope.platforms = [];
        $http.get('/api/platform').success(function (data) {
            $scope.platforms = data;
        });
    }
]);


zacaciaAppControllers.controller('platformEditController', [
    '$scope',
    '$routeParams',
    '$http',
    function($scope, $routeParams, $http) {
        $http.get('/api/platform/'+$routeParams.cn)
            .success(function(data) {
                $scope.platform = data;
            });
    }]);
