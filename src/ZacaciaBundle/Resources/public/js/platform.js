/**
 * Created by hugues on 02/10/15.
 */

var zacacia = angular.module('zacaciaApp', []);

zacacia.controller('PlatformController', ['$scope', '$http',
    function($scope, $http) {

        var platforms = $scope.platforms = [];

        $http.get('/api/platforms').success(function(data) {
            $scope.platforms = data;
        });
    }

]);
