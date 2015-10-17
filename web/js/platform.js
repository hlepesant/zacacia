/**
 * Created by hugues on 12/10/2015.
 */
'use strict';

//var zacaciaAppControllers = angular.module('zacaciaAppControllers', []);

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
    function ($scope, $routeParams, $http) {
        $http.get('/api/platform/' + $routeParams.cn)
            .success(function (data) {
                $scope.platform = data;
                $scope.cn = $routeParams.cn;
            });
        
        $scope.submit = function () {
            var p = {
                params: {
                    'cn': $scope.cn,
                    'zacaciaStatus': $scope.zacaciaStatus
                }
            };

            var $promise = $http.put('/api/platform/' + $scope.cn, p)
                .success(function (data, status, headers, config) {
                    if (data.status === 'OK') {
                        $scope.cn = null;
                        $scope.zacaciaStatus = 'enable';
                        $scope.message = 'Update OK';
                    }
                });

        };
        
    }]);
