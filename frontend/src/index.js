require("./less/main.less");

import 'bootstrap/dist/css/bootstrap.min.css';

// Angularjs require
var angular = require("angular");
require("angular-route");
require("ng-file-upload");
require("angular-sanitize");

// AngularJS module working
var app = angular.module("App", ["ngRoute", "ngFileUpload", "ngSanitize"]);

app.config(function($interpolateProvider, $routeProvider) {
    let route = $routeProvider;
    route.when(
        "/login/",
        {
            templateUrl: "/pages/login.html",
            controller: "Login"
        }
    );

    route.when(
        "/",
        {
            templateUrl: "/pages/homepage.html",
            controller: "Dashboard"
        }
    );

    route.when(
        "/create/",
        {
            templateUrl: "/pages/create.html",
            controller: "Create"
        }
    );

    route.when(
        "/detail/:id",
        {
            templateUrl: "/pages/detail.html",
            controller: "Detail"
        }
    );

});

// Factories
app.factory("Http", require("./factories/http"));

// Controllers app
app.controller("Login" , require("./controllers/login"));
app.controller("Dashboard" , require("./controllers/dashboard"));
app.controller("Detail" , require("./controllers/detail"));
app.controller("Create" , require("./controllers/create"));

