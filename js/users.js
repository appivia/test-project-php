

function UsersCtrl($scope, $http) {
	$scope.users = [];

	var master = {
		name: "John",
		email: "",
		city: "",
		phone: ""
	};

	$scope.user = angular.copy(master);

	$scope.addUser = function () {
		$scope.users.push($scope.user);

		// console.log($scope.users);
		$scope.user = angular.copy(master);
	};

	$scope.phone = /^\+?[\d\(\)\-\ ]+$/;
	$scope.name = /^[\w\s]+$/;
	$scope.city = /^[\w\s\d,-]+$/;
}