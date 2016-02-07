<?php

$routes->get('/', function () {
    HomeController::index();
});

$routes->get('/users', function () {
    UsersController::index();
});
$routes->get('/users/create', function () {
    UsersController::create();
});

$routes->get('/roles', function () {
    RolesController::index();
});
$routes->get('/roles/create', function () {
    RolesController::create();
});
$routes->get('/roles/store', function () {
    RolesController::store();
});

$routes->get('/hiekkalaatikko', function () {
    HelloWorldController::sandbox();
});
