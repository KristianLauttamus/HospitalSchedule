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
