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
        View::make('hospitals-create.html';
    }

    public static function store()
    {
        $params = $_POST;

        $hospital = new Hospital(array(
            'name' => $params['name'],
        ));

        $hospital->save();

        Redirect::to('/hospitals#' . $hospital->id);
    }
}
