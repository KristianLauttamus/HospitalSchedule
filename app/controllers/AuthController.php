<?php

class AuthController extends BaseController
{
    public static function login()
    {
        View::make('user/login.html');
    }

    public static function handle_login()
    {
        $params = $_POST;

        $user = User::authenticate($params['email'], $params['password']);

        if (!$user) {
            // Todo error message
            View::make('user/login.html', array('email' => $params['email']));
        } else {
            $_SESSION['user'] = $user->id;

            // Todo login succeeds message

            Redirect::to('/');
        }
    }

    public static function logout()
    {
        unset($_SESSION['user']);

        // Todo logout successful message

        Redirect::to('/');
    }
}
