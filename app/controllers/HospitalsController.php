<?php

class HospitalsController extends BaseController
{

    public static function index()
    {
        $hospitals = Hospital::all();

        View::make('hospitals.html', array('hospitals' => $hospitals));
    }

    public static function create()
    {
        $importances = Importance::allWithRoles();

        if (count($importances) <= 0) {
            flash()->error(':(', 'No Importances found!');

            Redirect::to('/importances/create');
        }

        View::make('hospitals-create.html', array('importances' => $importances));
    }

    public static function store()
    {
        $params = $_POST;

        $hospital = new Hospital(array(
            'name'       => $params['name'],
            'open_time'  => $params['open_time'],
            'close_time' => $params['close_time'],
        ));

        $errors = $hospital->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/hospitals/create', array('errors' => $errors, 'attributes' => $params));
        }

        $hospital->save();

        for ($i = 1; $i <= 24; $i++) {
            $hour = new Hour(array(
                'at'            => $i,
                'hospital_id'   => $hospital->id,
                'importance_id' => $params['importance_id'],
            ));

            $hour->save();
        }

        Redirect::to('/hospitals#' . $hospital->id);
    }

    public static function edit($id)
    {
        $hospital = Hospital::find($id);

        if ($hospital == null) {
            flash()->error('Hospital was not found!');

            Redirect::to('/hospitals');
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
