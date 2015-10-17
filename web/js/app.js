(function() {
    'use strict';

    angular.module('app', [
        'ngStorage',
        'ngRoute',
        'zacaciaAppControllers'
    ])
        .constant('urls', {
            BASE: '/',
            BASE_API: '/api/'
        })
        .config(['$routeProvider', '$httpProvider', function ($routeProvider) {
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

            $httpProvider.interceptors.push(['$q', '$location', '$localStorage', function ($q, $location, $localStorage) {
                return {
                    'request': function (config) {
                        config.headers = config.headers || {};
                        if ($localStorage.token) {
                            config.headers.Authorization = 'Bearer ' + $localStorage.token;
                        }
                        return config;
                    },
                    'responseError': function (response) {
                        if (response.status === 401 || response.status === 403) {
                            $location.path('/signin');
                        }
                        return $q.reject(response);
                    }
                };
            }]);
        }]
    );
})();

