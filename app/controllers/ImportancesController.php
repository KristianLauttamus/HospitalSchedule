<?php

class ImportancesController extends BaseController
{

    public static function index()
    {
        $importances = Importance::allWithRoles();

        View::make('importances.html', array('importances' => $importances));
    }

    public static function create()
    {
        $roles = Role::all();

        if (count($roles) <= 0) {
            flash()->error(':(', 'Rooleja ei löytynyt');

            Redirect::to('/roles/create');
        }

        View::make('importances-create.html', array('roles' => $roles));
    }

    public static function store()
    {
        $params = $_POST;

        $importance = new Importance();

        $errors = $importance->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/importances/create', array('errors' => $errors, 'attributes' => $params));
        }

        $importance->save();

        foreach ($params['roles'] as $role) {
            $importanceRole = new ImportanceRole(array(
                'importance_id' => $importance->id,
                'role_id'       => $role['role_id'],
                'needed'        => $role['needed'],
            ));
            $importanceRole->save();
        }

        Redirect::to('/importances#' . $importance->id);
    }

    public static function edit($id)
    {
        $hospital = Hospital::find($id);

        if ($hospital == null) {
            flash()->error('Importance was not found!');

            Redirect::to('/importances');
        }

        View::make('hospitals-edit.html', array('hospital' => $hospital));
    }

    public static function update($id)
    {
        $params   = $_POST;
        $hospital = Hospital::find($id);

        if ($hospital == null) {
            flash()->error('Hospital was not found!');

            Redirect::to('/hospitals');
        }

        $hospital->name = $params['name'];

        $errors = $hospital->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/hospitals/' . $hospital->id . '/edit', array('errors' => $errors, 'attributes' => $params));
        }

        $hospital->update();

        flash('Hospital updated successfully!');
        Redirect::to('/hospitals#' . $hospital->id);
    }

    public static function destroy($id)
    {
        $hospital = Hospital::find($id);

        $hospital->destroy();

        flash('Hospital removed successfully!');

        Redirect::to('/hospitals');
    }
}
