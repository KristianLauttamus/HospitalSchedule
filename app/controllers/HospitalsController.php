<?php

class HospitalsController extends BaseController
{

    public static function index()
    {
        $hospitals = Hospital::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('hospitals.html', array('hospitals' => $hospitals));
    }

    public static function create()
    {
        View::make('hospitals-create.html');
    }

    public static function store()
    {
        $params = $_POST;

        $hospital = new Hospital(array(
            'name' => $params['name'],
        ));

        $errors = $hospital->errors();
        if (count($errors) > 0) {
            flash()->error(':(', 'Something was a little off...');

            Redirect::to('/hospitals/create', array('errors' => $errors, 'attributes' => $params));
        }

        $hospital->save();

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
