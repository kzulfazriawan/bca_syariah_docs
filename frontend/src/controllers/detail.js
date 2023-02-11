module.exports = function($scope, $timeout, $routeParams, $window, Http){
    $scope.error = null;
    $scope.field = {};
    $scope.alert = null;
    $scope.data  = {}
    $scope.form  = {};

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

    let ticket = function(){
        Http.sendGet("http://localhost:8000/api/ticket/" + $routeParams.id, $window.localStorage.getItem("token")).then(
            function success(response){
                $scope.data.ticket = response.data.ticket;
                $scope.data.reply = response.data.reply;
            },
            function error(response){
                $window.location.href = "/#!/login/";
            }
        );
    }

    $scope.ticket = function(){
        ticket();
    }

    $scope.reply = function(){
        Http.sendAsJson("POST", "http://localhost:8000/api/ticket/reply/" + $routeParams.id, {data: $scope.form, authentication: $window.localStorage.getItem("token")}).then(
            function success(response){
                console.log(response);
                $scope.alert = {
                    success: "Reply success"
                };

                $scope.form.content = "";

                ticket();
            },
            function error(response){
                $scope.alert = {
                    error: response.data.message
                };
            }
        );
    }
}