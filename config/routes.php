<?php

/**
 * Middleware
 */
function guest()
{
    if (BaseController::get_user_logged_in() != null) {
        Redirect::to('/');
    }
}
function auth()
{
    BaseController::check_logged_in();
}
function admin()
{
    BaseController::check_logged_in();

    $user = BaseController::get_user_logged_in();

    if ($user == null || $user->role == null || !$user->role->isAdmin()) {
        flash()->error(':(', 'Ei oikeuksia tälle sivulle');

        Redirect::to('/');
    }
}

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
