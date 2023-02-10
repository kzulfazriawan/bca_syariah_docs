module.exports = function($scope, $timeout, $location, $window, Http){
    $scope.error = null;
    $scope.field = {};
    $scope.alert = null;
    $scope.form  = {
        username: null,
        password: null
    }

    $scope.login = function(){
        Http.sendAsJson("POST", "http://localhost:8000/api/auth/login", {data: $scope.form}).then(
            function success(response){
                console.log(response);
                $scope.alert = {
                    success: "Login success"
                };
                $window.localStorage.setItem("token", response.data.token);

                setTimeout(
                    function(){
                        $window.location.href = "/#!/";
                    }, 3000
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