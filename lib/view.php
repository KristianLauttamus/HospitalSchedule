<?php

class View
{

    public static function make($view, $content = array())
    {
        // Alustetaan Twig
        $twig = self::get_twig();

        try {
            // Asetetaan uudelleenohjauksen yhteydessä lisätty viesti
            self::set_flash_message($content);

            // Asetetaan näkymään base_path-muuttuja index.php:ssa määritellyllä BASE_PATH vakiolla
            $content['base_path'] = BASE_PATH;

            // Asetetaan näkymään kirjautunut käyttäjä, jos get_user_logged_in-metodi on toteutettu
            if (method_exists('BaseController', 'get_user_logged_in')) {
                $content['user_logged_in'] = BaseController::get_user_logged_in();
            }

            // Tulostetaan Twig:n renderöimä näkymä
            echo $twig->render($view, $content);

            // Poistetaan Sweetalert sessiosta renderöinnin jälkeen
            if (isset($_SESSION['alert'])) {
                unset($_SESSION['alert']);
            }
        } catch (Exception $e) {
            die('Virhe näkymän näyttämisessä: ' . $e->getMessage());
        }

        exit();
    }

    private static function get_twig()
    {
        Twig_Autoloader::register();

        $twig_loader = new Twig_Loader_Filesystem('app/views');

        $twig_environment = new Twig_Environment($twig_loader);
        $twig_environment->addGlobal('session', $_SESSION);
        return $twig_environment;
    }

    private static function set_flash_message(&$content)
    {
        if (isset($_SESSION['flash_message'])) {

            $flash = json_decode($_SESSION['flash_message']);

            foreach ($flash as $key => $value) {
                $content[$key] = $value;
            }

            unset($_SESSION['flash_message']);
        }
    }

}
