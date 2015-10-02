/**
 * Created by hugues on 02/10/15.
 */
'use strict';

angular.module('zacaciaApp', [
    'platformList'
]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


var platformList = angular.module('platformList',[]);

platformList.controller('platformCtrl', ['$scope',
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
