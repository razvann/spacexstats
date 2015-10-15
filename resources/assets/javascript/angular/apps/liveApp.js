(function() {
    var liveApp = angular.module('app', []);

    liveApp.controller('liveController', ["$scope", "liveService", "Section", "Resource", "Message", function($scope, liveService, Section, Resource, Message) {
        $scope.auth = laravel.auth;
        $scope.isActive = laravel.isActive;
        $scope.messages = laravel.messages;

        $scope.data = {
            upcomingMission: laravel.mission
        };

        $scope.settings = {
            isGettingStarted: laravel.isActive == true ? null : false,
            getStartedHeroText: 'You are the launch controller.',
            getStarted: function() {
                this.isGettingStarted = true;
                this.getStartedHeroText = 'Awesome. We just need a bit of info first.'
            },
            turnOnSpaceXStatsLive: function() {
                liveService.create($scope.startingParameters).then(function() {
                    $scope.isActive = true;
                    $scope.settings.isGettingStarted = null;
                });
            },
            turnOffSpaceXStatsLive: function() {
                liveService.destroy().then(function() {
                    $scope.isActive = false;
                });
            },
            addSection: function(section) {
                $scope.liveParameters.sections.push(new Section(section));
            },
            removeSection: function(section) {

            },
            addResource: function(resource) {
                $scope.liveParameters.resources.push(new Resource(resource));
            },
            removeResource: function(resource) {

            },
            updateSettings: function() {
                liveService.updateSettings($scope.liveParameters);
            }
        };

        $scope.liveParameters = {
            isForLaunch: true,
            threadName: '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread',
            toggleForLaunch: function() {
                if (this.isForLaunch) {
                    this.threadName = '/r/SpaceX ' + $scope.data.upcomingMission.name + ' Official Launch Discussion & Updates Thread';
                } else {
                    this.threadName = null;
                }

            },
            countdownTo: null,
            streamingSources: {
                nasa: false,
                spacex: false
            },
            description: null,
            sections: [],
            resources: []
        };

        $scope.send = {
            new: {
                message: null
            },
            /*
             * Send a launch update (message) via POST off to the server to be broadcast
             */
            message: function() {
                liveService.sendMessage({
                    id: $scope.messages.length + 1,
                    datetime: moment(),
                    message: $scope.send.new.message,
                    messageType: $scope.send.new.messageType
                });

                $scope.update.message = "";
            }
        }

        //var socket = io();
    }]);

    liveApp.service('liveService', ["$http", function($http) {

        this.sendMessage = function(message) {
            return $http.post('/live/send/message', message);
        }

        this.updateSettings = function(settings) {
            return $http.post('/live/send/updateSettings', settings);
        }

        this.create = function(createThreadParameters) {
            return $http.post('/live/send/create', createThreadParameters);
        }

        this.destroy = function() {
            return $http.post('/live/send/destroy');
        }

    }]);

    liveApp.factory('Message', function() {
        return function() {

        }
    });

    liveApp.factory('Resource', function() {
        return function() {

        }
    });

    liveApp.factory('Section', function() {
        return function() {

        }
    });
})();