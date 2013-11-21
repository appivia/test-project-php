/**
 * Shows a flash message on page
 *
 * @param type type of flash message success, danger, info, warning
 * @param message message
 * @return
 */
function showFlash(type, message) {
    $(function () {
        var tmpl = '<div class="alert alert-'+type+' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+message+'</div>';
        var alert = $('#header').append( $.parseHTML(tmpl) );
        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });
}
// initialize angular.js application
var app = angular.module('myApp', []);

// set up filter for pagination
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

// Angular js controller for users view
function UsersCtrl($scope, $http, $window, $filter) {

    // get users from view.index.php, so we dont have to do a http request
    $scope.users = $window.users;

    // set up paginator
    $scope.pageSize = 20;
    $scope.currentPage = 0;

    // returns actual pages count
    $scope.pagesNumber = function() {
        // return Math.ceil($filter('filter')($scope.users, $scope.cityFilter).length/$scope.pageSize);
        return Math.ceil($scope.users.length/$scope.pageSize);
    };

    // return an array for building paginator
    $scope.pagesNumberArray = function() {
        var arr = [];
        for (var i = 0; i < $scope.pagesNumber(); i++) {
            arr.push(i);
        }
        return arr;
    };

    // sets current page of paginator
    $scope.setCurrentPage = function(page) {
        if (page >= 0 && page < $scope.pagesNumber()) {
            $scope.currentPage = page;
        }
    };

    // default values for form
    var master = {
        name: "",
        email: "",
        city: "",
        phone_number: ""
    };

    // get instance of users table, we will append new users there on user creation
    var usersTable = $('.users-table tbody');

    // set form data
    $scope.user = angular.copy(master);

    // on form submit
    $scope.addUser = function (form) {
        if (form.$valid) {
            $http.post('/create.php', $scope.user).success(function () {
                $scope.users.push($scope.user);
                showFlash('success', 'User <strong>'+escape($scope.user.name)+'</strong> was successfuly created.');
                $scope.user = angular.copy(master);
            }).error(function () {
                showFlash('danger', 'User <strong>'+escape($scope.user.name)+'</strong> couldn\'t be created, server error.');
            });
        }
    };

    // patterns for validation
    $scope.phone = /^\+?[\d\(\)\-\ ]+$/;
    $scope.name = /^[\w\s]+$/;
    $scope.city = /^[\w\s\d,-]+$/;
}