<?php

class UsersController extends BaseController
{

    public static function index()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('users.html');
    }

    public static function create()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('users-create.html');
    }
}
