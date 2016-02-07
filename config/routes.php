<?php

$routes->get('/', function () {
    HomeController::index();
});

// Users
$routes->get('/users', function () {
    UsersController::index();
});
$routes->get('/users/create', function () {
    UsersController::create();
});
$routes->post('/users/store', function () {
    UsersController::store();
});

// Roles
$routes->get('/roles', function () {
    RolesController::index();
});
$routes->get('/roles/create', function () {
    RolesController::create();
});
$routes->post('/roles/store', function () {
    RolesController::store();
});
