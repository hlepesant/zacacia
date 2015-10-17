/**
 * Created by hugues on 12/10/2015.
 */
'use strict';

zacaciaApp.config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider
            .when('/signup', {
                templateUrl: '/templates/signup.html',
                controller: 'SignupController'
            })
            .when('/platform', {
                templateUrl: '/templates/platform.html',
                controller: 'PlatformController'
            })
            .when('/platform/:cn/edit', {
                templateUrl: '/templates/platform_edit.html',
                controller: 'PlatformEditController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
]);
