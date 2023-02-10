module.exports = function($scope, $timeout, $location, $window, Http){
    $scope.error = null;
    $scope.field = {};
    $scope.alert = null;
    $scope.data  = {}

    console.log($window.localStorage.getItem("token"));

    $scope.init = function(){
        Http.sendGet("http://localhost:8000/api/auth/profile", $window.localStorage.getItem("token")).then(
            function success(response){
                $scope.data = {
                    "name": response.data.name,
                    "username": response.data.username,
                    "role": response.data.is_admin
                }
            },
            function error(response){
                $window.location.href = "/#!/login/";
            }
        );
    }
}