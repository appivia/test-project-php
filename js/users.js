
function showFlash(type, message) {
    $(function () {
        var tmpl = '<div class="alert alert-'+type+' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+message+'</div>';
        var alert = $('#header').append( $.parseHTML(tmpl) );
        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });
}

function UsersCtrl($scope, $http, $window) {
    $scope.users = $window.users;

    var master = {
        name: "John",
        email: "",
        city: "",
        phone_number: ""
    };

    var usersTable = $('.users-table tbody');

    $scope.user = angular.copy(master);

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

    $scope.phone = /^\+?[\d\(\)\-\ ]+$/;
    $scope.name = /^[\w\s]+$/;
    $scope.city = /^[\w\s\d,-]+$/;
}