<?php

$routes->get('/', function () {
    HomeController::index();
});

// Auth
$routes->get('/login', function () {
    AuthController::login();
});
$routes->post('/login', function () {
    AuthController::handle_login();
});
$routes->get('/logout', function () {
    AuthController::logout();
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
$routes->get('/users/:id/destroy', function ($id) {
    UsersController::destroy($id);
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
$routes->get('/roles/:id/edit', function ($id) {
    RolesController::edit($id);
});
$routes->post('/roles/:id/update', function ($id) {
    RolesController::update($id);
});
$routes->get('/roles/:id/destroy', function ($id) {
    RolesController::destroy($id);
});

// Hospitals
$routes->get('/hospitals', function () {
    HospitalsController::index();
});
$routes->get('/hospitals/create', function () {
    HospitalsController::create();
});
$routes->post('/hospitals/store', function () {
    HospitalsController::store();
});
$routes->get('/hospitals/:id/destroy', function ($id) {
    HospitalsController::destroy($id);
});
