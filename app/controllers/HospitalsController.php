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
            // Todo error message

            Redirect::to('/hospitals/create', array('errors' => $errors, 'attributes' => $params));
        }

        $hospital->save();

        Redirect::to('/hospitals#' . $hospital->id);
    }
}
