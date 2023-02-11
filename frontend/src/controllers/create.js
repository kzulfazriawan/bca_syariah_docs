module.exports = function($scope, $timeout, $location, $window, Http){
    $scope.error = null;
    $scope.field = {};
    $scope.alert = null;
    $scope.data  = {}

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

    $scope.create = function(){
        Http.sendAsJson("POST", "http://localhost:8000/api/ticket/create", {data: $scope.form, authentication: $window.localStorage.getItem("token")}).then(
            function success(response){
                console.log(response);
                $scope.alert = {
                    success: "Reply success"
                };

                setTimeout(
                    function(){
                        $window.location.href = "/#!/";
                    }, 2000
                )
            },
            function error(response){
                $scope.alert = {
                    error: response.data.message
                };
            }
        );
    }

}