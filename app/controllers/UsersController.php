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
        if ($roles == null || empty($roles)) {
            flash()->error('No Roles found!');

            Redirect::to('/roles/create');
        }

        View::make('users-create.html', array('roles' => $roles));
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

        $errors = $user->errors();
        if (count($errors) > 0) {
            // Todo error message

            Redirect::to('/users/create', array('errors' => $errors, 'attributes' => $params));
        }

        $user->save();

        Redirect::to('/users#' . $user->id);
    }

    public static function edit($id)
    {
        $user = User::find($id);

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/users');
        }

        $roles = Role::all();

        // Jos rooleja ei löydy niin luodaan rooli ensin
        if ($roles == null || empty($roles)) {
            flash()->error('No Roles found!');

            Redirect::to('/roles/create');
        }

        View::make('users-edit.html', array('user' => $user, 'roles' => $roles));
    }

    public static function update($id)
    {
        $params = $_POST;
        $user   = User::find($id);

        if ($user == null) {
            flash()->error('User was not found!');

            Redirect::to('/users');
        }

        $user->name     = $params['name'];
        $user->email    = $params['email'];
        $user->password = $params['password'];
        $user->role_id  = $params['role_id'];

        $errors = $user->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/users/' . $user->id . '/edit', array('errors' => $errors, 'attributes' => $params));
        }

        $user->update();

        flash('User updated successfully!');
        Redirect::to('/users#' . $user->id);
    }

    public static function destroy($id)
    {
        $user = User::find($id);

        $user->destroy();

        flash('User removed successfully!');

        Redirect::to('/users');
    }
}
