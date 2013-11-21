

function UsersCtrl($scope, $http) {
	$scope.users = [];

	var master = {
		name: "John",
		email: "",
		city: "",
		phone_number: ""
	};

	$scope.user = angular.copy(master);

	$scope.addUser = function (form) {
		if (form.$valid) {
			$http.post('/create.php', $scope.user).success(function () {
				$scope.users.push($scope.user);
				$scope.user = angular.copy(master);
			});
		}
	};

	$scope.phone = /^\+?[\d\(\)\-\ ]+$/;
	$scope.name = /^[\w\s]+$/;
	$scope.city = /^[\w\s\d,-]+$/;
}