(function () {
    'use strict';

    angular.module('zapp', [
        'ngStorage',
        'ngRoute',
        'angular-loading-bar'
    ])
        .constant('urls', {
            BASE: '/api'
        })
        .config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
            $routeProvider.
                when('/', {
                    templateUrl: 'partials/home.html',
                    controller: 'ZacaciaController'
                }).
                when('/signin', {
                    templateUrl: 'partials/signin.html',
                    controller: 'ZacaciaController'
                }).
/*            
                when('/signup', {
                    templateUrl: 'partials/signup.html',
                    controller: 'ZacaciaController'
                }).
*/                
                otherwise({
                    redirectTo: '/signin'
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
                            delete $localStorage.token;
                            $location.path('/signin');
                        }
                        return $q.reject(response);
                    }
                };
            }]);
        }
        ]).run(function($rootScope, $location, $localStorage) {
            $rootScope.$on( "$routeChangeStart", function(event, next) {
                if ($localStorage.token == null) {
                    if ( next.templateUrl === "partials/restricted.html") {
                        $location.path("/signin");
                    }
                }
            });
        });
})();
