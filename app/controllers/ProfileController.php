<?php

class ProfileController extends BaseController
{
    public static function edit()
    {
        $user = get_user_logged_in();

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/');
        }

        View::make('profile-edit.html', array('user' => $user));
    }

    public static function update()
    {
        $params = $_POST;
        $user   = get_user_logged_in();

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/users');
        }

        $user->name  = $params['name'];
        $user->email = $params['email'];

        $errors = $user->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/profile/edit', array('errors' => $errors, 'attributes' => $params));
        }

        $user->update();

        flash(':)', 'Profile updated successfully!');
        Redirect::to('/');
    }

    public static function password()
    {
        $user = get_user_logged_in();

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/');
        }

        View::make('profile-password-edit.html');
    }

    public static function passwordUpdate()
    {
        $params = $_POST;
        $user   = get_user_logged_in();

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/users');
        }

        $user->password = $params['password'];

        $errors = $user->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/profile/edit', array('errors' => $errors, 'attributes' => $params));
        }

        $user->update();

        flash(':)', 'Password updated successfully!');
        Redirect::to('/');
    }
}
