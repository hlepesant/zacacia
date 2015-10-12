/**
 * Created by hugues on 12/10/2015.
 */
'use strict';

var zacaciaApp = angular.module('zacaciaApp', [
    'ngRoute',
    'zacaciaAppControllers'
]);

zacaciaApp.config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider
            .when('/platform', {
                templateUrl: '/bundles/zacacia/templates/platform.html',
                controller: 'platformController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
]);
