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
            .when('/signup', {
                templateUrl: '/templates/signup.html',
                controller: 'signupController'
            })
            .when('/platform', {
                templateUrl: '/templates/platform.html',
                controller: 'platformController'
            })
            .when('/platform/:cn/edit', {
                templateUrl: '/templates/platform_edit.html',
                controller: 'platformEditController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
]);
