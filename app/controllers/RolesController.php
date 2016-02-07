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

    public static function store()
    {
        $params = $_POST;

        $role = new Role(array(
            'name'  => $params['name'],
            'admin' => isset($params['admin']),
        ));

        $role->save();

        Redirect::to('/roles/#' . $role->id);
    }
}
