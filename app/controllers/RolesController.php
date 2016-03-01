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
	
	if(isset($params['admin']) && $params['admin'] == 'admin'){
        $role = new Role(array(
            'name'  => $params['name'],
		    'weight' => $params['weight'],
            'admin' => true,
        ));
	} else {
		$role = new Role(array(
			'name' => $params['name'],
			'weight' => $params['weight'],
			'admin' => false,
		));
	}

        $errors = $role->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/roles/create', array('errors' => $errors, 'attributes' => $params));
        }

        $role->save();

        Redirect::to('/roles#' . $role->id);
    }

    public static function edit($id)
    {
        $role = Role::find($id);

        if ($role == null) {
            flash()->error('Role was not found!');

            Redirect::to('/roles');
        }

        View::make('roles-edit.html', array('role' => $role));
    }

    public static function update($id)
    {
        $params = $_POST;
        $role   = Role::find($id);

        if ($role == null) {
            flash()->error('Role was not found!');

            Redirect::to('/roles');
        }

        $role->name  = $params['name'];
        $role->admin = isset($params['admin']);

        $errors = $role->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/roles/' . $role->id . '/edit', array('errors' => $errors, 'attributes' => $params));
        }

        $role->update();

        flash('Role updated successfully!');
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
