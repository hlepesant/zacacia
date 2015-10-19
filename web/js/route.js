(function() {

    'use strict';

zacaciaApp.config([
    '$routeProvider',
    function ($routeProvider) {
        $routeProvider
            .when('/signin', {
                templateUrl: '/partials/signin.html',
                controller: 'SigninController'
            })
            /*
            .when('/platform', {
                templateUrl: '/partials/platform.html',
                controller: 'PlatformController'
            })
            .when('/platform/:cn/edit', {
                templateUrl: '/partials/platform_edit.html',
                controller: 'PlatformEditController'
            })
            */
            .otherwise({
                redirectTo: '/'
            });
    }
]);
