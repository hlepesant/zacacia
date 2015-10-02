/**
 * Created by hugues on 02/10/15.
 */
'use strict';

angular.module('zacaciaApp', [
    'platformList'
]);


var platformList = angular.module('platformList',[]);

platformList.controller('PlatformController', ['$scope',
    function($scope) {

        var platforms = $scope.platforms = [];

        platforms.push({
            cn: 'Hugues'
        });

        platforms.push({
            cn: 'Marie'
        });


    }

]);
