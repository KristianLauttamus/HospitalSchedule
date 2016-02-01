<?php

class RolesController extends BaseController
{

    public static function index()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('roles.html');
    }

    public static function create()
    {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('roles-create.html');
    }
}
