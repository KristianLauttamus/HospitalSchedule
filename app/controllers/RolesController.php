<?php

class RolesController extends BaseController
{

    public static function index()
    {
        $roles = Role::all();

        View::make('roles.html', array('roles' => $roles));
    }

    public static function create()
    {
        View::make('roles-create.html');
    }

    public static function store()
    {
        $params = $_POST;

        $role = new Role(array(
            'name'  => $params['name'],
            'admin' => isset($params['admin']),
        ));

        $errors = $role->errors();
        if (count($errors) > 0) {
            // Todo error message

            Redirect::to('/roles/create', array('errors' => $errors, 'attributes' => $params));
        }

        $role->save();

        Redirect::to('/roles#' . $role->id);
    }

    public static function destroy($id)
    {
        $role = Role::find($id);

        $role->destroy();

        flash('Role removed successfully!');

        Redirect::to('/roles');
    }
}
