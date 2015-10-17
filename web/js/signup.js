/**
 * Created by hugues on 12/10/2015.
 */
'use strict';

//var zacaciaAppControllers = angular.module('zacaciaAppControllers', []);

zacaciaAppControllers.controller('SignupController', [
    '$scope',
    '$http',
    function ($scope, $http) {
        var platforms = $scope.platforms = [];
        $http.get('/api/platform').success(function (data) {
            $scope.platforms = data;
        });
    }
]);