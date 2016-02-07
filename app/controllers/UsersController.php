<?php

class UsersController extends BaseController
{

    public static function index()
    {
        $users = User::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('users.html', array('users' => $users));
    }

    public static function create()
    {
        $roles = Role::all();

        // Jos rooleja ei löydy niin luodaan rooli ensin
        if ($roles == null ||  count($roles) < 0) {
            Redirect::to('/roles/create');
        }

        View::make('users-create.html');
    }

    public static function store()
    {
        $params = $_POST;

        $user = new User(array(
            'name'     => $params['name'],
            'email'    => $params['email'],
            'password' => $params['password'],
            'role_id'  => $params['role_id'],
        ));

        $user->save();

        Redirect::to('/users/#' . $user->id);
    }
}
