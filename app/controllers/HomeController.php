<?php

class HomeController extends BaseController
{

    public static function index()
    {
        $hospitals = Hospital::all();
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html', array('hospitals' => $hospitals));
    }
}
