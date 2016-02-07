<?php

class UsersController extends BaseController
{

    public static function index()
    {
        $users = User::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('users.html', ['users' => $users]);
    }

    public static function create()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('users-create.html');
    }
}
