<?php

class AuthController extends BaseController
{
    public static function login()
    {
        View::make('login.html');
    }

    public static function handle_login()
    {
        $params = $_POST;

        $user = User::authenticate($params['email'], $params['password']);

        if (!$user) {
            flash()->error(':(', 'Login failed');

            View::make('login.html', array('email' => $params['email']));
        } else {
            $_SESSION['user'] = $user->id;

            flash('Hey!', 'Nice to see you again');

            Redirect::to('/');
        }
    }

    public static function logout()
    {
        unset($_SESSION['user']);

        flash(':)', 'Bye!');

        Redirect::to('/');
    }

    public static function controlpanel()
    {
        View::make('controlpanel.html');
    }
}
