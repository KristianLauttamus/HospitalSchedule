<?php

$routes->get('/', function () {
    HomeController::index();
});

// Auth
$routes->get('/login', 'guest', function () {
    AuthController::login();
});
$routes->post('/login', 'guest', function () {
    AuthController::handle_login();
});
$routes->get('/logout', 'auth', function () {
    AuthController::logout();
});

// Profile
$routes->get('/profile/edit', 'auth', function () {
    ProfileController::edit();
});
$routes->post('/profile/update', 'auth', function () {
    ProfileController::edit();
});
$routes->get('/profile/password', 'auth', function () {
    ProfileController::password();
});
$routes->post('/profile/password/update', 'auth', function () {
    ProfileController::updatePassword();
});

// Controlpanel
$routes->get('/controlpanel', 'admin', function () {
    AuthController::controlpanel();
});

// Users
$routes->get('/users', 'admin', function () {
    UsersController::index();
});
$routes->get('/users/create', 'admin', function () {
    UsersController::create();
});
$routes->post('/users/store', 'admin', function () {
    UsersController::store();
});
$routes->get('/users/:id/destroy', 'admin', function ($id) {
    UsersController::destroy($id);
});

// Roles
$routes->get('/roles', 'admin', function () {
    RolesController::index();
});
$routes->get('/roles/create', 'admin', function () {
    RolesController::create();
});
$routes->post('/roles/store', 'admin', function () {
    RolesController::store();
});
$routes->get('/roles/:id/edit', 'admin', function ($id) {
    RolesController::edit($id);
});
$routes->post('/roles/:id/update', 'admin', function ($id) {
    RolesController::update($id);
});
$routes->get('/roles/:id/destroy', 'admin', function ($id) {
    RolesController::destroy($id);
});

// Hospitals
$routes->get('/hospitals', 'admin', function () {
    HospitalsController::index();
});
$routes->get('/hospitals/create', 'admin', function () {
    HospitalsController::create();
});
$routes->post('/hospitals/store', 'admin', function () {
    HospitalsController::store();
});
$routes->get('/hospitals/:id/allocate', 'admin', function ($id) {
    HospitalsController::allocate($id);
});
$routes->get('/hospitals/:id/allocation', 'admin', function ($id) {
    HospitalsController::allocation($id);
});
$routes->get('/hospitals/:id/edit', 'admin', function ($id) {
    HospitalsController::edit($id);
});
$routes->post('/hospitals/:id/update', 'admin', function ($id) {
    HospitalsController::update($id);
});
$routes->get('/hospitals/:id/destroy', 'admin', function ($id) {
    HospitalsController::destroy($id);
});

// Importances
$routes->get('/importances', 'admin', function () {
    ImportancesController::index();
});
$routes->get('/importances/create', 'admin', function () {
    ImportancesController::create();
});
$routes->post('/importances/store', 'admin', function () {
    ImportancesController::store();
});
