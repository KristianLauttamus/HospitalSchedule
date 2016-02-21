<?php

class BaseController
{
    public static function get_user_logged_in()
    {
        if (isset($_SESSION['user'])) {
            return User::findWithRole($_SESSION['user']);
        }

        return null;
    }

    public static function check_logged_in()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }

        flash()->error('Et ole kirjautunut sisään!');
        Redirect::to('/login');
    }
}
